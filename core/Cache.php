<?php

namespace Core;

use Predis\Client;

class Cache {

    private static $instance;

    public static function connection(): Client {
        if (self::$instance == null) {
            self::$instance = new Client();
        }
        return self::$instance;
    }
    

}