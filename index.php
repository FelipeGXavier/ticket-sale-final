<?php

require('vendor/autoload.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

define('PATH', getcwd());
define('ROOT_PATH', dirname(__DIR__) . '/');
define('APP_DIRECTORY', 'ticket-sale-final');

use App\Controller\AgencyController;
use App\Controller\AuthController;
use App\Datasource;
use App\Model\AgencyModel;
use App\Model\SegmentModel;
use App\Model\UserModel;
use Core\App;
use Core\View;

session_start();

$fullPath = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (!strrpos($fullPath, 'public')) {

    $datasource = new Datasource();
    $app = new App();

    $app->get('/', function ($request) {
        $view = new View();
        $view->render('logged/approve');
    });

    $app->get('/agent-dashboard', function ($request) {
        $view = new View();
        $view->render('logged/agent_dashboard', ['title' => "Bem Vindo!"]);
    });

    $app->get('/create-agency', function ($request) use($datasource) {
        $segmentController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
        $segmentController->getAgencyForm();
    });

    $app->post('/create-agency', function ($request) use($datasource) {
        $segmentController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
        $segmentController->postAgency();
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

    $app->get('/logout', function ($request) use ($datasource) {
        session_destroy();
        $view = new View();
        $view->redirect('login');
    });

    $app->dispatch();
}
