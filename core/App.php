<?php

namespace Core;

class App
{

    private $registeredRoutes = [];

    public function get($path, $callback)
    {
        $this->registeredRoutes[$path]['GET'] = $callback;
    }

    public function post($path, $callback)
    {
        $this->registeredRoutes[$path]['POST'] = $callback;
    }

    public function dispatch()
    {
        $path = $_SERVER['REQUEST_URI'];
        $path = strpos($path, '?') ? (substr($path, 0, strpos($path, '?'))) : $path;
        $action = $_SERVER['REQUEST_METHOD'];
        if (isset($this->registeredRoutes[$path]) && isset($this->registeredRoutes[$path][$action])) {
            $request = new \Core\Request();
            $request->setParams($_SERVER['QUERY_STRING'] ?? []);
            $request->setAttributes($_POST);
            $this->registeredRoutes[$path][$action]($request);
        } else {
            $fullPath = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            if (strrpos($path, 'public')) {
                return file_get_contents($fullPath);
            }
            die('Not found');
        }
    }
}
