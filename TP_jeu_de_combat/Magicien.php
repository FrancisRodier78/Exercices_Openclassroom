<?php
class Magicien extends Personnages
{
    public function lancerUnSort(Personnages $perso)
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
        
        if ($perso->getId() == $this->getId()) {
          return self::CEST_MOI;
        }
        
        if ($this->getAtout() == 0) {
          return self::PAS_DE_MAGIE;
        }
        
        if ($this->getTimeEndormi()) {
          return self::PERSO_ENDORMI;
        }
        
        $perso->setTimeEndormi(time() + ($this->getAtout() * 6) * 3600);
        
        return self::PERSONNAGE_ENSORCELE;
    }
}