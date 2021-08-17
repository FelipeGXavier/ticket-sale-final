<?php

namespace Core;

class Request
{

	private $params = [];
	private $attributes = [];

	public function setParams($params)
	{
		if (!empty($params)) {
			parse_str($params, $this->params);
		}
	}

	public function setAttributes($attributes)
	{
		$this->attributes = $attributes;
	}

	public function getParam($name)
	{
		return $this->params[$name] ?? null;
	}

	public function getAttribute($name)
	{
		return $this->attributes[$name];
	}
}
