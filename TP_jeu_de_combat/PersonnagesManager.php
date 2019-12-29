<?php
class PersonnagesManager
{
  private $_db;

<<<<<<< HEAD
  public function __construct($_db)
  {
  	$this->setDb($_db);
=======
  public function __construct($_bd)
  {
  	$this->setDb($db);
>>>>>>> master
  }

  public function add(Personnages $perso)
  {
<<<<<<< HEAD
  	$req = $this->_db->prepare('INSERT INTO personnages(nom, degats) VALUES(:nom, :degats)');
  	$req->bindValue(':nom', $perso->getNom());
  	$req->bindValue(':degats', 0);
=======
  	$req = $this->_db->prepare('INSERT INTO personnages(nom) VALUES(:nom)')
  	$req->bindValue(':nom', $perso->nom());
>>>>>>> master
  	$req->execute();

  	$perso->hydrate([
  		'id' => $this->_db->lastInsertId(),
  		'degats' => 0,
  	]);
  }

  public function count()
  {
  	return $this->_db->query('SELECT COUNT(*) FROM personnages')->fetchColumn();
  }

<<<<<<< HEAD
  public function delete(Personnages $perso)
  {
  	$this->_db->exec('DELETE FROM personnages WHERE id = ' . $perso->id());
=======
  public function delete(Personnage $perso)
  {
  	$this->_db->exec('DELETE FROM personnages WHERE id = ' . $perso->id())
>>>>>>> master
  }

  public function exists($info)
  {
  	if (is_int($info)) {
  		return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = ' . $info)->fetchColumn();
  	}

<<<<<<< HEAD
  	$req = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
=======
  	$req = $this->db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
>>>>>>> master
  	$req->execute([':nom' => $info]);

  	return (bool) $req->fetchColumn();
  }

  public function get($info)
  {
<<<<<<< HEAD
  	if (is_int($info)) {
  		$req = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = ' . $info);
  		$donnee = $req->fetch(PDO::FETCH_ASSOC);
  		return new Personnages($donnee);
  	} else {
  		$req = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom = :nom');
  		$req->execute([':nom' => $info]);
  		return new Personnages($req->fetch(PDO::FETCH_ASSOC));
  	}  	
=======

>>>>>>> master
  }

  public function getList($nom)
  {
<<<<<<< HEAD
  	$persos = [];
  	$req = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom <> :nom ORDER BY nom');
  	$req->execute([':nom' => $nom]);

  	while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
  		$persos[] = new Personnages($donnees);
  		var_dump($donnees);
  	}

  	return $persos;
  }

  public function update(Personnages $perso)
  {
  	$req = $this->_db->prepare('UPDATE personnages SET degats = :degats WHERE id = :id');
  	$req->bindvalue(':degats', $perso->getDegats(), PDO::PARAM_INT);
  	$req->bindvalue(':id', $perso->getId(), PDO::PARAM_INT);
  	$req->execute();
=======

  }

  public function update(Personnage $perso)
  {

>>>>>>> master
  }

  public function setDb(PDO $db)
  {
  	$this->_db = $db;
  }
}