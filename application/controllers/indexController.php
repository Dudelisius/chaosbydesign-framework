<?php
class indexController extends Controller
{    
	public function index()
	{
		// Set template variables
		$this->view->title = 'Index';
		$this->view->description = 'Index';
		
		// Return the view
		return $this->view();	
	}
}