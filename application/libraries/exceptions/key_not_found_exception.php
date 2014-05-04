<?php
	class Key_not_found_exception extends Exception
	{
		function __construct($message="")
		{
			parent::__construct($message);			
		}
	}
	
?>
