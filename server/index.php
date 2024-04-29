<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// méthodes HTTP autorisées
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
// durée d'expiration du cache
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// sujet de l'URL (cartes ou marques)
$urlSubject = "";
// paramètre supplémentaire à la fin de l'URL (id de carte ou de marque)
$urlParam = "";

// découpage de l'URL
$url = $_SERVER['REQUEST_URI'];
if (preg_match("/^.+?server\/(.+)$/is", $url, $urlContents)) {
	// récupération de la fin de l'URL ( après server/ )
	$urlEnd = $urlContents[1];
	// séparation de la fin de l'URL et des paramètres
	$urlParts = explode("/", $urlEnd);

	// récupération du sujet de l'URL
	$urlSubject = $urlParts[0];
	// récupération du paramètre supplémentaire s'il existe
	if (isset($urlParts[1])) {
		$urlParam = $urlParts[1];
	}
}

// méthode HTTP utilisée (GET, POST, PUT, DELETE)
$requestMethod = $_SERVER["REQUEST_METHOD"];


// fonction de chargement automatique des fichiers
function includeFileWithClassName($class_name)
{
	// répertoires contenant les classes
	$directorys = array(
		'controllers/',
		'DAO/',
		'DTO/',
		'tools/'
	);

	// pour chaque répertoire
	foreach ($directorys as $directory) {
		// si le fichier existe
		if (file_exists($directory . $class_name . '.php')) {
			// inclus le fichier une seule fois
			require_once ($directory . $class_name . '.php');
			return;
		}
	}
}

// enregistrement de la fonction de chargement automatique des fichiers
spl_autoload_register('includeFileWithClassName');

// en fonction de l'URL appelée, on charge différents controllers
switch ($urlSubject) {

	case "marques":

		$marqueId = null;
		if (!empty($urlParam)) {
			$marqueId = (int) $urlParam;
		}

		$controller = new MarqueController($requestMethod, $marqueId);
		$controller->processRequest();
		break;

	case "cartes":

		$carteId = null;
		if (!empty($urlParam)) {
			$carteId = (int) $urlParam;
		}

		$controller = new CarteController($requestMethod, $carteId);
		$controller->processRequest();
		break;

		case "categories":
	
			$idCategorie = null;
			if (!empty($urlParam)) {
				$idCategorie = (int) $urlParam;
			}
	
			$controller = new CategorieController($requestMethod, $idCategorie);
			$controller->processRequest();
			break;
	
		case "tapas":
	
			$idTapas = null;
			if (!empty($urlParam)) {
				$idTapas = (int) $urlParam;
			}
	
			$controller = new TapasController($requestMethod, $idTapas);
			$controller->processRequest();
			break;
		case "commandes":
	
			$idCommande = null;
			if (!empty($urlParam)) {
				$idCommande = (int) $urlParam;
			}
	
			$controller = new CommandeController($requestMethod, $idCommande);
			$controller->processRequest();
			break;
		case "table":
	
			$idTable = null;
			if (!empty($urlParam)) {
				$idTable = (int) $urlParam;
			}
	
			$controller = new TableRestoController($requestMethod, $idTable);
			$controller->processRequest();
			break;
		case "categoriesTapas":
	
			$idCategorie = null;
			if (!empty($urlParam)) {
				$idCategorie = (int) $urlParam;
			}
	
			$controller = new CategorieTapasController($requestMethod, $idCategorie);
			$controller->processRequest();
			break;
		case "contenu":
	
			$commandeId = null;
			if (!empty($urlParam)) {
				$commandeId = (int) $urlParam;
			}
	
			$controller = new ContenueCommandeController($requestMethod, $commandeId);
			$controller->processRequest();
			break;
		
		default:
		header($_SERVER['SERVER_PROTOCOL'] . " 404 Not Found");
		exit();
		break;
}
