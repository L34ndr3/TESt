<?php


class ProduitsDAO {

    // URL de base de votre API
    private static $base_url = 'http://localhost/Webservice/server/';

    // Fonction pour récupérer les données d'un tapas par son ID
    public static function getTapasById($id) {
        // URL de l'API pour récupérer les données du tapas avec l'ID spécifié
        $url = self::$base_url . 'tapas/' . $id;

        // Envoyer une requête GET à l'API pour récupérer les données du tapas
        $response = RequestSender::sendGetRequest($url);

        // Vérifier si la requête a réussi (code HTTP 200)
        if ($response['status_code_header'] === 200) {
            // Convertir les données JSON en tableau associatif
            $tapas_data = json_decode($response['data'], true);
            return $tapas_data; // Retourner les données du tapas
        } else {
            // Si la requête échoue, retourner NULL ou lancer une exception selon le besoin
            return null;
        }
    }

    // Fonction pour récupérer tous les produits
    public static function getAllProducts() {
        $url = self::$base_url . 'tapas';
    
        $response = RequestSender::sendGetRequest($url);
        if ($response === false) {
            throw new Exception("Erreur lors de la récupération des produits.");
        }
    
        $productsJson = json_decode($response['data'], true);
        if ($productsJson === null) {
            throw new Exception("Erreur lors de la conversion des données JSON.");
        }
    
        $produits = array();
    
        foreach ($productsJson as $product) {
            // Création d'un nouvel objet ProduitDTO en utilisant les données de l'API
            $produit = new ProduitsDTO(
                $product['idTapas'],
                $product['image'],
                $product['prix'],
                $product['description'],
                $product['nom']
            );
            $produits[] = $produit;
        }
    
        return $produits;
    }
    
    
    

    // Fonction pour ajouter un produit
    public static function addProduct($productDTO) {
        $url = self::$base_url . 'tapas';
        $response = RequestSender::sendPostRequest($url, $productDTO);
        return $response;
    }
 
    // Fonction pour modifier un produit
    public static function modifyProduct($productDTO) {
        $url = self::$base_url . 'tapas';
        $response = RequestSender::sendPutRequest($url, $productDTO);
        return $response;
    }

    // Fonction pour supprimer un produit par son ID
    public static function deleteProduct($productID) {
        $url = self::$base_url . "tapas/$productID";
        $response = RequestSender::sendDeleteRequest($url);
        return $response;
    }
}

?>
