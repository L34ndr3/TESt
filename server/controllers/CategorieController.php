<?php

class CategorieController
{

    private $requestMethod;
    private $idCategorie = null;

    public function __construct($requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->idCategorie = $id;
    }

    public function processRequest()
    {

        $response = $this->notFoundResponse();

        switch ($this->requestMethod) {
            case 'GET':
                if ($this->idCategorie) {
                    $response = $this->getCategorie($this->idCategorie);
                } else {
                    $response = $this->getAllCategories();
                };
                break;
            case 'POST':
                $response = $this->createCategorie();
                break;
            case 'PUT':
                $response = $this->updateCategorie();
                break;
            case 'DELETE':
                $response = $this->deleteCategorie($this->idCategorie);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        echo $response['body'];
    }


    public function getAllCategories()
    {
        $result = categorieDAO::getAllcategories();
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);

        return $response;
    }

    private function getCategorie($id)
    {
        $result = categorieDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);
        return $response;
    }

    private function createCategorie()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);
        if (empty($input["libelle"])) {
            return $this->unprocessableEntityResponse();
        }
        $categorie = new categorieDTO($input["idCategorie"],$input["libelle"]);
        categorieDAO::insert($categorie);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 Created';
        $response['body'] = json_encode($categorie);
        return $response;
    }

    private function updateCategorie()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (empty($input["idCategorie"]) || empty($input["libelle"])) {
            return $this->unprocessableEntityResponse();
        }

        $result = categorieDAO::get($input["idCategorie"]);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $result->setLibelle($input["libelle"]);
        categorieDAO::update($result);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteCategorie($id)
    {
        $result = categorieDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        categorieDAO::delete($id);

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
