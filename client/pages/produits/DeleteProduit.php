<?php
include_once("../../DTO/ProduitDTO.php");
include_once("../../DAO/ProduitDAO.php");

if (isset($_POST['produitid'])) {
    $produitid = $_POST['produitid'];
    echo $produitid;

    var_dump(ProduitsDAO::deleteProduct($produitid));

    header('Location: index.php');
    exit;
}
?>