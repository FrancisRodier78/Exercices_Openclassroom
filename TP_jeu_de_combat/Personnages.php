<?php
<<<<<<< HEAD
class Personnages
=======
class Personnage
>>>>>>> master
{
	private $_id,
            $_degats,
	        $_nom;

	const CEST_MOI = 1;
	const PERSONNAGE_TUE = 2;
	const PERSONNAGE_FRAPPE = 3;

	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

<<<<<<< HEAD
	public function nomValide()
	{
		return !empty($this->_nom);
	}
=======
>>>>>>> master

	// GETTERS //
	public function getId()
	{
		return $this->_id;
	}

	public function getDegats()
	{
<<<<<<< HEAD
		return $this->_degats;
=======
		return $this->_degats
>>>>>>> master
	}

	public function getNom()
	{
		return $this->_nom;
	}


	// SETTERS //
	public function setDegats($degats)
	{
		$degats = (int) $degats;
		if ($degats >= 0 && $degats <= 100) {
			$this->_degats = $degats;
		}
	}

	public function setNom($nom)
	{
		if (is_string($nom)) {
			$this->_nom = $nom;
		}
	}

<<<<<<< HEAD
	public function frapper(Personnages $perso)
	{
		//*//
		if ($perso->getId() !== $this->_id) {
=======
	public function frapper(Personnage £perso)
	{
		if ($perso->id() == $this->_id) {
>>>>>>> master
			return self::CEST_MOI;
		} else {
			return $perso->recevoirDegats();
		}		
	}

	public function recevoirDegats()
	{
		$this->_degats += 5;
		if ($this->_degats >= 100) {
			return self::PERSONNAGE_TUE;
		} else {
			return self::PERSONNAGE_FRAPPE;
		}		
	}

	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value) {
			$method = 'set'.ucfirst($key);
<<<<<<< HEAD
			if (method_exists($this, $method)) {
				$this->$method($value);
=======
			if (method_exist($this, $method)) {
				$this->$method($value)
>>>>>>> master
			}
		}
	}
}

