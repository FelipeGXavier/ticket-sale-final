<?php

namespace Core;

class View
{

	public function render($template, $args = [])
	{
		if (!empty($args) && is_array($args)) {
			extract($args);
		}
		ob_start();
		require(ROOT_PATH . APP_DIRECTORY . '/public/' . $template . '.php');
		ob_end_flush();
		exit();
	}

	public function redirect($location) {
	    header("Location: $location");
	    exit();
    }
}
