<?php
/**
 * Created by Sandeep Parwal.
 *
 */

namespace App\Controllers;

use App\Models\Voucher;
use App\Models\Recipient;
use App\Models\Specialoffer;
use App\Errors\ResponseError;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class VoucherController{
  protected $container;
  private $err;

  public function __construct(ContainerInterface $container){
    $this->container = $container;
	$this->err = new ResponseError();
  }
    
  public function index(Request $request, Response $response){
    $voucher = new Voucher();
    $records = $voucher->findAll();
	
	if(count($records) > 0) {
		$this->err->successMessage(sprintf(ResponseError::RECORD_FOUND, count($records)));
		$this->err->addMessage('data', $records);
	} else {
		$this->err->errorMessage('no_record', ResponseError::NO_RECORD_FOUND);
	}
    return $response->withJson($this->err->getMessages());
  }
  
  public function listing(Request $request, Response $response) {
	$voucher = new Voucher();
	$records = $voucher->findVoucherCounts();
	
	$data = ['totals'=>0, 'unused'=>0, 'used'=>0];
	if(is_object($records)) {
		$data['totals'] = (int)$records->totals;
		$data['unused'] = (int)$records->coupon_unused;
		$data['used'] = (int)$records->coupon_used;
		
		$vouchers = $voucher->getAllVouchers();
		
		if(!empty($vouchers )) {
		  $data['vouchers'] = $vouchers;
		}
	}

	return $this->container->view->render($response, 'listing.html.twig', $data);
  }
  
  public function add(Request $request, Response $response){
	$input = $request->getParsedBody();
	
	$specialoffer = new Specialoffer();
	$specialoffer->setId($input['offer_id']);
	if($specialoffer->IsRecordExists()) {

	  $recipient = new Recipient();
	  $recipients = $recipient->findAll();
	  if(count($recipients) > 0) {
		  	  
		  $voucher = new Voucher();
		  $voucher->setOfferId($input['offer_id']);
		  $voucher->setExpiryDate(date($input['expiry_date'].' H:i:s'));
		  
		  foreach($recipients as $recipientData) {
			$voucher->setVoucherCode($voucher->generateVoucherCode());
			$voucher->setRecipientId($recipientData->id);
			
			if ($id = $voucher->insert()) {
			  $ids['ids'][] = $id;
			  $this->err->successMessage(ResponseError::RECORD_INSERTED);
			  $this->err->addMessage('data', $ids);
			} else {
			  $this->err->errorMessage('not_insert', ResponseError::COMMON_ISSUE_MSG);
			}
		  }
	  } else {
		  $this->err->errorMessage('no_record', ResponseError::NO_RECIPIENTS);
	  }
	} else {
		$this->err->errorMessage('no_record', sprintf(ResponseError::NO_SPECIAL_RECORD, $input['offer_id']));
	}
	
	return $response->withJson($this->err->getMessages());
  }
  
  public function reedim(Request $request, Response $response){
	$input = $request->getParsedBody();
	
	$voucher = new Voucher();
	$voucher->setVoucherCode($input['voucher']);
	
	$recipient = new Recipient(null, $input['email']);
	if($recipient->IsEmailExists()) {
		$recipientId = $recipient->getId();
		
		if($voucher->IsVoucherCodeExists()) {
			if($voucher->IsVoucherAssociatedExists($recipientId)) {
				$voucher->setCouponUsed(1);
				$voucher->setRecipientId($recipientId);
				$voucher->setReedimDate(date('Y-m-d H:i:s', time()));
				
				if ($voucher->update()) {
					$this->err->successMessage(ResponseError::RECORD_UPDATED);
					
					$specialoffer = new Specialoffer();
					$specialoffer->setId($voucher->getOfferId());
					if($specialoffer->IsRecordExists()) {
						$discount = array('discount' => $specialoffer->getDiscount());
						$this->err->addMessage('data', $discount);
					}
				}
			} else {
				$this->err->errorMessage('no_record', sprintf(ResponseError::NO_VOUCHER_RECIPIENT_FOUND, $input['voucher'], $input['email']));
			}
		} else {
			$this->err->errorMessage('no_record', sprintf(ResponseError::VOUCHER_NOT_EXISTS, $input['voucher']));
		}
	} else {		
		$this->err->errorMessage('no_record', sprintf(ResponseError::NO_RECIPIENT_EMAIL_FOUND, $input['email']));
	}	
	
	return $response->withJson($this->err->getMessages());
  }
  
  public function delete(Request $request, Response $response, $args){
    $voucher = new Voucher();
	$voucher->setId($args['id']);
	
	if($voucher->IsRecordExists()) {
		if ($voucher->delete()) {
			$this->err->successMessage(ResponseError::RECORD_DELETED);
		} else {
			$this->err->successMessage(ResponseError::COMMON_ISSUE_MSG);
		}
	} else {
		$this->err->errorMessage('not_exists', ResponseError::NO_RECORD_FOUND);
	}
	
	return $response->withJson($this->err->getMessages());
  }
}

?>