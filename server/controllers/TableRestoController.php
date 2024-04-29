<?php


class TableRestoController
{

    private $requestMethod;
    private $idTable = null;

    public function __construct($requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->idTable = $id;
    }

    public function processRequest()
    {

        $response = $this->notFoundResponse();

        switch ($this->requestMethod) {
            case 'GET':
                if ($this->idTable) {
                    $response = $this->getTable($this->idTable);
                } else {
                    $response = $this->getAllTables();
                };
                break;
            case 'POST':
                    $response = $this->createTable();
                break;
            case 'PUT':
                    $response = $this->updateTable();
                
            case 'DELETE':
                $response = $this->deleteTable($this->idTable);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        echo $response['body'];
    }


    public function getAllTables()
    {
        $result = tableRestoDAO::getAlltable();
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);

        return $response;
    }

    private function getTable($id)
    {
        $result = tableRestoDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);
        return $response;
    }


    private function createTable()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["numeroTable"]) ||empty($input["etat"])) {
            return $this->unprocessableEntityResponse();
        }
        $table = new tableRestoDTO($input["idTable"],$input["numeroTable"], $input["etat"]);
        tableRestoDAO::insert($table);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 Created';
        $response['body'] = json_encode($table);
        return $response;
    }

    private function updateTable()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (empty($input["idTable"]) || empty($input["numeroTable"]) ||empty($input["etat"])) {
            return $this->unprocessableEntityResponse();
        }

        $result = tableRestoDAO::get($input["idTable"]);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        //$result->setEtat($input["etat"]);
        tableRestoDAO::update($result);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 OK';
        //$response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);
        $response['body'] = json_encode($input, JSON_UNESCAPED_UNICODE);
        return $response;
    }

    private function deleteTable($id)
    {
        $result = tableRestoDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        tableRestoDAO::delete($id);

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
