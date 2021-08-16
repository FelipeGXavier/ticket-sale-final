<?php

require('../vendor/autoload.php');

use App\Datasource;
use App\Model\StatsModel;

$datasource = new Datasource();
$request = $request = new \Core\Request();
$request->setParams($_SERVER['QUERY_STRING'] ?? []);
$request->setAttributes($_POST);
$agencyController = new StatsModel($datasource);
echo json_encode($agencyController->findTrackingStats());