<?php

namespace Allice\Exception;

class Knave_of_Hearts extends \Exception
{
	public function __construct($_message, $_code = 0, Exception $_previous = null) 
	{
		parent::__construct($_message, $_code, $_previous);
	}
}

?>
