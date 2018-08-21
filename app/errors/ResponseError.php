<?php

namespace App\Errors;

class ResponseError
{
    const INTERNAL_SERVER_ERROR = 500;
    const VALIDATION_ERROR = 422;
	const SUCCESS_STATUS = 200;
	const PAGE_NOT_FOUND = 404;
	const NO_RECORD_FOUND = "No record(s) found.";
	const RECORD_INSERTED = "Record inserted succesfully.";	
	const RECORD_UPDATED = "Record updated succesfully.";
	const RECORD_DELETED = "Record deleted succesfully/";
	const RECORD_FOUND = "%s record(s) are found.";
	const EMAIL_MANDATORY = "Email is mandatory.";
	const DISCOUNT_MANDATORY = "Discount is mandatory.";
	const EMAIL_EXISTS = "%s email id is already exists.";
	const COMMON_ISSUE_MSG = "There is a technical issue. Please try again later.";
	const NO_SPECIAL_RECORD = "There is no record found against special offer id: %s";
	const NO_RECIPIENTS =" There is no recipient found in our system.";
	const NO_RECIPIENT_EMAIL_FOUND = "No recipient found against '%s' email.";
	const NO_VOUCHER_RECIPIENT_FOUND = "Voucher number: '%s' is not associated with '%s' recipient or it is already being used.";
	const VOUCHER_NOT_EXISTS = "Voucher number: '%s' doesn't exists.";

    private $messages;

    public function addMessage($key, $message, $field='')
    {
		if($field) {
		  $this->messages[$key][$field] = $message;
		} else {
		  $this->messages[$key] = $message;
		}
    }
	
	public function errorMessage($key, $message)
    {
		$this->setStatus(ResponseError::VALIDATION_ERROR);
		$this->addMessage('errors', $message, $key);
    }	
	
	public function successMessage($message)
    {
		$this->setStatus(ResponseError::SUCCESS_STATUS);
        $this->addMessage('success', $message);
    }

    public function getMessages()
    {
        return $this->messages;
    }

    private function setStatus($s)
    {
        $this->messages['status'] = $s;
    }
}