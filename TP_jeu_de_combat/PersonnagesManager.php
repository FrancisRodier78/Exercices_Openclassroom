<?php
class PersonnagesManager
{
  private $_db;

  public function __construct($_bd)
  {
  	$this->setDb($db);
  }

  public function add(Personnages $perso)
  {
  	$req = $this->_db->prepare('INSERT INTO personnages(nom, degats) VALUES(:nom, :degats)');
  	$req->bindValue(':nom', $perso->getNom());
  	$req->bindValue(':degats', 0);
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

  public function delete(Personnages $perso)
  {
  	$this->_db->exec('DELETE FROM personnages WHERE id = ' . $perso->id());
  }

  public function exists($info)
  {
  	if (is_int($info)) {
  		return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = ' . $info)->fetchColumn();
  	}

  	$req = $this->_db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
  	$req->execute([':nom' => $info]);

  	return (bool) $req->fetchColumn();
  }

  public function get($info)
  {
  	if (is_int($info)) {
  		$req = $this->_db->query('SELECT id, nom, degats FROM personnages WHERE id = ' . $info);
  		$donnee = $req->fetch(PDO::FETCH_ASSOC);
  		return new Personnages($donnee);
  	} else {
  		$req = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom = :nom');
  		$req->execute([':nom' => $info]);
  		return new Personnages($req->fetch(PDO::FETCH_ASSOC));
  	}  	
  }

  public function getList($nom)
  {
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
  }

  public function setDb(PDO $db)
  {
  	$this->_db = $db;
  }
}