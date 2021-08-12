<?php

namespace Core;

class Session
{

    public static function set($name, $value)
    {
        self::check();
        $_SESSION[$name] = $value;
    }

    public static function get($name)
    {
        self::check();
        return $_SESSION[$name] ?? null;
    }

    public static function flush($name = '')
    {
        self::check();
        unset($_SESSION[$name]);
    }

    public static function destroy()
    {
        session_destroy();
    }

    private static function check()
    {
        if (session_id() == '') session_start();
    }

}
