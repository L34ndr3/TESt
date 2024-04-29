<?php

class CommandeDTO implements \JsonSerializable
{

    private $idCommande;
    private $tableId;
    private $effectue;

    function __construct($idCommande, $tableId, $effectue) {
		$this->idCommande = $idCommande;
		$this->tableId = $tableId;
        $this->effectue = $effectue;
	}
    /**
     * Get the value of idCommande
     */
    public function getIdCommande()
    {
        return $this->idCommande;
    }

    /**
     * Set the value of idCommande
     *
     * @return  self
     */
    public function setIdCommande($idCommande)
    {
        $this->idCommande = $idCommande;

        return $this;
    }

    /**
     * Get the value of tableId
     */
    public function getTableId()
    {
        return $this->tableId;
    }

    /**
     * Set the value of tableId
     *
     * @return  self
     */
    public function setTableId($tableId)
    {
        $this->tableId = $tableId;

        return $this;
    }

    /**
     * Get the value of effectue
     */
    public function getEffectue()
    {
        return $this->effectue;
    }

    /**
     * Set the value of effectue
     *
     * @return  self
     */
    public function setEffectue($effectue)
    {
        $this->effectue = $effectue;

        return $this;
    }
    // cette fonction définit la manière dont les attributs privés (donc normalement inaccessibles) de l'objet vont être encodés en JSON
    public function jsonSerialize():mixed
    {
        return array(
            'idCommande' => $this->idCommande,
            'tableId' => $this->tableId,
            'effectue' => $this->effectue
        );
    }
}
