<?php

/*
 * Router
 *
 * This will set parse the url
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class Router
{
    // Variables
	protected $_controller;
    protected $_action;
    protected $_view;
    protected $_params;
    protected $_route;
    
	// Construct
    public function __construct($_route)
	{
        $this->_route = $_route;
        $this->_controller = 'Controller';
        $this->_action = 'index';
        $this->_params = array(); 
        $this->_view = false;
    }

	// Dispatch
    public function dispatch($forcedAction = null)
	{		
		// Set false id
		$id = false;
        
		// Parse path info
        if(isset($this->_route))
		{
            // Replace stripes in url
			$this->_route = str_replace(array('-'), array(''), $this->_route);
			
			// Preg rules
            $cai = '/^([\w]+)\/([\w]+)\/([\d]+).*$/';
            $ci = '/^([\w]+)\/([\d]+).*$/';
            $ca = '/^([\w]+)\/([\w]+).*$/'; 
            $a = '/^([\w]+).*$/';
            $i = '/^([\d]+).*$/';
			
            // Matches
            $matches = array();
			
            // Homepage
            if(empty($this->_route))
			{
                $this->_controller = 'index';
				$this->_action = 'index';
            }
			// Controller/Action/Id
			elseif(preg_match($cai, $this->_route, $matches))
			{
                $this->_controller = $matches[1];
				$this->_action = $matches[2];
                $id = $matches[3];
            }
			// Controller/Id
			elseif(preg_match($ci, $this->_route, $matches))
			{
                $this->_controller = $matches[1];
                $id = $matches[2];
            }
			// Controller/Action
			else if(preg_match($ca, $this->_route, $matches))
			{
                $this->_controller = $matches[1];
				$this->_action = $matches[2];
            }
			// Action
			elseif(preg_match($a, $this->_route, $matches))
			{
            	$this->_controller = $matches[1];
                $this->_action = 'index';				
            }
			// Id
			elseif(preg_match($i, $this->_route, $matches))
			{
                $id = $matches[1];
            }
        }

        // We need to remove _route in the $_GET params
		unset($_GET['_route']);
		
		// Merge the params
		$this->_params = array_merge($this->_params, $_GET);      
		
		
		// Set param id to the id we have
		if(!empty($id))
		{		 
			 $this->_params['id'] = $id;
		}

        if($this->_controller == 'index')
		{
            $this->_params = array($this->_params);
        }  	
		
        // Set controller name
        
		$controllerName = $this->_controller;
        
		// Set model name
        $model = $this->_controller.'Model';
        
		// If we have extended model
        $model = class_exists($model) ? $model : 'Model';
        
		// Assign controller full name
        $this->_controller .= 'Controller';
		
        // Check if controller exists
		$controllerName = class_exists($this->_controller) ? $controllerName : 'error';
		
		// Set the controller
        $this->_controller = class_exists($this->_controller) ? $this->_controller : 'errorController';
		
		// Set the action
		// This makes action always point to a set action if set in Bootstrap
		if(!empty($forcedAction) && $forcedAction != null && is_array($forcedAction) && isset($forcedAction[$controllerName]))
		{
			// Set action to fixed value
			$this->action = $forcedAction[$controllerName];
			
			// Add normal called action to the parameters
			$this->_params = array_merge(array('_action' => $this->_action), $this->_params);
		}

		// Check if the action exists
		$this->action = ((int)method_exists($this->_controller, $this->_action)) ? $this->_action : 'index';	
		
        // Construct the controller class
        $dispatch = new $this->_controller($model, $controllerName, $this->action);

        // If we have action function in controller
        $hasActionFunction = (int)method_exists($this->_controller, $this->action);
		$action = $hasActionFunction ? $this->action : 'defAction';

        // Call the action method
        $this->_view = call_user_func_array(array($dispatch, $action), $this->_params);		

		// Print to the view
        if($this->_view)
		{
        	echo $this->_view;
        }
    }
}