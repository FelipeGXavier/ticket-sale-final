<?php

namespace App;

use Core\DatasourceConnection;

class Datasource implements DatasourceConnection{

    public function getConnection()
    {
        $pdo = new \PDO('mysql:host=127.0.0.1;dbname=demo', 'user', 'e%ptB&l*s4twciM6gWilM');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }
}