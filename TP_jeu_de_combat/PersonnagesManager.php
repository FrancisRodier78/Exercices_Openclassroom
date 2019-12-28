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
  	$req = $this->_db->prepare('INSERT INTO personnages(nom) VALUES(:nom)')
  	$req->bindValue(':nom', $perso->nom());
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

  public function delete(Personnage $perso)
  {
  	$this->_db->exec('DELETE FROM personnages WHERE id = ' . $perso->id())
  }

  public function exists($info)
  {
  	if (is_int($info)) {
  		return (bool) $this->_db->query('SELECT COUNT(*) FROM personnages WHERE id = ' . $info)->fetchColumn();
  	}

  	$req = $this->db->prepare('SELECT COUNT(*) FROM personnages WHERE nom = :nom');
  	$req->execute([':nom' => $info]);

  	return (bool) $req->fetchColumn();
  }

  public function get($info)
  {

  }

  public function getList($nom)
  {

  }

  public function update(Personnage $perso)
  {

  }

  public function setDb(PDO $db)
  {
  	$this->_db = $db;
  }
}