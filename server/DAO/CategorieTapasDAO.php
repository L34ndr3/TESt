<?php
class CategorieTapasDAO
{
    public static function getAllcategoriesTapas()
    {
        $categoriesTapas = array();
        $connex = DatabaseLinker::getConnexion();

        $state = $connex->prepare('SELECT * FROM categorieTapas');
        $state->execute();
        $resultats = $state->fetchAll();

        foreach ($resultats    as $result) {
            $categoriesTapas = new categorieTapasDTO($result["categorieId"], $result["tapasId"]);
            $categoriesTapas->setCategorieId($result["categorieId"]);
            $categoriesTapase[] = $categoriesTapas;
        }

        return $categoriesTapase;
    }
	public static function getAllTapasWithCategorie($id)
	{
        $listeTapas = array();

		$connex = DatabaseLinker::getConnexion();

		$state = $connex->prepare('SELECT tapas.idTapas, tapas.image, tapas.prix, tapas.description, tapas.nom FROM tapas
        INNER JOIN categorietapas on categorietapas.tapasId = tapas.idTapas
        INNER JOIN categorie on categorie.idCategorie = categorietapas.categorieId
        WHERE categorie.idCategorie = :id');
		$state->bindValue(":id", $id);
		$state->execute();
		$resultats = $state->fetchAll();

		foreach ($resultats as $result) {
			$tapas = new TapasDTO($result["idTapas"], $result["image"], $result["prix"], $result["description"], $result["nom"]);
            $listeTapas[] = $tapas;
		}

		return $listeTapas;
	}

    

    public static function insert($categorieTapas)
    {
        $connex = DatabaseLinker::getConnexion();

        $state = $connex->prepare('INSERT INTO categorieTapas(categorieId, tapasId) VALUES(:categorieId, :tapasId)');
        $state->bindValue(":categorieId", $categorieTapas->getCategorieId());
        $state->bindValue(":tapasId", $categorieTapas->getTapasId());
        $state->execute();

        $categorieTapas->setIdCategorie($connex->lastInsertId());
    }
    public static function update($categorieTapas)
    {
        $connex = DatabaseLinker::getConnexion();

        $state = $connex->prepare('UPDATE categorieTapas SET tapasId=:tapasId WHERE categorieId = :categorieId');

        $state->bindValue(":tapasId", $categorieTapas->getTapasId());
        $state->bindValue(":categorieId", $categorieTapas->getCategorieId());
        $state->execute();
    }
}
