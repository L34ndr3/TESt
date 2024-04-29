<?php


class ContenueCommandeController
{

    private $requestMethod;
    private $idCommande = null;

    public function __construct($requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->idCommande = $id;
    }

    public function processRequest()
    {

        $response = $this->notFoundResponse();

        switch ($this->requestMethod) {
            case 'GET':
                if ($this->idCommande) {
                    $response = $this->getContenue($this->idCommande);
                } else {
                    $response = $this->getAllContenues();
                };
                break;
            case 'POST':
                $response = $this->createContenue();
                break;
            case 'PUT':
                $response = $this->updateContenue();
                break;
            case 'DELETE':
                $response = $this->deleteContenue($this->idCommande);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        echo $response['body'];
    }

    public function getAllContenues()
    {
        $result = contenueCommandeDAO::getAllcontenues();
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);

        return $response;
    }

    private function getContenue($id)
    {
        $result = contenueCommandeDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);
        return $response;
    }

    private function createContenue()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["commandeId"]) || empty($input["tapasId"]) || empty($input["nombre"])) {
            return $this->unprocessableEntityResponse();
        }
        $contenue = new contenueCommandeDTO($input["commandeId"], $input["tapasId"], $input["nombre"]);
        contenueCommandeDAO::insert($contenue);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 Created';
        $response['body'] = json_encode($contenue);
        return $response;
    }

    private function updateContenue()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (empty($input["commandeId"]) || empty($input["tapasId"]) || empty($input["nombre"])) {
            return $this->unprocessableEntityResponse();
        }

        $result = contenueCommandeDAO::get($input["commandeId"]);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $result->setTapasId($input["tapasId"]);
        $result->setNombre($input["nombre"]);
        contenueCommandeDAO::update($result);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteContenue($id)
    {
        $result = contenueCommandeDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        contenueCommandeDAO::delete($id);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 202 Successful deletion';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function unprocessableEntityResponse()
    {
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 422 Unprocessable Entity';
        $response['body'] = json_encode([
            'error' => 'Invalid input'
        ]);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
        $response['body'] = null;
        return $response;
    }
}
