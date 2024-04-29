<?php

class TableRestoDAO
{
	public static function getAlltable()
	{
		$tables = array();
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM tableresto');
		$state->execute();
		$resultats = $state->fetchAll();

		foreach ($resultats	as $result) {
			$table = new tableRestoDTO($result["idTable"],$result["numeroTable"], $result["etat"]);
			$table->setIdTable($result["idTable"]);
			$tables[] = $table;
		}

		return $tables;
	}
	public static function get($id)
	{
		$table = null;

		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM tableresto WHERE idTable = :id');
		$state->bindValue(":id", $id);
		$state->execute();
		$resultats = $state->fetchAll();

		if (sizeof($resultats) > 0) {
			$result = $resultats[0];
			$table = new tableRestoDTO($result["idTable"],$result["numeroTable"],$result["etat"]);
			$table->setIdTable($result["idTable"]);
		}

		return $table;
	}
	public static function delete($id)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('DELETE FROM tableresto WHERE idTable = :id');
		$state->bindValue(":id", $id);
		$state->execute();
	}
	public static function insert($table)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('INSERT INTO tableresto(numeroTable, etat) VALUES(:numeroTable, :etat)');
		$state->bindValue(":numeroTable", $table->getNumeroTable());
		$state->bindValue(":etat", $table->getEtat());
		$state->execute();

		$table->setIdTable($connex->lastInsertId());
	}
	public static function update($table)
	{
		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('UPDATE tableresto SET numeroTable=:numeroTable ,etat=:etat WHERE idTable = :idTable');

		$state->bindValue(":numeroTable", $table->getNumeroTable());
		$state->bindValue(":etat", $table->getEtat());
		$state->bindValue(":idTable", $table->getIdTable());
		$state->execute();
	}
}
