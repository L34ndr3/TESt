<?php

class MarqueDAO {

	public static function get($id) {
		$marque = null;

		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM marque WHERE id = :id');
		$state->bindValue(":id", $id);
		$state->execute();
		$resultats = $state->fetchAll();

		if (sizeof($resultats) > 0) {
			$result = $resultats[0];
			$marque = new MarqueDTO($result["nom"]);
			$marque->setId($result["id"]);
		}

		return $marque;
	}

	public static function getList() {
		$marques = array();

		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM marque');
		$state->execute();
		$resultats = $state->fetchAll();

		foreach ($resultats	as $result) {
			$marque = new MarqueDTO($result["nom"]);
			$marque->setId($result["id"]);

			$marques[] = $marque;
		}

		return $marques;
	}

	public static function delete($id) {
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('DELETE FROM marque WHERE id = :id');
		$state->bindValue(":id", $id);
		$state->execute();
	}

	public static function insert($marque) {
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('INSERT INTO marque(nom) VALUES(:nom)');
		$state->bindValue(":nom", $marque->getNom());
		$state->execute();

		$marque->setId($connex->lastInsertId());
	}

	public static function update($marque) {
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('UPDATE marque SET nom=:nom WHERE id = :id');

		$state->bindValue(":nom", $marque->getNom());
		$state->bindValue(":id", $marque->getId());
		$state->execute();
	}
}
