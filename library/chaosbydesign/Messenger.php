<?php

/*
 * Messenger
 *
 * Create alerts to show the user
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class Messenger
{
	// Set variables
	protected $_class;
	protected $_message;
	
	// Construct
	public function __construct()
	{
		
	}
	
	// Create message
	public function createMessage($class = null, $message = null)
	{
		// Set variable for the class
		$_class = 'alert-'.$class;
			
		// Check if all values are there
		$_SESSION['messenger_message'] = (!empty($message) && $message != null) ? '<div class="alert '.$_class.' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'.$message.'</div>' : 'asd';
	}
	
	// Get a message
	public function getMessage()
	{	
		// Check for session and return and unset
		if(isset($_SESSION['messenger_message']))
		{
			// Return message
			echo $_SESSION['messenger_message'];
			
			// Unset message
			unset($_SESSION['messenger_message']);
		}
	}
}