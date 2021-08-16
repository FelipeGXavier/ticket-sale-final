<?php

require('vendor/autoload.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

define('PATH', getcwd());
define('ROOT_PATH', dirname(__DIR__) . '/');
define('APP_DIRECTORY', 'ticket-sale-final');

use App\Controller\AdminController;
use App\Controller\AgencyController;
use App\Controller\AuthController;
use App\Controller\ClientController;
use App\Controller\SearchController;
use App\Datasource;
use App\Model\AdminModel;
use App\Model\AgencyModel;
use App\Model\ClientModel;
use App\Model\PurchaseModel;
use App\Model\SearchModel;
use App\Model\SegmentModel;
use App\Model\StatsModel;
use App\Model\UserModel;
use App\Util\Util;
use Core\App;
use Core\Session;
use Core\View;

session_start();

$fullPath = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (!strrpos($fullPath, 'public')) {

    $datasource = new Datasource();
    $app = new App();

    $app->get("/", function ($request) use ($datasource) {
        $agencyController = new SearchController($request, new SearchModel($datasource), new PurchaseModel($datasource));
        $agencyController->getSearch();
    });

    $app->post("/checkout", function ($request) use ($datasource) {
        $agencyController = new SearchController($request, new SearchModel($datasource), new PurchaseModel($datasource));
        $agencyController->postCheckout();
    });

    $app->get("/checkout", function ($request) use ($datasource) {
        $view = new View();
        $view->render("shared/checkout");
    });

    $app->get("/detail", function ($request) use ($datasource) {
        $agencyController = new SearchController($request, new SearchModel($datasource), new PurchaseModel($datasource));
        $agencyController->getDetail();
    });

    $app->get('/create-show', function ($request) {
        $view = new View();
        $view->render('logged/show_form');
    });

    $app->post('/create-show', function ($request) use ($datasource) {
        $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
        $agencyController->postShow();
    });

    $app->get('/ticket-history', function ($request) use ($datasource) {
        $clientController = new ClientController($request, new ClientModel($datasource));
        $clientController->getTicketHistory();
    });

    $app->get("/tracking", function ($request) use ($datasource) {
        $trackingModel = new StatsModel($datasource);
        $id = $request->getParam("id") != null ? $request->getParam("id") : 0;
        $trackingModel->tracking(Util::getIpRequest(), $id);
    });

    $app->get('/welcome', function ($request) {
        $view = new View();
        $view->render('logged/welcome', ['title' => "Bem Vindo!"]);
    });

    $app->get('/tracking-stats', function ($request) {
        $view = new View();
        $view->render('logged/stats_tracking');
    });

    $app->get('/stats', function ($request) {
        $view = new View();
        $view->render('logged/stats_list');
    });


    $app->get('/approve', function ($request) use ($datasource) {
        $adminModel = new AdminModel($datasource);
        $adminController = new AdminController($request, $adminModel);
        $adminController->getApproves();
    });

    $app->get('/approve-agent', function ($request) use ($datasource) {
        $adminModel = new AdminModel($datasource);
        $adminController = new AdminController($request, $adminModel);
        $adminController->getApprove();
    });

    $app->get('/create-agency', function ($request) use ($datasource) {
        $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
        $agencyController->getAgencyForm();
    });

    $app->post('/create-agency', function ($request) use ($datasource) {
        $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
        $agencyController->postAgency();
    });

    $app->get('/create-login', function ($request) {
        $view = new View();
        $view->render('login/create_login');
    });

    $app->get('/login', function ($request) {
        if (!Session::get("user_type")) {
            $view = new View();
            $view->render('login/login');
        }
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
