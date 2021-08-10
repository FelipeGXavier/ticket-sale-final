<?php

namespace Core;

use Core\View;

class Controller
{

	protected $request;
	protected $view;

	public function __construct($request)
	{
		$this->request = $request;
		$this->view = new View();
	}
}
