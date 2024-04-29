<?php

class ContenueCommandeDAO
{

	public static function getAllcontenues()
	{
		$contenues = array();
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM contenuecommande');
		$state->execute();
		$resultats = $state->fetchAll();

		foreach ($resultats	as $result) {
			$contenue = new contenueCommandeDTO($result["commandeId"], $result["tapasId"], $result["nombre"]);
			$contenue->setCommandeId($result["commandeId"]);
			$contenues[] = $contenue;
		}

		return $contenues;
	}
	public static function get($id)
	{
		$contenue = null;

		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM contenuecommande WHERE commandeId = :id');
		$state->bindValue(":id", $id);
		$state->execute();
		$resultats = $state->fetchAll();

		if (sizeof($resultats) > 0) {
			$result = $resultats[0];
			$contenue = new contenueCommandeDTO($result["commandeId"], $result["tapasId"], $result["nombre"]);
			$contenue->setCommandeId($result["commandeId"]);
		}

		return $contenue;
	}
	public static function delete($id)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('DELETE FROM contenuecommande WHERE commandeId = :id');
		$state->bindValue(":id", $id);
		$state->execute();
	}
	public static function insert($contenue)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('INSERT INTO contenuecommande(commandeId, tapasId, nombre) VALUES(:commandeId, :tapasId, :nombre)');
		$state->bindValue(":commandeId", $contenue->getCommandeId());
		$state->bindValue(":tapasId", $contenue->getTapasId());
		$state->bindValue(":nombre", $contenue->getNombre());
		$state->execute();

		$contenue->setIdCommande($connex->lastInsertId());
	}
	public static function update($contenue)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('UPDATE contenuecommande SET tapasId=:tapasId, nombre=:nombre WHERE commandeId = :commandeId');

		$state->bindValue(":tapasId", $contenue->getTapasId());
		$state->bindValue(":nombre", $contenue->getNombre());
		$state->bindValue(":commandeId", $contenue->getCommandeId());
		$state->execute();
	}
}
