<?php

/*
 * Form
 *
 * Create forms
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class Form
{
	// Set variables
	protected $_identifier;
	protected $_element;
	protected $_label;
	protected $_attributes;
	protected $_validators;
	protected $_value;
	protected $_errors;
	protected $_labelClass = '';
	protected $_allElements;
	protected $_isValid;

	// Construct
	public function __construct()
	{
		// Create object
		$this->_allElements = new StdClass;
	}
	
	// Add input
	public function addInput($name = null)
	{
		// Check if all values are there
		if(!empty($name) && $name != null)
		{
			// Format name
			$name = $this->formatName($name);

			// Set the identifier
			$this->_identifier = $name;

			// Start element
			$this->_element = '<input type="text" name="'.$name.'" id="'.$name.'" %attributes%>';

			// Return the object
			return $this;
		}
	}
	
	// Add select field
	public function addSelect($name = null, $options = null)
	{
		// Check if all values are there
		if(!empty($name) && $name != null)
		{
			// Format name
			$name = $this->formatName($name);

			// Set the identifier
			$this->_identifier = $name;
			
			// Options string
			$optionsString = '';
			
			// Check for options and add them
			if(!empty($options) && $options != null && is_array($options))
			{
				// Loop over options
				foreach($options as $val => $text)
				{
					// Check for post value and set selected if it matches
					$selected = ($this->isPost() && $this->getPost($this->_identifier) == $val) ? ' selected' : '';
						
					// Add options to string
					$optionsString .= '<option value="'.$val.'"'.$selected.'>'.$text.'</option>';
				}
			}
			
			// Start element
			$this->_element = '<select name="'.$name.'" id="'.$name.'" %attributes%>'.$optionsString.'</select>';
			
			// Return the object
			return $this;
		}
	}
	
	// Add date
	public function addDate($name = null, $format = 'd-m-y', $yearsStart = 1800)
	{
		// Check if all values are there
		if(!empty($name) && $name != null)
		{
			// Format name
			$name = $this->formatName($name);

			// Set the identifier
			$this->_identifier = $name;

			// Set variables
			$days = array('' => '');
			$months = array('' => '');
			$years = array('' => '');
			
			// Create days
			for($i = 1; $i <= 31; $i++)
			{	
				// Add day values
				$days[sprintf('%02d', $i)] = sprintf('%02d', $i);
			}
			
			// Create months
			for($i = 1; $i <= 12; $i++)
			{
				// Add month values
				$months[sprintf('%02d', $i)] = strftime('%B', mktime(0, 0, 0, $i));
			}
			
			// Create years
			for($i = date('Y', time()); $i >= $yearsStart; $i--)
			{
				// Add years values
				$years[$i] = $i;	
			}
			
			// Create names
			$dayName = $name.'_day';
			$monthName = $name.'_month';
			$yearName = $name.'_year';
			
			// Create select fields and assign to the all elements
			$this->addSelect($dayName, $days);
			$this->_allElements->$dayName = $this->_element;
			
			$this->addSelect($monthName, $months);
			$this->_allElements->$monthName = $this->_element;
			
			$this->addSelect($yearName, $years);
			$this->_allElements->$yearName = $this->_element;
			
			// Assign to the correct identifier
			switch($format)
			{
				case 'd-m-y':
					$dayMonthOrder = $this->_allElements->$dayName.$this->_allElements->$monthName;
				break;
				case 'm-d-y':
					$dayMonthOrder = $this->_allElements->$monthName.$this->_allElements->$dayName;
				break;
			}
			
			// Tell identifiers to the name
			$this->_element = $dayMonthOrder.$this->_allElements->$yearName;
			
			// Reset the identifier
			$this->_identifier = $name;
			
			// Return the object
			return $this;
		}
	}
	
	// Add submit
	public function addSubmit($value = null)
	{
		// Check if all values are there
		if(!empty($value) && $value != null)
		{
			// Set the identifier
			$this->_identifier = $this->formatName($value);
			
			// Start element
			$this->_element = '<input type="submit" value="'.$value.'" %attributes%>';

			// Return the object
			return $this;
		}
	}
	
	// Add an label
	public function addLabel($text = null)
	{
		// Get identifier
		$identifier = $this->_identifier;
		
		// Check if a text is set
		if(!empty($text) && $text != null)
		{
			// Add label
			$this->_label = '<label for="'.$this->_identifier.'" %attributes%>'.$text.'</label>';
			
			// Return the object
			return $this;
		}
	}
	
	// Add attribute
	public function addAttribute($attribute = null, $value = null)
	{
		// Check if all values are there
		if(!empty($attribute) && $attribute != null)
		{
			// Check if object is created
			if(!is_object($this->_attributes))
			{
				// Create object
				$this->_attributes = new StdClass;
			}
			
			// Check if there is a value. If not just add attribute
			if(!empty($value) && $value != null)
			{
				// Add attribute and values
				$this->_attributes->$attribute = $value;
			}
			else
			{
				// Add attribute
				$this->_attributes->$attribute = '';
			}
		}
		
		// Return the object
		return $this;
	}
	
	// Add an validator
	public function addValidator($validator = null, $value = null, $message = null)
	{
		// Check if a validator is set
		if(!empty($validator) && $validator != null)
		{
			// Check if object is created
			if(!is_object($this->_validators))
			{
				// Create object
				$this->_validators = new StdClass;
			}
			
			// Create object for the item
			$validatorClass = new StdClass;
			
			// Validator extra actions
			switch($validator)
			{
				// Case required
				case 'required':					
					// Add required attribue
					//$this->addAttribute($validator);
					
					// Set required class on label
					$this->_labelClass = $validator;
					
					// Check for custom error message
					$message = (!empty($message) && $message != null) ? $message : 'Dit is een verplicht veld';
				break;
					// Case Regex
				case 'regex':					
					// Check for custom error message
					$message = (!empty($message) && $message != null) ? $message : 'Het regex patroon is niet geldig';
				break;
			}

			// Check if there is a value
			if(!empty($value) && $value != null)
			{
				// Set value to the object
				$validatorClass->value = $value;
			}
			
			// Set error message
			$validatorClass->message = $message;
			
			// Add info to the object
			$this->_validators->$validator = $validatorClass;
			
			// Return the object
			return $this;
		}
	}	
	
	// Add finishing
	public function finish()
	{
		// Set variables
		$attributes = '';
		
		// Get identifier
		$identifier = $this->_identifier;
		
		// Init class
		$this->_allElements->$identifier = new StdClass;

		// Check for post value
		if($this->isPost())
		{
			// Get the post value
			$this->_value = $this->getPost($identifier);
			
			// Set the value
			if(array_key_exists($identifier.'_day', $_POST) && array_key_exists($identifier.'_month', $_POST) && array_key_exists($identifier.'_year', $_POST)) // Check if there are date values
			{
				// Collect complete date
				$this->_value[$identifier] = $this->_value[$identifier.'_day'].'-'.$this->_value[$identifier.'_month'].'-'.$this->_value[$identifier.'_year'];
				
				// Set the post value
				$_POST[$identifier] = ($this->_value[$identifier] == '--') ? '' : $this->_value[$identifier];;
			}
			elseif(!empty($this->_value) && $this->_value != null)
			{
				// Add value to attributes
				$this->addAttribute('value', $this->_value);
			}
			
			// Validate element
			$this->isValidElement();
		}

		// Convert all attributes to string
		foreach($this->_attributes as $attribute => $value)
		{
			// Check if there is a value. If not just add attribute
			if(!empty($value) && $value != null && !is_array($value))
			{
				// Add attribute and values
				$attributes .= $attribute.'="'.$value.'" ';	
			}
			elseif(!is_array($value))
			{
				// Add attribute
				$attributes .= $attribute.' ';
			}
		}
		
		// Set classes for label if necessary
		$this->_label = str_replace('%attributes%', rtrim('class="'.$this->_labelClass.'"'), $this->_label);

		// Place attributes on element
		$this->_element = str_replace('%attributes%', rtrim($attributes), $this->_element);

		// Add element to array
		$this->_allElements->$identifier = $this->_label.$this->_element.$this->_errors;
		
		// Reset all elements
		$this->resetElements();
		
		// Return the object
		return $this;
	}

	// Reset the elements
	public function resetElements()
	{
		// Reset variables for next element
		$this->_identifier = null;
		$this->_element = null;
		$this->_label = null;
		$this->_attributes = null;
		$this->_validators = null;
		$this->_value = null;
		$this->_errors = null;
		$this->_labelClass = null;

		// Return the object
		return $this;
    }
	
	// Render form
	public function render()
	{	
		//print_r($this->_allElements);
		
		// Return the object
		return (object) $this->_allElements;
	}
	
	// Check for post
	public function isPost()
	{
		// Check request method
		return ($_SERVER['REQUEST_METHOD'] === 'POST') ? true : false;
	}
	
	// Returns if errors are found
	public function isValid()
	{		
		// Return true or false
		return $this->_isValid;
	}
	
	// Check if form is valid
	public function isValidElement()
	{		
		// No errors found
		$errors = '';
		
		// Set identifier
		$identifier = $this->_identifier;
		
		// Check for validators
		if(!empty($this->_validators) && $this->_validators != null)
		{
			// Loop over validators
			foreach($this->_validators as $validator => $properties)
			{							
				// All types
				switch($validator)
				{
					// Required
					case 'required':						
						// Check for date value
						if(array_key_exists($identifier.'_day', $_POST) && array_key_exists($identifier.'_month', $_POST) && array_key_exists($identifier.'_year', $_POST))
						{
							// Check if value is not empty and is 8 characters long
							if(strlen($this->_value[$identifier]) != 10 || $this->_value[$identifier] == '--')
							{
								// Add error message
								$errors .= '<li>'.$properties->message.'</li>';
							}
						}
						else
						{
							// Check if value is not empty
							if(empty($this->_value))
							{
								// Add error message
								$errors .= '<li>'.$properties->message.'</li>';
							}
						}
					break;
					// Regex
					case 'regex':
						// Check if regex matches
						if(!preg_match($properties->value, $this->_value))
						{
							// Add error message
							$errors .= '<li>'.$properties->message.'</li>';
						}
					break;
				}
			}
			
			// Check for errors
			if(!empty($errors) && $errors != null)
			{
				// Set error messages
				$this->_errors = '<ul class="errors">'.$errors.'</ul>';
				
				// Check if classes has been set and update on error with error class
				$this->_attributes->class = (isset($this->_attributes->class)) ? $this->_attributes->class.' has-error' : $this->addAttribute('has-error');
				
				// Do this for the label class as well
				$this->_labelClass = (!empty($this->_labelClass) && $this->_labelClass != null) ? $this->_labelClass.' has-error' : $this->_labelClass;
				
				// Set form to invalid
				$this->_isValid = false;
			}
			else
			{
				// Set form to valid
				$this->_isValid = true;	
			}
			
			// Return the object
			return $this;
		}
	}
	
	// Get Post value or values
	public function getPost($key = null)
	{
		// Internal check for post
		if($this->isPost())
		{
			// If key is not defined return all
			if(!empty($key) && $key !== null && array_key_exists($key, $_POST))
			{
				// Return request value
				return $_POST[$key];	
			}
			else
			{
				// Return all
				return $_POST;
			}
		}
	}
	
	// Format name value
	public function formatName($name = null)
	{
		// Check if a validator is set
		if(!empty($name) && $name != null)
		{
			// Format name
			return str_replace(array(' '), array(''), strtolower($name));
		}
	}
}