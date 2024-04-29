<?php

class TapasController
{

    private $requestMethod;
    private $idTapas = null;

    public function __construct($requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->idTapas = $id;
    }

    public function processRequest()
    {

        $response = $this->notFoundResponse();

        switch ($this->requestMethod) {
            case 'GET':
                if ($this->idTapas) {
                    $response = $this->getTapas($this->idTapas);
                } else {
                    $response = $this->getAlltapas();
                };
                break;
            case 'POST':

                $response = $this->createTapas();
                break;
            case 'PUT':
                $response = $this->updateTapas();

                break;
            case 'DELETE':
                $response = $this->deleteTapas($this->idTapas);
                break;
            default:
                $response = $this->notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        echo $response['body'];
    }

    public function getAllTapas()
    {
        $result = tapasDAO::getAlltapas();
        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK ';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);

        return $response;
    }

    
    private function getTapas($id)
    {
        $result = tapasDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);
        return $response;
    }

    
    private function createTapas()
    {
        $input = (array) json_decode(file_get_contents('php://input'), true);
        if (empty($input["image"]) || empty($input["prix"]) || empty($input["description"]) || empty($input["nom"])) {
            return $this->unprocessableEntityResponse();
        }
        // La chaîne image base64
        $base64_image = $input["image"];

        // Fonction pour déterminer le format de l'image en fonction des premiers octets
        // Utilise preg_match pour extraire le format de l'image depuis la chaîne base64
        if (preg_match('#^.*?base64,#', $base64_image, $matches)) {
            $imageFormat = $matches[0]; // Obtient le format de l'image

            // Divise la chaîne en utilisant la virgule comme séparateur
            $parts = explode(';', $base64_image);

            if (count($parts) > 0) {
                // Extrayez la partie finale après la dernière barre oblique
                $imageFormat = end(explode('/', $parts[0]));

                // Génère un nom de fichier unique
                $imageName = $input["nom"] . "." . $imageFormat;

                // Spécifie le chemin de destination pour enregistrer l'image
                $destinationPath = "src/images/" . $imageName;

                // Extrait les données de l'image (après la virgule)
                $imageData = substr($base64_image, strpos($base64_image, ',') + 1);

                // Décode la chaîne base64 en binaire
                $binaryData = base64_decode($imageData);
            }

            if ($binaryData !== false) {
                // Enregistre l'image sur le serveur
                file_put_contents($destinationPath, $binaryData);
            }


            $carte = new tapasDTO($input["idTapas"], $imageName, $input["prix"], $input["description"], $input["nom"]);
            tapasDAO::insert($carte);


            $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 Created';
            $response['body'] = json_encode($carte);
            return $response;
        }
    }

    private function updateTapas()
    {
        $input = (array) json_decode(file_get_contents('php://input'), TRUE);

        if (empty($input["idTapas"]) || empty($input["image"]) || empty($input["prix"]) || empty($input["description"]) || empty($input["nom"])) {
            return $this->unprocessableEntityResponse();
        }

        $result = tapasDAO::get($input["idTapas"]);
        if ($result == null) {
            return $this->notFoundResponse();
        }
        // La chaîne image base64
        $base64_image = $input["image"];

        // Fonction pour déterminer le format de l'image en fonction des premiers octets
        // Utilise preg_match pour extraire le format de l'image depuis la chaîne base64
        if (preg_match('#^.*?base64,#', $base64_image, $matches)) {
            $imageFormat = $matches[0]; // Obtient le format de l'image

            // Divise la chaîne en utilisant la virgule comme séparateur
            $parts = explode(';', $base64_image);

            if (count($parts) > 0) {
                // Extrayez la partie finale après la dernière barre oblique
                $imageFormat = end(explode('/', $parts[0]));

                // Génère un nom de fichier unique
                $imageName = $input["nom"] . "." . $imageFormat;

                // Spécifie le chemin de destination pour enregistrer l'image
                $destinationPath = "src/images/" . $imageName;

                // Extrait les données de l'image (après la virgule)
                $imageData = substr($base64_image, strpos($base64_image, ',') + 1);

                // Décode la chaîne base64 en binaire
                $binaryData = base64_decode($imageData);
            }
        }

        if ($binaryData !== false) {
            // Emplacement où vous stockez vos images
            $repertoireImages = "src/images/";

            // Assurez-vous que $input['nom'] est défini
            if (isset($input['nom'])) {
                $nomImage = $input['nom'];

                // Vérifiez si l'ancienne image existe dans le répertoire
                $cheminAncienneImage = $repertoireImages . $nomImage;

                if (file_exists($cheminAncienneImage)) {
                    // Supprime l'ancienne image
                    (unlink($cheminAncienneImage));
                }
            }
            // Enregistre l'image sur le serveur
            file_put_contents($destinationPath, $binaryData);
        }

        $result->setImage($imageName);
        $result->setPrix($input["prix"]);
        $result->setDescription($input["description"]);
        $result->setNom($input["nom"]);
        tapasDAO::update($result);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 201 OK';
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteTapas($id)
    {
        $result = tapasDAO::get($id);
        if ($result == null) {
            return $this->notFoundResponse();
        }

        tapasDAO::delete($id);

        $response['status_code_header'] = $_SERVER['SERVER_PROTOCOL'] . ' 202 Successful deletion';
        $response['body'] = json_encode($result, JSON_UNESCAPED_UNICODE);
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
