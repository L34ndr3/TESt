<?php

class CategorieDTO implements \JsonSerializable
{
    private $idCategorie;
    private $libelle;

    function __construct($idCategorie,$libelle) {
        $this->idCategorie = $idCategorie;
		$this->libelle = $libelle;
	}

    /**
     * Get the value of idCategorie
     */ 
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * Set the value of idCategorie
     *
     * @return  self
     */ 
    public function setIdCategorie($idCategorie)
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    /**
     * Get the value of libelle
     */ 
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set the value of libelle
     *
     * @return  self
     */ 
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    

        // cette fonction définit la manière dont les attributs privés (donc normalement inaccessibles) de l'objet vont être encodés en JSON
        public function jsonSerialize():mixed
        {
            return array(
                'idCategorie' => $this->idCategorie,
                'libelle' => $this->libelle
            );
        }
}
