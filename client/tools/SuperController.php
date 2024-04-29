<?php
class SuperController {
	public static function callPage($page) {
		// récupération du nom du controller
		$controllerName = ucfirst($page) . "Controller";
	
		// inclusion du fichier du controller
		include_once("pages/" . $page . "/" . $controllerName . ".php");

		// création du controller
		new $controllerName;
  	}
}
