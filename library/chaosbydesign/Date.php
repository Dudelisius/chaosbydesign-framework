<?php

/*
 * Date
 *
 * Do al sorts of freaky stuff with dates
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class Date
{
	// Set variables
	protected $_timezone;

	
	// Construct
	public function __construct()
	{
		// Set the timezone
		$this->_timezone = new DateTimeZone('Europe/Brussels');
	}
	
	// Create message
	public function calcToBirthday($dateofbirth = null, $format = 'd-m-Y')
	{
		// Check if date of birth is not empty
		if(!empty($dateofbirth) && $dateofbirth != null)
		{
			// Get today
			$today = new DateTime('midnight today', $this->_timezone);

			// Format the date of birth
			$dateofbirth = DateTime::createFromFormat('d-m-Y', str_replace(array(substr($dateofbirth, 6, 10)), array(date('Y')), $dateofbirth), $this->_timezone);

			// Check if birthday has been or is in the future
			if($dateofbirth < $today)
			{
				// Already passed his birthday, so calculate to next year
				$dateofbirth->modify("+1 Year"); 
			}

			// Calculate the difference from today to the birthday
			$diff = $dateofbirth->diff($today);

			// Return the remaining days
			return $diff->days;
		}
	}
	
	// Calculate the age
	public function age($dateofbirth = null, $dateofdeath = null, $format = 'd-m-Y')
	{
		// Check if date of birth is not empty
		if(!empty($dateofbirth) && $dateofbirth != null)
		{
			// Get right now
			$now = new DateTime('now', $this->_timezone);

			// Check if the person is decease
			if(!empty($dateofdeath) && $dateofdeath != null)
			{
				// Calc age
				$age = DateTime::createFromFormat($format, $dateofdeath, $this->_timezone)->diff(DateTime::createFromFormat('d-m-Y', $dateofbirth, $this->_timezone));
			}
			else
			{
				// Calc age
				$age = DateTime::createFromFormat($format, $dateofbirth, $this->_timezone)->diff($now);
			}
		}
		
		// Return the age
		return $age;
	}
}