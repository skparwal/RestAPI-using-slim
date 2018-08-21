<?php

namespace App\Models;

use App\Models\Database;

class Recipient {
  private $table = "recipients";
  private $name;
  private $email;
  private $id;
  
  public function __construct($name = null, $email = null){
    $this->setName($name);
    $this->setEmail($email);
  }
  
  public function setId($id){
    $this->id = $id;
  }
  
  public function getId(){
    return $this->id;
  }

  private function setName($name){
    $this->name = $name;
  }
  
  public function getName(){
    return $this->name;
  }

  private function setEmail($email){
	$this->email = $email;
  }

  public function getEmail(){
    return $this->email;
  }
  
  public function findAll(){
    $sql = "SELECT id, name, email FROM $this->table WHERE status = 0 ORDER BY name ASC";
    $execute = Database::prepare($sql);
    $execute->execute();
    return $execute->fetchAll();
  }
  
  public function IsEmailExists(){
    $sql = "SELECT id FROM $this->table WHERE email = :email limit 1";
    $execute = Database::prepare($sql);
    $execute->bindValue(':email', $this->getEmail());
    $execute->execute();
    $record = $execute->fetch();
	
	if(is_object($record) && $record->id > 0) {
	  $this->setId($record->id);
	  return true;
	}
	return false;
  }
  
  public function IsRecordExists(){
    $sql = "SELECT id FROM $this->table WHERE id = :id AND status = 0 limit 1";
    $execute = Database::prepare($sql);
    $execute->bindValue(':id', $this->getId());
    $execute->execute();
    $record = $execute->fetch();
	
	if(is_object($record) && $record->id > 0) {
	  $this->setId($record->id);
	  return true;
	}
	return false;
  }

  public function insert(){
    $sql = "INSERT INTO $this->table 
            (name, email)
            VALUES 
            (:name, :email)";
    $execute = Database::prepare($sql);
    $execute->bindValue(':name', $this->getName());
    $execute->bindValue(':email', $this->getEmail());
	$execute->execute();
	$this->setId(Database::lastInsertId());

    return $this->getId();
  }

  public function update(){
    $sql = "UPDATE $this->table 
            SET name = :name, email = :email
            WHERE id = :id";
    $execute = Database::prepare($sql);
    $execute->bindParam(':id', $this->getId(), \PDO::PARAM_INT);
    $execute->bindValue(':name', $this->getName());
    $execute->bindValue(':email', $this->getEmail());
    $execute->execute();
	
	return $this->getId();
  }

  public function delete(){
    $sql = "UPDATE $this->table 
            SET status = :status
            WHERE id = :id";
    $execute = Database::prepare($sql);
    $execute->bindValue(':status', 1);
    $execute->bindParam(':id', $this->getId(), \PDO::PARAM_INT);
    $execute->execute();
	
	return $this->getId();
  }
}