<?php
/*
 * Index
 *
 * This is where all requests are routed to
 *
 * @category	Chaosbydesign Framework
 * @package		Chaosbydesign Framework
 * @author		Rick de Graaf
 * @copyright	Copyright (c) 2016 Rick de GRaaf
 * @version		1.0
*/

// Define the directory separator
define('DS', DIRECTORY_SEPARATOR);

// Define the application path
define('ROOT', dirname(dirname(__FILE__)));

// The routing url, we need to use original 'QUERY_STRING' from server paramater because php has parsed the url if we use $_GET
$_route = isset($_GET['_route']) ? preg_replace('/^_route=(.*)/','$1',$_SERVER['QUERY_STRING']) : '';

// Start to dispatch
require_once (ROOT . DS . 'library' . DS . 'Bootstrap.php');