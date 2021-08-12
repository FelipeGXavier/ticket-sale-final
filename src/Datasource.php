<?php

namespace App;

use Core\DatasourceConnection;

class Datasource implements DatasourceConnection{

    public function getConnection()
    {
        $pdo = new \PDO('mysql:host=localhost;dbname=demo', 'root', '');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        return $pdo;
    }
}