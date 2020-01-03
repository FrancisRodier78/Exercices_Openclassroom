<?php
class Guerrier extends Personnages
{
    public function recevoirDegats()
    {
      if ($this->getDegats() >= 0 && $this->getDegats() <= 25) {
        $this->setAtout(4);
      } elseif ($this->getDegats() > 25 && $this->getDegats() <= 50) {
        $this->setAtout(3);
      } elseif ($this->getDegats() > 50 && $this->getDegats() <= 75) {
        $this->setAtout(2);
      } elseif ($this->getDegats() > 75 && $this->getDegats() <= 90) {
        $this->setAtout(1);
      } else {
        $this->setAtout(0);
      }
      
      $this->setDegats($this->getDegats() + 5 - $this->getAtout());
      
      // Si on a 100 de dégâts ou plus, on supprime le personnage de la BDD.
      if ($this->getDegats() >= 100) {
        return self::PERSONNAGE_TUE;
      }
      
      // Sinon, on se contente de mettre à jour les dégâts du personnage.
      return self::PERSONNAGE_FRAPPE;
    }
}