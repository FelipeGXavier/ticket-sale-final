<?php

require('../vendor/autoload.php');

use App\Controller\SearchController;
use App\Datasource;
use App\Model\SearchModel;

$datasource = new Datasource();
$request = $request = new \Core\Request();
$request->setParams($_SERVER['QUERY_STRING'] ?? []);
$request->setAttributes($_POST);
$agencyController = new SearchController($request, new SearchModel($datasource));
$agencyController->postCheckout();