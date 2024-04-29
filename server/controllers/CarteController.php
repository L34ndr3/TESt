<?php

class CarteController {

    private $requestMethod;
    private $carteId = null;

    public function __construct($requestMethod, $id) {
        $this->requestMethod = $requestMethod;
		$this->carteId = $id;
    }

    public function processRequest() {
		
		$response = $this->notFoundResponse();
		
        switch ($this->requestMethod) {
            case 'GET':
                if ($this->carteId) {
                    $response = $this->getCarte($this->carteId);
                } else {
                    $response = $this->getAllCartes();
                };
                break;
            case 'POST':
				if (empty($this->carteId)) {
					$response = $this->createCarte();
				}
                break;
            case 'PUT':
				if (empty($this->carteId)) {
					$response = $this->updateCarte();
				}
                break;
            case 'DELETE':
                $response = $this->deleteCarte($this->carteId);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
		echo $response['body'];
    }

    public function getAllCartes() {		
        $result = CarteDAO::getList();
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result);
      
        return $response;
    }

    private function getCarte($id) {	
		$result = CarteDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function createCarte(){
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if ( empty($input["nom"]) || empty($input["prix"]) || empty($input["marque_id"])) {
            return $this->unprocessableEntityResponse();
        }
		$carte = new CarteDTO($input["nom"], $input["prix"], $input["marque_id"]);
		CarteDAO::insert($carte);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 Created';
        $response['body'] = json_encode($carte);
        return $response;
    }

    private function updateCarte() {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
		
        if (empty($input["nom"]) || empty($input["id"]) || empty($input["prix"]) || empty($input["marque_id"])) {
            return $this->unprocessableEntityResponse();
        }
		
		$result = CarteDAO::get($input["id"]);
        if ($result == null) {
            return $this->notFoundResponse();
        }
		
		$result->setNom($input["nom"]);
		$result->setPrix($input["prix"]);
		$result->setMarque_id($input["marque_id"]);
		CarteDAO::update($result);
   
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteCarte($id) {
        $result = CarteDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }
		
        CarteDAO::delete($id);
		
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