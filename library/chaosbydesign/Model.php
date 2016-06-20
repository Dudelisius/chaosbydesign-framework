<?php

/*
 * Model
 *
 * Model
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class Model
{
	// Variables
	protected $_model;
    
    // Construct
	public function __construct()
	{
        // Set variables
		$this->_model = get_class($this);
        $defaultModel = ($this->_model == 'Model');
        
        if(!$defaultModel)
		{
            $this->table = preg_replace('/Model$/', '', $this->_model);     
        }
		
		// Database class
		$this->database = new MySQL();
	}
	
	// Get all
	public function getAll($table = null)
	{
		// Check if table is set
		if(!empty($table) && $table !== null)
		{
			// Return results
			return $this->database->getAll($table);
		}
	}
	
	// Count table
	public function countTable($table)
	{
		// Check if table is set
		if(!empty($table) && $table !== null)
		{
			// Return results
			return $this->database->countTable($table);
		}
	}
	
	// Insert row
	public function insert($table = null, $values = null)
	{
		// Check if table is set
		if(!empty($table) && $table !== null && !empty($values) && $values !== null && is_array($values))
		{
			// Return results
			return $this->database->insert($table, $values);
		}
	}
	
	// Get by value
	public function getWhere($table = null, $values = null)
	{
		// Check if table is set
		if(!empty($table) && $table !== null && !empty($values) && $values !== null && is_array($values))
		{
			// Return results
			return $this->database->getWhere($table, $values);
		}
	}
	
	// Check if a value exists in the database
	public function checkExists($table = null, $values = null)
	{
		// Check if table is set
		if(!empty($table) && $table !== null && !empty($values) && $values !== null && is_array($values))
		{
			// Return results
			return $this->database->checkExists($table, $values);
		}
	}
}
