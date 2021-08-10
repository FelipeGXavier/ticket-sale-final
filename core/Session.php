<?php

namespace Core;

class Session
{

	public function __construct()
	{
		$this->check();
	}

	public function set($name, $value)
	{
		$_SESSION[$name] = $value;
	}

	public function retrieve($name)
	{
		return $_SESSION[$name] ?? null;
	}

	public function flush($name = '')
	{
		unset($_SESSION[$name]);
	}

	public function destroy()
	{
		session_destroy();
	}

	private function check()
	{
		if (!isset($_SESSION)) {
			session_start();
		}
	}
}
