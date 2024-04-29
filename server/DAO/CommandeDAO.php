<?php

class CommandeDAO
{

	public static function getAllcommandes()
	{
		$commandes = array();
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM commande');
		$state->execute();
		$resultats = $state->fetchAll();

		foreach ($resultats	as $result) {
			$commande = new commandeDTO($result["idCommande"], $result["tableId"], $result["effectue"]);
			$commande->setIdCommande($result["idCommande"]);
			$commandes[] = $commande;
		}

		return $commandes;
	}
	public static function get($id)
	{
		$commande = null;

		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM commande WHERE idCommande = :id');
		$state->bindValue(":id", $id);
		$state->execute();
		$resultats = $state->fetchAll();

		if (sizeof($resultats) > 0) {
			$result = $resultats[0];
			$commande = new commandeDTO($result["idCommande"], $result["tableId"], $result["effectue"]);
			$commande->setIdCommande($result["idCommande"]);
		}

		return $commande;
	}
	public static function delete($id)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('DELETE FROM commande WHERE idCommande = :id');
		$state->bindValue(":id", $id);
		$state->execute();
	}
	public static function insert($commande)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('INSERT INTO commande(tableId, effectue) VALUES(:tableId, :effectue)');
		$state->bindValue(":tableId", $commande->getTableId());
		$state->bindValue(":effectue", $commande->getEffectue());
		$state->execute();

		return $connex->lastInsertId();
	}
	public static function update($commande)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('UPDATE commande SET tableId=:tableId, effectue=:effectue WHERE idCommande = :idCommande');

		$state->bindValue(":tableId", $commande->getTableId());
		$state->bindValue(":effectue", $commande->getEffectue());
		$state->bindValue(":idCommande", $commande->getIdCommande());
		$state->execute();
	}
}
