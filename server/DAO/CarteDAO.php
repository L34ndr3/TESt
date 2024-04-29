<?php

	class CarteDAO {

		public static function get($id) {
			$carte = null;

			$connex = DatabaseLinker::getConnexion();

			$state = $connex->prepare('SELECT * FROM carte WHERE id = :id');
			$state->bindValue(":id", $id);
			$state->execute();
			$resultats = $state->fetchAll();

			if (sizeof($resultats) > 0)
			{
				$result = $resultats[0];
				$carte = new CarteDTO($result["nom"], $result["prix"], $result["marque_id"]);
				$carte->setId($result["id"]);
			}

			return $carte;
		}

		public static function getList() {
			$cartes = array();

			$connex = DatabaseLinker::getConnexion();

			$state = $connex->prepare('SELECT * FROM carte');
			$state->execute();
			$resultats = $state->fetchAll();

			foreach ($resultats	as $result)
			{
				$carte = new CarteDTO($result["nom"], $result["prix"], $result["marque_id"]);
				$carte->setId($result["id"]);
				
				$cartes[] = $carte;
			}

			return $cartes;
		}

		public static function delete($id) {
			$connex = DatabaseLinker::getConnexion();

			$state = $connex->prepare('DELETE FROM carte WHERE id = :id');
			$state->bindValue(":id", $id);
			$state->execute();
		}

		public static function insert($carte) {
			$connex = DatabaseLinker::getConnexion();

			$state = $connex->prepare('INSERT INTO carte(nom, prix, marque_id) VALUES(:nom, :prix, :marque_id)');
			$state->bindValue(":nom", $carte->getNom());
			$state->bindValue(":prix", $carte->getPrix());
			$state->bindValue(":marque_id", $carte->getMarque_id());
			$state->execute();

			$carte->setId($connex->lastInsertId());
		}

		public static function update($carte) {
			$connex = DatabaseLinker::getConnexion();

			$state = $connex->prepare('UPDATE carte SET nom=:nom, prix=:prix, marque_id=:marque_id WHERE id = :id');
	
			$state->bindValue(":nom", $carte->getNom());
			$state->bindValue(":prix", $carte->getPrix());
			$state->bindValue(":marque_id", $carte->getMarque_id());
			$state->bindValue(":id", $carte->getId());
			$state->execute();
		}
	}
