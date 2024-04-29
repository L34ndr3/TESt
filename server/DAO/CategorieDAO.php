<?php
class CategorieDAO
{


    public static function getAllcategories()
    {
        $categories = array();
        $connex = DatabaseLinker::getConnexion();

        $state = $connex->prepare('SELECT * FROM categorie');
        $state->execute();
        $resultats = $state->fetchAll();

        foreach ($resultats    as $result) {
            $categorie = new categorieDTO($result["idCategorie"], $result["libelle"]);
            $categorie->setIdCategorie($result["idCategorie"]);
            $categories[] = $categorie;
        }

        return $categories;
    }
	public static function get($id)
	{
		$commande = null;

		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT * FROM categorie WHERE idCategorie = :id');
		$state->bindValue(":id", $id);
		$state->execute();
		$resultats = $state->fetchAll();

		if (sizeof($resultats) > 0) {
			$result = $resultats[0];
			$commande = new categorieDTO($result["idCategorie"], $result["libelle"]);
			$commande->setIdCategorie($result["idCategorie"]);
		}

		return $commande;
	}
    
    public static function delete($id)
    {
        $connex = DatabaseLinker::getConnexion();

        $state = $connex->prepare('DELETE FROM categorie WHERE idCategorie = :id');
        $state->bindValue(":id", $id);
        $state->execute();
    }

    public static function insert($categorie)
    {
        $connex = DatabaseLinker::getConnexion();

        $state = $connex->prepare('INSERT INTO categorie( libelle) VALUES( :libelle)');
        $state->bindValue(":libelle", $categorie->getLibelle());
        $state->execute();

        $categorie->setIdCategorie($connex->lastInsertId());
    }
    public static function update($categorie)
    {
        $connex = DatabaseLinker::getConnexion();

        $state = $connex->prepare('UPDATE categorie SET libelle=:libelle WHERE idCategorie = :idCategorie');

        $state->bindValue(":libelle", $categorie->getLibelle());
        $state->bindValue(":idCategorie", $categorie->getIdCategorie());
        $state->execute();
    }
}
