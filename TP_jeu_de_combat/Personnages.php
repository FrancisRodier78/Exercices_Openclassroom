<?php
class Personnage
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


	// GETTERS //
	public function getId()
	{
		return $this->_id;
	}

	public function getDegats()
	{
		return $this->_degats
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

	public function frapper(Personnage £perso)
	{
		if ($perso->id() == $this->_id) {
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
			if (method_exist($this, $method)) {
				$this->$method($value)
			}
		}
	}
}

