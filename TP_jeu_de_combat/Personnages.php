<?php
class Personnages
{
	private $atout,
			$id,
            $degats,
	        $nom,
            $timeEndormi,
            $type;


	const CEST_MOI = 1;
	const PERSONNAGE_TUE = 2;
	const PERSONNAGE_FRAPPE = 3;
    const PERSONNAGE_ENSORCELE = 4; // Constante renvoyée par la méthode `lancerUnSort` (voir classe Magicien) si on a bien ensorcelé un personnage.
    const PAS_DE_MAGIE = 5; // Constante renvoyée par la méthode `lancerUnSort` (voir classe Magicien) si on veut jeter un sort alors que la magie du magicien est à 0.
    const PERSO_ENDORMI = 6; // Constante renvoyée par la méthode `frapper` si le personnage qui veut frapper est endormi.

	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	    $this->type = strtolower(static::class);
	}

    public function estEndormi()
    {
      return $this->timeEndormi > time();
    }

	public function nomValide()
	{
		return !empty($this->nom);
	}

	// GETTERS //
	public function getId()
	{
		return $this->id;
	}

    public function getAtout()
    {
    	return $this->atout;
    }

	public function getDegats()
	{
		return $this->degats;
	}

	public function getNom()
	{
		return $this->nom;
	}

    public function getTimeEndormi()
    {
    	return $this->timeEndormi;
    }
  
    public function getType()
    {
    	return $this->type;
    }
  
	// SETTERS //
    public function setId($id)
    {
      $id = (int) $id;
    
      if ($id > 0) {
          $this->id = $id;
      }
    }

    public function setAtout($atout)
    {
	    $atout = (int) $atout;
	    if ($atout >= 0 && $atout <= 100) {
	      $this->atout = $atout;
	    }
	}

	public function setDegats($degats)
	{
		$degats = (int) $degats;
		if ($degats >= 0 && $degats <= 100) {
			$this->degats = $degats;
		}
	}

	public function setNom($nom)
	{
		if (is_string($nom)) {
			$this->nom = $nom;
		}
	}

    public function setTimeEndormi($time)
    {
        $this->timeEndormi = (int) $time;
    }

	public function frapper(Personnages $perso)
	{
		//*//
	    if ($perso->id == $this->id) {
	      return self::CEST_MOI;
	    }
	    
	    if ($this->estEndormi()) {
	      return self::PERSO_ENDORMI;
	    }
	    
	    // On indique au personnage qu'il doit recevoir des dégâts.
	    // Puis on retourne la valeur renvoyée par la méthode : self::PERSONNAGE_TUE ou self::PERSONNAGE_FRAPPE.
	    return $perso->recevoirDegats();
	}

	public function recevoirDegats()
	{
		$this->degats += 5;
		if ($this->degats >= 100) {
			return self::PERSONNAGE_TUE;
		} else {
			return self::PERSONNAGE_FRAPPE;
		}		
	}

	public function reveil()
	{
	    $secondes = $this->timeEndormi;
	    $secondes -= time();
	    
	    $heures = floor($secondes / 3600);
	    $secondes -= $heures * 3600;
	    $minutes = floor($secondes / 60);
	    $secondes -= $minutes * 60;
	    
	    $heures .= $heures <= 1 ? ' heure' : ' heures';
	    $minutes .= $minutes <= 1 ? ' minute' : ' minutes';
	    $secondes .= $secondes <= 1 ? ' seconde' : ' secondes';
	    
	    return $heures . ', ' . $minutes . ' et ' . $secondes;
	}

	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value) {
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method)) {
				$this->$method($value);
			}
		}
	}
}

