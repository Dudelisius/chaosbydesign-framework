<?php
class errorController extends Controller
{    
	public function index()
	{
		// Set template variables
		$this->view->title = 'Error';
		$this->view->description = 'Error';
		
		// Return the view
		return $this->view();	
	}
}