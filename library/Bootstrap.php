<?php 
/*
 * bootstrap
 *
 * Set up the application and MVC
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

// Check session
if(session_id() === "")
{
    session_start();
}

// Autoload any classes that are required
spl_autoload_register(function($className)
{
	// Variables
    $rootPath = ROOT . DS;
    $valid = false;
   
    // Check root directory of library
    $valid = file_exists($classFile = $rootPath . 'library' . DS . $className . '.php');
    
    // If we cannot find any, then find library/core directory
    if(!$valid)
	{
        $valid = file_exists($classFile = $rootPath . 'library' . DS . 'chaosbydesign' . DS . $className . '.php');   	
    }

    // If we cannot find any, then find application/controllers directory
    if(!$valid)
	{
        $valid = file_exists($classFile = $rootPath . 'application' . DS . 'controllers' . DS . $className . '.php');
    } 
	
    // If we cannot find any, then find application/models directory
    if(!$valid)
	{
        $valid = file_exists($classFile = $rootPath . 'application' . DS . 'models' . DS . $className . '.php');
    }  

    // If we have valid fild, then include it
    if($valid)
	{
       require_once($classFile); 
    }
	else
	{
        /* Error Generation Code Here */
    }    
});

// Get config
$config = parse_ini_file(ROOT . DS . 'application' . DS . 'config' . DS . 'application.ini', true);

// Start application
Start::Application($config);

// Register route
$router = new Router($_route);

// Dispatch the output
$router->dispatch(array('search' => 'index'));

// Close session to speed up the concurrent connections http://php.net/manual/en/function.session-write-close.php
session_write_close();