<?php

namespace App\Exceptions;

use Exception;

class BadRequestException extends Exception
{
    protected $message;

	public function __construct($message){
        $this->message = $message;

    }

    public function getBadRequestMassege(){
    	return $this->message;
    }
}
