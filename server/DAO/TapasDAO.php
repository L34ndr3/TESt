<?php

class TapasDAO
{

	public static function getAlltapas()
	{
		$tapas = array();
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM tapas');
		$state->execute();
		$resultats = $state->fetchAll();

		foreach ($resultats	as $result) {
			$tapase = new TapasDTO($result["idTapas"], $result["image"], $result["prix"], $result["description"], $result["nom"]);
			$tapase->setIdTapas($result["idTapas"]);
			$tapas[] = $tapase;
		}

		return $tapas;
	}
	public static function get($id)
	{
		$tapas = null;

		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM tapas WHERE idTapas = :id');
		$state->bindValue(":id", $id);
		$state->execute();
		$resultats = $state->fetchAll();

		if (sizeof($resultats) > 0) {
			$result = $resultats[0];
			$tapas = new tapasDTO($result["idTapas"], $result["image"], $result["prix"], $result["description"], $result["nom"]);
			$tapas->setIdTapas($result["idTapas"]);
		}

		return $tapas;
	}

	public static function delete($id)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('DELETE FROM tapas WHERE idTapas = :id');
		$state->bindValue(":id", $id);
		$state->execute();
	}

	public static function insert($table)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('INSERT INTO tapas( image, prix, description ,nom ,categorieId) VALUES( :image, :prix, :description, :nom)');
		$state->bindValue(":image", $table->getImage());
		$state->bindValue(":prix", $table->getPrix());
		$state->bindValue(":description", $table->getDescription());
		$state->bindValue(":nom", $table->getNom());
		$state->execute();

		$table->setIdTapas($connex->lastInsertId());
	}
	public static function update($table)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('UPDATE tapas SET image=:image, prix=:prix, description=:description, nom=:nom WHERE idTapas = :idTapas');

		$state->bindValue(":image", $table->getImage());
		$state->bindValue(":prix", $table->getPrix());
		$state->bindValue(":description", $table->getDescription());
		$state->bindValue(":nom", $table->getNom());
		$state->bindValue(":idTapas", $table->getIdTapas());
		$state->execute();
	}
}
