<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>


<link rel="stylesheet" type="text/css" href="Pages/Produit/CreateProduit.css" media="all">
<div class="container-button-retour">
	<a href="http://localhost/tapas_groupe1_admin/index.php?page=produits" class="button-green">< Retour</a>
</div>


<form class="Produit-form" method="POST" action="index.php?page=produits&action=create" enctype="multipart/form-data">

	<div class="line-Produit">
		<label class="label-Produit">Photo du produit : </label>
		<input type="file" name="field-avatar"/>
	</div>
	
	<div class="line-Produit">
		<label class="label-Produit">Nom : </label>
		<input type="text" name="field-nom">
	</div>
	<div class="line-Produit">
		<label class="label-Produit">Prix :  </label>
		<input type="number" name="field-prix">
	</div>
	
	<div class="line-Produit">
		<label class="label-Produit">Description : </label>
		<input type="text" name="field-description">
	</div>
	<div class="line-Produit"><label class="label-Categorie">Categorie : </label></div>
	<textarea class="Produit-categorie" name="field-categorie"></textarea>
	
	<input class="Produit-submit button-green" type="submit" value="Publier"/>
</form>