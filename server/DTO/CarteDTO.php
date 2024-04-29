<?php

class CarteDTO implements JsonSerializable {
	private $id;
	private $nom;
	private $prix;
	private $marque_id;

	function __construct($nom, $prix, $marque_id) {
		$this->nom = $nom;
		$this->prix = $prix;
		$this->marque_id = $marque_id;
	}

	public function getId() {
		return $this->id;
	}

	public function getNom() {
		return $this->nom;
	}

	public function getPrix() {
		return $this->prix;
	}

	public function getMarque_id() {
		return $this->marque_id;
	}

	public function setId($id): void {
		$this->id = $id;
	}

	public function setNom($nom): void {
		$this->nom = $nom;
	}

	public function setPrix($prix): void {
		$this->prix = $prix;
	}

	public function setMarque_id($marque_id): void {
		$this->marque_id = $marque_id;
	}

	public function jsonSerialize() : mixed {
		return array(
			'id' => $this->id,
			'nom' => $this->nom,
			'prix' => $this->prix,
			'marque_id' => $this->marque_id
		);
	}
}
