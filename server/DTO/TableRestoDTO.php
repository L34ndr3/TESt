<?php

class TableRestoDTO implements \JsonSerializable
{

    private $idTable;
    private $numeroTable;
    private $etat;


    function __construct($idTable, $numeroTable,$etat)
    {
        $this->idTable = $idTable;
        $this->numeroTable=$numeroTable;
        $this->etat = $etat;
    }
    /**
     * Get the value of idTable
     */
    public function getIdTable()
    {
        return $this->idTable;
    }

    /**
     * Set the value of idTable
     *
     * @return  self
     */
    public function setIdTable($idTable)
    {
        $this->idTable = $idTable;

        return $this;
    }
    /**
     * Get the value of numeroTable
     */ 
    public function getNumeroTable()
    {
        return $this->numeroTable;
    }

    /**
     * Set the value of numeroTable
     *
     * @return  self
     */ 
    public function setNumeroTable($numeroTable)
    {
        $this->numeroTable = $numeroTable;

        return $this;
    }
    /**
     * Get the value of etat
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of etat
     *
     * @return  self
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }
    // cette fonction définit la manière dont les attributs privés (donc normalement inaccessibles) de l'objet vont être encodés en JSON
    public function jsonSerialize():mixed
    {
        return array(
            'idTable' => $this->idTable,
            'numeroTable' => $this->numeroTable,
            'etat' => $this->etat
        );
    }


}
