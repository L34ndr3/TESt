<?php

class TapasDTO implements \JsonSerializable
{
    private $idTapas;
    private $image;
    private $prix;
    private $description;
    private $nom;
    
    function __construct($idTapas, $image, $prix, $description, $nom)
    {
        $this->idTapas = $idTapas;
        $this->image = $image;
        $this->prix = $prix;
        $this->description = $description;
        $this->nom = $nom;
    }
    /**
     * Get the value of idTapas
     */
    public function getIdTapas()
    {
        return $this->idTapas;
    }

    /**
     * Set the value of idTapas
     *
     * @return  self
     */
    public function setIdTapas($idTapas)
    {
        $this->idTapas = $idTapas;

        return $this;
    }

    /**
     * Get the value of image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of prix
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set the value of prix
     *
     * @return  self
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }



        // cette fonction définit la manière dont les attributs privés (donc normalement inaccessibles) de l'objet vont être encodés en JSON
        public function jsonSerialize():mixed
        {
            return array(
                'idTapas' => $this->idTapas,
                'image' => $this->image,
                'prix' => $this->prix,
                'description' => $this->description,
                'nom' => $this->nom,
            );
        }
}
