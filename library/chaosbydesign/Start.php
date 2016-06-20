<?php

/*
 * Boostrap
 *
 * This will set up the complete application and MVC structure
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

class Start
{
	// Variables
	protected $config;
	
	public static function Application($config)
	{
		// Set the locale language
		setlocale(LC_ALL, $config['application']['locale']);
		
		// Set the character encoding
		mb_internal_encoding($config['website']['encoding']);
		
		// Unregister globals
		if(ini_get('register_globals'))
        {
            $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
            
            foreach($array as $value)
            {
                foreach($GLOBALS[$value] as $key => $var)
                {
                    if($var === $GLOBALS[$key])
                    {
                        unset($GLOBALS[$key]);
                    }
                }
            }
        }
		
		// Remove magic qoutes
		if(get_magic_quotes_gpc())
		{
			$_GET = stripSlashesDeep($_GET);
			$_POST = stripSlashesDeep($_POST);
			$_COOKIE = stripSlashesDeep($_COOKIE);
		}
		
		// Set the error reporting based on the environment
		if($config['application']['environment'] == 'development')
		{
			error_reporting(E_ALL);
			ini_set('display_errors', 'On');
		}
		else
		{
			error_reporting(E_ALL);
			ini_set('display_errors','Off');
			ini_set('log_errors', 'On');
			ini_set('error_log', ROOT . DS . 'application' . DS . 'logs' . DS . 'error.log');
		}	
	}
	
	// Strip slashes
	protected static function stripSlashesDeep($value)
	{
        $value = is_array($value) ? array_map(self::stripSlashesDeep, $value) : stripslashes($value);
        return $value;
    }
}