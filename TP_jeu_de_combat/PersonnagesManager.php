<?php
class PersonnagesManager
{
  private $db;

  public function __construct($db)
  {
  	$this->setDb($db);
  }

  public function add(Personnages $perso)
  {
  	$req = $this->db->prepare('INSERT INTO personnages(nom, degats, atout) VALUES(:nom, :degats, :atout)');
  	$req->bindValue(':nom', $perso->getNom());
    $req->bindValue(':type', $perso->getType());
  	$req->bindValue(':degats', 0);
  	$req->bindValue(':atout', 0);
  	$req->execute();

  	$perso->hydrate([
  		'id' => $this->db->lastInsertId(),
  		'degats' => 0,
        'atout' => 0
  	]);
  }

  public function count()
  {
  	return $this->db->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
  }

  public function delete(Personnages $perso)
  {
  	$this->db->exec('DELETE FROM personnages WHERE id = ' . $perso->getId());
  }

  public function exists($info)
  {
  	if (is_int($info)) {
  		return (bool) $this->db->query('SELECT COUNT(*) FROM personnages WHERE id = ' . $info)->fetchColumn();
  	}

  	$req = $this->db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
  	$req->execute([':nom' => $info]);

  	return (bool) $req->fetchColumn();
  }

  public function get($info)
  {
    if (is_int($info)) {
      $req = $this->db->query('SELECT id, nom, degats, timeEndormi, type, atout FROM personnages WHERE id = '.$info);
      $perso = $req->fetch(PDO::FETCH_ASSOC);
    } else {
      $req = $this->db->prepare('SELECT id, nom, degats, timeEndormi, type, atout FROM personnages WHERE nom = :nom');
      $req->execute([':nom' => $info]);
      $perso = $req->fetch(PDO::FETCH_ASSOC);
    }
    
    switch ($perso['type']) {
      case 'guerrier': return new Guerrier($perso);
      case 'magicien': return new Magicien($perso);
      default: return null;
    }
  }

  public function getList($nom)
  {
  	$persos = [];
  	$req = $this->db->prepare('SELECT id, nom, degats, timeEndormi, type, atout FROM personnages WHERE nom <> :nom ORDER BY nom');
  	$req->execute([':nom' => $nom]);

  	while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
        switch ($donnees['type']) {
            case 'guerrier': $persos[] = new Guerrier($donnees); break;
            case 'magicien': $persos[] = new Magicien($donnees); break;
        }
	  	var_dump($donnees['type']);
  		var_dump($donnees['id']);
  	}

  	var_dump($persos);
  	return $persos;
  }

  public function update(Personnages $perso)
  {
      $req = $this->db->prepare('UPDATE personnages SET degats = :degats, timeEndormi = :timeEndormi, atout = :atout WHERE id = :id');
    
      $req->bindValue(':degats', $perso->getDegats(), PDO::PARAM_INT);
      $req->bindValue(':timeEndormi', $perso->timeEndormi(), PDO::PARAM_INT);
      $req->bindValue(':atout', $perso->getAtout(), PDO::PARAM_INT);
      $req->bindValue(':id', $perso->getId(), PDO::PARAM_INT);
    
      $req->execute();
  }

  public function setDb(PDO $db)
  {
  	$this->db = $db;
  }
}