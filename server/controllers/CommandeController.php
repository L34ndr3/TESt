<?php
class CommandeController
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
                    $response = $this->getCommande($this->idCommande);
                } else {
                    $response = $this->getAllCommande();
                };
                break;
            case 'POST':
                    $response = $this->createCommande();
                break;
            case 'PUT':
                    $response = $this->updateCommande();
                break;
            case 'DELETE':
                $response = $this->deleteCommande($this->idCommande);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        echo $response['body'];
    }

    public function getAllCommande()
    {
        $result = commandeDAO::getAllcommandes();
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);

        return $response;
    }

    private function getCommande($id)
    {
        $result = commandeDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);
        return $response;
    }

    private function createCommande()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["tableId"])) {
            return $this->unprocessableEntityResponse();
        }
        $commande = new commandeDTO($input["idCommande"],$input["tableId"], $input["effectue"]);
        $id = commandeDAO::insert($commande);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 Created';
        $response['body'] = json_encode($id);
        return $response;
    }

    private function updateCommande()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (empty($input["idCommande"]) || empty($input["tableId"])) {
            return $this->unprocessableEntityResponse();
        }

        $result = commandeDAO::get($input["idCommande"]);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $result->setTableId($input["tableId"]);
        $result->setEffectue($input["effectue"]);
        commandeDAO::update($result);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteCommande($id)
    {
        $result = commandeDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        commandeDAO::delete($id);

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
