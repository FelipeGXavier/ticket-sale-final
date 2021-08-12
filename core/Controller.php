<?php

namespace Core;

use Core\View;

class Controller
{

    /**
     * @var Request
    */
	protected $request;
	protected $view;

	public function __construct($request)
	{
		$this->request = $request;
		$this->view = new View();
	}
}
