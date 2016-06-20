<?php

/*
 * Controller
 *
 * This will set up the controller part of the MVC
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class Controller
{
    // Variables
	protected $_model;
    protected $_controller;
    protected $_action;
    
    public $view;
    public $table;
    public $id;
    public $db;
    public $userValidation;
    
	// Construct
    public function __construct($model = 'Model', $controller = 'Controller', $action = 'index')
	{
		// Construct MVC
        $this->_controller = $controller;
        $this->_action = $action;

		// Init view class
        $this->view = new View($controller, $this->_action);   

		// Construct Models
        $this->_model = new $model($this->db);
        $this->_model->controller = $this;
        $this->table = $controller;
    }

	// Default action for handling
    public function defAction($params = null)
	{
		// Set viewpath
		$this->view->viewPath =  ROOT . DS . 'application' . DS . 'views' . DS . $this->_controller . DS . $this->_action . '.phtml';;

		// Check for parameters
		if(!empty($params) && is_array($params))
		{
			// Assign local variables
			foreach($params as $key => $value)
			{
				$this->view->set($key, $value);   
			}
		}

		// Return view
		return $this->view();
    }

    // Set variables
    public function set($name, $value)
	{
    	// Set the paramaters to the template class
        $this->view->set($name, $value);
    }

    // Return the view
    public function view()
	{
		// Dispatch the result of the template class
        return $this->view;
    }
}
