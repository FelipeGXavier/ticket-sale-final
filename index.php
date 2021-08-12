<?php

require('vendor/autoload.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);


define('ROOT_PATH', dirname(__DIR__) . '/');
define('APP_DIRECTORY', 'ticket-sale-final');

use App\Controller\AuthController;
use App\Datasource;
use App\Model\UserModel;
use Core\App;
use Core\View;

$fullPath = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (!strrpos($fullPath, 'public')) {

    $datasource = new Datasource();
    $app = new App();

    $app->get('/', function ($request) {
        echo "App";
    });

    $app->get('/create-login', function ($request) {
        $view = new View();
        $view->render('login/create_login');
    });

    $app->get('/login', function ($request) {
        $view = new View();
        $view->render('login/login');
    });

    $app->post('/create-login', function ($request) use ($datasource) {
        $userModel = new UserModel($datasource);
        (new AuthController($request, $userModel))->postUser();
    });

    $app->post('/login', function ($request) use ($datasource) {
        $userModel = new UserModel($datasource);
        (new AuthController($request, $userModel))->postLogin();
    });

    $app->dispatch();
}
