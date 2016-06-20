<?php

/*
 * MySQL
 *
 * Setups connection to databases
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class MySQL
{
    // Variables    
    public $_connection;

	// Construct
    public function __construct()
	{
    	// Get config
		$ini = parse_ini_file(ROOT . DS . 'application' . DS . 'config' . DS . 'application.ini', true)['database'];
		
		// Try connection
		try
		{
			$this->_connection = new PDO('mysql:host='.$ini['host'].';dbname='.$ini['database'].';charset='.$ini['charset'], $ini['username'], $ini['password']);
			$this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e)
		{
			// Return error
			return $e->getMessage();
		}
    }

	// Get all results
	public function getAll($table = null)
	{
		// Check for Table
		if(!empty($table) && $table !== null)
		{
			// Try getting all data
			try
			{
				// Create new Object
				$results = new stdClass();

				// Prepare query
				$statement = $this->_connection->prepare('SELECT * FROM '.$table.'');

				// Execute statement
				$statement->execute();

				// Set counter to 0
				$i = 0;

				// Get results als create object
				while($row = $statement->fetch(PDO::FETCH_OBJ))
				{
					// Add to main object
					$results->$i = $row;

					// Increment counter
					$i++;
				}

				// Return results
				return $results;
			}
			catch(PDOException $e)
			{
				// Return error
				return $e->getMessage();
			}
		}
	}
	
	// Count all rows in a table
	public function countTable($table = null)
	{
		// Check for table
		if(!empty($table) && $table !== null)
		{
			// Try getting rowCount
			try
			{
				// Prepare query
				$statement = $this->_connection->prepare('SELECT * FROM '.$table.'');

				// Execute statement
				$statement->execute();

				// Return count
				return $statement->rowCount();
			}
			catch(PDOException $e)
			{
				// Return error
				return $e->getMessage();
			}	
		}	
	}
	
	// Add item to the database
	public function insert($table = null, $values = array())
	{
		// Check for table and values
		if(!empty($table) && $table !== null && !empty($values) && $values != null && is_array($values))
		{
			// Try inserting
			try
			{
				// Get query formated values
				$query = $this->prepareQueryValues($values, 0);
				
				// Prepare statement
				$statement = $this->_connection->prepare('INSERT INTO '.$table.'('.$query->columns.') VALUES('.$query->identifiers.')');
				
				// Execute insert
				$statement->execute($query->execute);

				// Return row count
				return $statement->rowCount();
			}
			catch(PDOException $e)
			{
				// Return error
				return $e->getMessage();
			}
		}
	}

	// Get item by value
	public function getWhere($table = null, $values = array())
	{
		// Check for table and values
		if(!empty($table) && $table !== null && !empty($values) && $values != null && is_array($values))
		{
			// Try getting the data
			try
			{
				// Get query formated values
				$query = $this->prepareQueryValues($values, 1);
				
				// Prepare statement
				$statement = $this->_connection->prepare('SELECT * FROM '.$table.' WHERE '.$query->columns.' = '.$query->identifiers.'');

				// Execute insert
				$statement->execute(array($query->columns => $query->execute[':'.$query->columns]));

				// Set counter to 0
				$i = 0;

				// Get results als create object
				while($row = $statement->fetch(PDO::FETCH_OBJ))
				{
					// Add to main object
					$results[$i] = $row;

					// Increment counter
					$i++;
				}
				// Check if there are results
				if(empty($results))
				{
					// Set empty
					$results[0] = '';
				}
				
				// Return results
				return $results;
			}
			catch(PDOException $e)
			{
				// Return error
				return $e->getMessage();
			}
		}
	}
	
	// Check if an user exists
	public function checkExists($table = null, $values = array())
	{
		// Check for table and values
		if(!empty($table) && $table !== null && !empty($values) && $values != null && is_array($values))
		{
			// Try retrieving the value
			try
			{
				// Get query formated values
				$query = $this->prepareQueryValues($values, 1);
				
				// Prepare statement
				$statement = $this->_connection->prepare('SELECT * FROM '.$table.' WHERE '.$query->columns.' = '.$query->identifiers.'');

				// Execute insert
				$statement->execute(array($query->columns => $query->execute[':'.$query->columns]));

				// Return row count
				return $statement->rowCount();
			}
			catch(PDOException $e)
			{
				// Return error
				return $e->getMessage();
			}
		}
	}
	
	// Create array with the right syntax values for query
	public function prepareQueryValues($values = array(), $limit = 0)
	{
		if(!empty($values) && $values != null && is_array($values))
		{
			// Set variables
			$columns = '';
			$identifiers = '';
			$execute = array();
			
			// Remove all but first key from array
			if($limit != 0)
			{
				// Get the first item from the array
				//$values[] = $values;
			}					
			
			// Create table values and query values
			foreach($values as $field => $value)
			{
				// Check if the field is not empty
				if(!empty($field) && $field != null)
				{
					// Table values
					$columns .= $field.',';

					// Values
					$identifiers .= ':'.$field.',';

					// Execute values
					$execute[':'.$field] = $value;
				}
			}
			
			// Create object
			$query = new StdClass;
			
			// Set values
			$query->columns = rtrim($columns, ',');
			$query->identifiers = rtrim($identifiers, ',');
			$query->execute = $execute;
			
			// Return object
			return $query;
		}
	}
	
	// Close connection
	public function __destruct()
	{
		// Set back to null
		$this->_connection = null;
	}
}