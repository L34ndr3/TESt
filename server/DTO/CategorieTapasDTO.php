<?php

class CategorieTapasDTO implements \JsonSerializable
{
    private $CategorieId;
    private $tapasId;

    function __construct($CategorieId, $tapasId) {
		$this->CategorieId = $CategorieId;
		$this->tapasId = $tapasId;
	}


    


    /**
     * Get the value of CategorieId
     */ 
    public function getCategorieId()
    {
        return $this->CategorieId;
    }

    /**
     * Set the value of CategorieId
     *
     * @return  self
     */ 
    public function setCategorieId($CategorieId)
    {
        $this->CategorieId = $CategorieId;

        return $this;
    }

    /**
     * Get the value of tapasId
     */ 
    public function getTapasId()
    {
        return $this->tapasId;
    }

    /**
     * Set the value of tapasId
     *
     * @return  self
     */ 
    public function setTapasId($tapasId)
    {
        $this->tapasId = $tapasId;

        return $this;
    }
    
        // cette fonction définit la manière dont les attributs privés (donc normalement inaccessibles) de l'objet vont être encodés en JSON
        public function jsonSerialize():mixed
        {
            return array(
                'CategorieId' => $this->CategorieId,
                'tapasId' => $this->tapasId
            );
        }
}
