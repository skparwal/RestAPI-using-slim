<?php
/**
 * Created by Sandeep Parwal.
 *
 */

namespace App\Controllers;

use App\Models\Recipient;
use App\Errors\ResponseError;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RecipientController{
  protected $container;
  private $err;

  public function __construct(ContainerInterface $container){
    $this->container = $container;
	$this->err = new ResponseError();
  }
    
  public function index(Request $request, Response $response){
    $recipient = new Recipient(); // get instance of data access object layer
    $records = $recipient->findAll(); // get all recipients
	
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
	  
    $recipient = new Recipient($input['name'], $input['email']);

	$IsEmailExists = $recipient->IsEmailExists();
	
	if(empty($input['email'])) {
		$this->err->errorMessage('email', ResponseError::EMAIL_MANDATORY);
	} else if(true === $IsEmailExists) {	
		$this->err->errorMessage('email', sprintf(ResponseError::EMAIL_EXISTS, $input['email']));
	} else {	
      if ($id = $recipient->insert()) {
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
    $recipient = new Recipient();
	$recipient->setId($args['id']);
	
	if($recipient->IsRecordExists()) {
		if ($recipient->delete()) {
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