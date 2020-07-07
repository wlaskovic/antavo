<?php
// require_once 'View.php';

class Controller extends View{
    public function __construct()
	{
		$this->view = new View();
	}
}