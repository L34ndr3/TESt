<?php

class MarqueController {

    private $requestMethod;
    private $marqueId = null;

    public function __construct($requestMethod, $id) {
        $this->requestMethod = $requestMethod;
		$this->marqueId = $id;
    }

    public function processRequest() {
		
		$response = $this->notFoundResponse();
		
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->marqueId) {
                    $response = $this->getMarque($this->marqueId);
                } else {
                    $response = $this->getAllMarques();
                };
                break;
            case 'POST':
				if (empty($this->marqueId)) {
					$response = $this->createMarque();
				}
                break;
            case 'PUT':
				if (empty($this->marqueId)) {
					$response = $this->updateMarque();
				}
                break;
            case 'DELETE':
                $response = $this->deleteMarque($this->marqueId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
		echo $response['body'];
    }

    private function getMarque($id) {	
		$result = MarqueDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    public function getAllMarques() {		
        $result = MarqueDAO::getList();
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result);
      
        return $response;
    }

    private function createMarque(){
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["nom"])) {
            return $this->unprocessableEntityResponse();
        }
		$marque = new MarqueDTO($input["nom"]);
		MarqueDAO::insert($marque);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 Created';
        $response['body'] = json_encode($marque);
        return $response;
    }

    private function updateMarque() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
		
        if (empty($input["nom"]) || empty($input["id"])) {
            return $this->unprocessableEntityResponse();
        }
		
		$result = MarqueDAO::get($input["id"]);
        if ($result == null) {
            return $this->notFoundResponse();
        }
		
		$result->setNom($input["nom"]);
		MarqueDAO::update($result);
   
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteMarque($id) {
        $result = MarqueDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }
		
        MarqueDAO::delete($id);
		
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 202 Successful deletion';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function unprocessableEntityResponse() {
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse() {
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}