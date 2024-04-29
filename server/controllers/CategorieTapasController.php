<?php

class CategorieTapasController
{

    private $requestMethod;
    private $idCategorieTapas = null;

    public function __construct($requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->idCategorieTapas = $id;
    }

    public function processRequest()
    {

        $response = $this->notFoundResponse();

        switch ($this->requestMethod) {
            case 'GET':
                if ($this->idCategorieTapas) {
                    $response = $this->getAllTapasWithCategorie($this->idCategorieTapas);
                } else {
                    $response = $this->getAllcategoriesTapas();
                };
                break;
            case 'POST':
                $response = $this->createCategorie();
                break;
            case 'PUT':
                $response = $this->updateCategorie();
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        echo $response['body'];
    }

    public function getAllCategoriesTapas()
    {
        $result = categorieTapasDAO::getAllcategoriesTapas();
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);

        return $response;
    }

    private function getAllTapasWithCategorie($id)
    {
        $result = categorieTapasDAO::getAllTapasWithCategorie($id);
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
        if (empty($input["categorieId"]) || empty($input["tapasId"])) {
            return $this->unprocessableEntityResponse();
        }
        $categorie = new categorieTapasDTO($input["categorieId"], $input["tapasId"]);
        categorieTapasDAO::insert($categorie);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 Created';
        $response['body'] = json_encode($categorie);
        return $response;
    }

    private function updateCategorie()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (empty($input["categorieId"]) || empty($input["tapasId"])) {
            return $this->unprocessableEntityResponse();
        }

        $result = categorieTapasDAO::getAllTapasWithCategorie($input["categorieId"]);
        if ($result == null) {
            return $this->notFoundResponse();
        }
        foreach ($result as $resultat) {


            $resultat->setIdTapas($input["tapasId"]);
            categorieTapasDAO::update($result);

            $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 OK';
            $response['body'] = json_encode($result);
            return $response;
        }
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
