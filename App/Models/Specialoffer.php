<?php

namespace App\Models;

use App\Models\Database;

class Specialoffer {
  private $table = "special_offers";
  private $name;
  private $discount;
  private $id;
  
  public function __construct($name = null, $discount = null){
    $this->setName($name);
    $this->setDiscount($discount);
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

  private function setDiscount($discount){
	$this->discount = $discount;
  }

  public function getDiscount(){
    return $this->discount;
  }
  
  public function findAll(){
    $sql = "SELECT id, name, discount FROM $this->table WHERE status = 0 ORDER BY name ASC";
    $execute = Database::prepare($sql);
    $execute->execute();
    return $execute->fetchAll();
  }
  
  public function IsRecordExists(){
    $sql = "SELECT id, name, discount FROM $this->table WHERE id = :id AND status = 0 limit 1";
    $execute = Database::prepare($sql);
    $execute->bindValue(':id', $this->getId());
    $execute->execute();
    $record = $execute->fetch();
	
	if(is_object($record) && $record->id > 0) {
	  $this->setId($record->id);
	  $this->setName($record->name);
	  $this->setDiscount($record->discount);
	  return true;
	}
	return false;
  }

  public function insert(){
    $sql = "INSERT INTO $this->table 
            (name, discount)
            VALUES 
            (:name, :discount)";
    $execute = Database::prepare($sql);
    $execute->bindValue(':name', $this->getName());
    $execute->bindValue(':discount', $this->getDiscount());
	$execute->execute();
	$this->setId(Database::lastInsertId());

    return $this->getId();
  }

  public function update(){
    $sql = "UPDATE $this->table 
            SET name = :name, discount = :discount
            WHERE id = :id";
    $execute = Database::prepare($sql);
    $execute->bindParam(':id', $this->getId(), \PDO::PARAM_INT);
    $execute->bindValue(':name', $this->getName());
    $execute->bindValue(':discount', $this->getDiscount());
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