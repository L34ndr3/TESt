<?php

class MarqueDTO implements JsonSerializable {
	private $id;
	private $nom;

	public function __construct($nom) {
		$this->nom = $nom;
	}

	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}

	public function getNom() {
		return $this->nom;
	}
	public function setNom($nom) {
		$this->nom = $nom;
	}

	// cette fonction définit la manière dont les attributs privés (donc normalement inaccessibles) de l'objet vont être encodés en JSON
	public function jsonSerialize() : mixed {
		return array(
			'id' => $this->id,
			'nom' => $this->nom
		);
	}
}
