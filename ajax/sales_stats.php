<?php

require('../vendor/autoload.php');

use App\Datasource;
use App\Model\StatsModel;
use Core\Session;

$datasource = new Datasource();
$request = $request = new \Core\Request();
$request->setParams($_SERVER['QUERY_STRING'] ?? []);
$request->setAttributes($_POST);
$agencyModel = new StatsModel($datasource);
echo json_encode(['ticket_sales' => $agencyModel->findSaleStats(Session::get("user_id"))]);