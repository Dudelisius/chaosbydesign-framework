<?php

/*
 * View
 *
 * Gets the layout file and view file based on the controller and action
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class View
{                      
	// Variables
	protected $_variables = array();
	protected $_controller;
	protected $_action;
    protected $_bodyContent;
    protected $_noLayout;

    public $viewPath;
    public $layout;
    
	// Construct
	public function __construct($controller, $action)
	{
		// Controller and action
		$this->_controller = $controller;
		$this->_action = $action;
		$this->_noLayout = false;
		
		// Call meta class because we use that in the template
		$this->meta = new Meta(parse_ini_file(ROOT . DS . 'application' . DS . 'config' . DS . 'application.ini', true)['website']);
		
		// Call messenger class because we use that in the template
		$this->messenger = new Messenger();
	}

	// Set variables
	public function __set($name, $value)
	{
		$this->_variables[$name] = $value;
	}
	
	// Get variables
	public function __get($name)
	{
		return $this->_variables[$name];
	}
    
    // Set action
    public function setAction($action)
	{
        $this->_action = $action;
    }
    
    // RenderContent
    public function renderContent()
	{
    	// If content; deliver
        if(!empty($this->_bodyContent))
		{
            return $this->_bodyContent;
        }
    }
	
	// Render
    public function render()
	{				
		// Set the layout
        $this->layout = ROOT . DS . 'application' . DS . 'layouts' . DS . 'layout.phtml';
		
		// Extract the variables for view pages
        extract($this->_variables);

        // Start buffering;
    	//ob_start('ob_gzhandler');
    	ob_start();

        // Render page content
        if(empty($this->viewPath))
		{ 
   			// Use the in controller and action set in controller
			$this->viewPath = ROOT . DS . 'application' . DS . 'views' . DS .$this->_controller . DS . $this->_action . '.phtml';
        }
		
		// Get view file
		require_once($this->viewPath);
		
        // Get the body contents
		$this->_bodyContent = $this->compressHtml(ob_get_contents());
		
		// Stop buffer
        ob_end_clean();
		
		// Check if the layout needs to be loaded
		if(!$this->_noLayout)
		{
			// Get the layout file
			require_once($this->layout);
		}
		else
		{
			// Return only the body content
			print_r($this->_bodyContent);
		}

       	// Clean the buffer
        ob_end_flush();
    }
	
	// Disable layout loading
	public function disableLayout()
	{
		// Set noLayout to true
		$this->_noLayout = true;
	}
	
	// Compress html
	public function compressHtml($buffer)
	{
		// Return compressed html
		return preg_replace('/(?:(?<=\>)|(?<=\/\>))(\s+)(?=\<\/?)/', '', $buffer);
	}
    
    // Return rendered html
    public function __toString()
	{
		$this->render();
        return '';
    }	
}   