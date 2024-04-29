<?php


includeFileWithClassName("Produits");
class ProduitsController
{

    public function __construct()
    {
        if (!empty($_GET["action"])) {
            if ($_GET["action"] == "edit") {
                $id = $_POST["field-id"];
                $nom = $_POST["field-nom"];
                $prix = $_POST["field-prix"];
                $description = $_POST["field-description"];
                $categorie_id = $_POST["field-categorie"];
                $image = $_POST["field-avatar"];
                if (empty($image)) {
                    $product = ProduitsDAO::getTapasById($id);
                    $image = $product->getimage();
                }

                $ProduitsDTO = new ProduitsDTO($nom, $description, $prix, $image, $categorie_id);
                $ProduitsDTO->setIdTapas($id);
                ProduitsDAO::modifyProduct($ProduitsDTO);
                header("Location: index.php?page=produits");
                exit;
                //Rooter::redirectToPage('produits');
            }
            
             else if ($_GET["action"] == "create") {
                if (!empty($_POST["field-nom"]) && !empty($_POST["field-prix"]) && !empty($_POST["field-description"]) && !empty($_POST["field-categorie"])) {
                    if (isset($_FILES["field-avatar"]) && $_FILES["field-avatar"]["error"] == 0) {
                        $nomFichier = $_FILES["field-avatar"]["name"];
                        $img = file_get_contents($nomFichier);
                        $data = base64_encode($img); 

                    } else {
                        echo "Erreur de téléchargement de fichier.";
                    }
                    $nom = $_POST["field-nom"];
                    $prix = $_POST["field-prix"];
                    $description = $_POST["field-description"];
                    $categorie_id = $_POST["field-categorie"];
                    $image = $data;

                    $ProduitsDTO = new ProduitsDTO($nom, $description, $prix, $image, $categorie_id);
                    ProduitsDAO::addProduct($ProduitsDTO);
                    header("Location: index.php?page=produits");
                    exit;
                }
                else{
                    $this->includeViewCreation();
                }
            
            }
            else if ($_GET["action"] == "delete") {
                if (isset($_POST['produitid'])) {
                    $produitid = $_POST['produitid'];
                    echo $produitid;
                
                    var_dump(ProduitsDAO::deleteProduct($produitid));
                
                    header('Location: index.php?page=produits');
                    exit;
                }
            
            }


        }
        else {
            $this->includeView(ProduitsDAO::getAllProducts());
        }


    }

    public function includeView($produits)
    {
        include_once('Produit.php');
    }

    public function includeViewCreation() {
		include_once('CreateProduit.php');
	}
}