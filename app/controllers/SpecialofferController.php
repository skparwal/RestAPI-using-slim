<?php
/**
 * Created by Sandeep Parwal.
 *
 */

namespace App\Controllers;

use App\Models\Specialoffer;
use App\Errors\ResponseError;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class SpecialofferController{
  protected $container;
  private $err;

  public function __construct(ContainerInterface $container){
    $this->container = $container;
	$this->err = new ResponseError();
  }
    
  public function index(Request $request, Response $response){
    $specialoffer = new Specialoffer();
    $records = $specialoffer->findAll();
	
	if(count($records) > 0) {
		$this->err->successMessage(sprintf(ResponseError::RECORD_FOUND, count($records)));
		$this->err->addMessage('data', $records);
	} else {
		$this->err->errorMessage('no_record', ResponseError::NO_RECORD_FOUND);
	}
    return $response->withJson($this->err->getMessages());
  }
  
  public function add(Request $request, Response $response){
	$input = $request->getParsedBody();
	  
    $specialoffer = new Specialoffer($input['name'], $input['discount']);

	if(empty($input['discount'])) {
		$this->err->errorMessage('discount', sprintf(ResponseError::DISCOUNT_MANDATORY, $input['discount']));
	} else {	
      if ($id = $specialoffer->insert()) {
		$input['id'] = $id;
		$this->err->successMessage(ResponseError::RECORD_INSERTED);
		$this->err->addMessage('data', $input);
	  } else {
		$this->err->errorMessage('not_insert', ResponseError::COMMON_ISSUE_MSG);
	  }
	}
	
	return $response->withJson($this->err->getMessages());
  }
  
  public function delete(Request $request, Response $response, $args){
    $specialoffer = new Specialoffer();
	$specialoffer->setId($args['id']);
	
	if($specialoffer->IsRecordExists()) {
		if ($specialoffer->delete()) {
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