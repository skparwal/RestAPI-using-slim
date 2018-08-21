<?php

namespace App\Models;

use App\Models\Database;

class Voucher {
  private $table = "voucher_codes";
  private $voucherCode;
  private $recipientId;
  private $offerId;
  private $expiryDate;
  private $couponUsed;
  private $reedimDate;
  private $id;
  
  public function setId($id){
    $this->id = $id;
  }
  
  public function getId(){
    return $this->id;
  }

  public function setVoucherCode($voucherCode){
    $this->voucherCode = $voucherCode;
  }
  
  public function getVoucherCode(){
    return $this->voucherCode;
  }

  public function setRecipientId($recipientId){
	$this->recipientId = $recipientId;
  }

  public function getRecipientId(){
    return $this->recipientId;
  }
  
  public function setOfferId($offerId){
    $this->offerId = $offerId;
  }
  
  public function getOfferId(){
    return $this->offerId;
  }
  
  public function setExpiryDate($expiryDate){
    $this->expiryDate = $expiryDate;
  }
  
  public function getExpiryDate(){
    return $this->expiryDate;
  }

  public function setCouponUsed($couponUsed){
	$this->couponUsed = $couponUsed;
  }

  public function getCouponUsed(){
    return $this->couponUsed;
  }  
  
  public function setReedimDate($reedimDate){
    $this->reedimDate = $reedimDate;
  }
  
  public function getReedimDate(){
    return $this->reedimDate;
  }
  
  public function generateVoucherCode() {
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ".time();
    $code = "";
    for ($i = 0; $i < 10; $i++) {
      $code .= $chars[mt_rand(0, strlen($chars)-1)];
    }
	
	return $code;
  }
  
  public function findAll(){
    $sql = "SELECT * FROM $this->table WHERE status = 0 ORDER BY expiry_date ASC";
    $execute = Database::prepare($sql);
    $execute->execute();
    return $execute->fetchAll();
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
  
  public function IsVoucherCodeExists(){
    $sql = "SELECT id, special_offers_id FROM $this->table WHERE voucher_code = :voucher_code AND status = 0 limit 1";
    $execute = Database::prepare($sql);
    $execute->bindValue(':voucher_code', $this->getVoucherCode());
    $execute->execute();
    $record = $execute->fetch();
	
	if(is_object($record) && $record->id > 0) {
	  $this->setId($record->id);
	  $this->setOfferId($record->special_offers_id);
	  return true;
	}
	return false;
  }
  
  public function IsVoucherAssociatedExists($recipientId=0){
    $sql = "SELECT id FROM $this->table WHERE voucher_code = :voucher_code AND recipient_id = :recipient_id AND coupon_used = 0 AND status = 0 limit 1";
    $execute = Database::prepare($sql);
    $execute->bindValue(':voucher_code', $this->getVoucherCode());
	$execute->bindValue(':recipient_id', $recipientId);
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
            (voucher_code, special_offers_id, expiry_date, recipient_id)
            VALUES 
            (:voucher_code, :special_offers_id, :expiry_date, :recipient_id)";
    $execute = Database::prepare($sql);
    $execute->bindValue(':voucher_code', $this->getVoucherCode());
    $execute->bindValue(':special_offers_id', $this->getOfferId());
	$execute->bindValue(':expiry_date', $this->getExpiryDate());
    $execute->bindValue(':recipient_id', $this->getRecipientId());
	$execute->execute();
	$this->setId(Database::lastInsertId());

    return $this->getId();
  }

  public function update(){
    $sql = "UPDATE $this->table 
            SET coupon_used = :coupon_used, recipient_id = :recipient_id
            WHERE id = :id";
    $execute = Database::prepare($sql);
    $execute->bindParam(':id', $this->getId(), \PDO::PARAM_INT);
    $execute->bindValue(':coupon_used', $this->getCouponUsed());
	$execute->bindValue(':recipient_id', $this->getRecipientId());
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
  
  public function findVoucherCounts() {
	$sql = "select 
				count(*) as totals,				
                sum(case when coupon_used = 0 then 1 else 0 end) as coupon_unused,
                sum(case when coupon_used = 1 then 1 else 0 end) as coupon_used
                
            from $this->table";

    $execute = Database::prepare($sql);
    $execute->bindValue(':id', $this->getId());
    $execute->execute();
    return $execute->fetch();
  }
  
  public function getAllVouchers() {
	$sql = "
	  SELECT 
	    v.id, v.voucher_code, v.coupon_used, r.email, DATE_FORMAT(v.date_of_reedim, '%d-%m-%Y') as date_of_reedim
	  FROM 
	    voucher_codes as v INNER JOIN recipients as r ON r.id = v.recipient_id 
	  WHERE v.status = 0 and r.status = 0
	";
	$execute = Database::prepare($sql);
    $execute->execute();
    return $execute->fetchAll();
  }
}