<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected $message;

	protected $status_code;

	public function __construct($message,$status_code){
        $this->message = $message;
        $this->status_code = $status_code;
    }

    public function getCustomMassege(){
    	return $this->message;
    }

    public function getStatusCode(){
    	return $this->status_code;
    }
}
