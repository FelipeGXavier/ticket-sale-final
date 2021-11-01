<?php

require('vendor/autoload.php');

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

define('PATH', getcwd());
define('ROOT_PATH', dirname(__DIR__) . '/');
define('APP_DIRECTORY', 'ticket-sale-final');
define('LINE_SEPARATOR', '/');

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
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_CLIENT) {
            $searchController = new SearchController($request, new SearchModel($datasource), new PurchaseModel($datasource));
            $searchController->postCheckout();
        }
        $view->redirect("/");
    });

    $app->get("/checkout", function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_CLIENT) {
            $view->render("shared/checkout");
        }
        $view->redirect("/");
    });

    $app->get("/detail", function ($request) use ($datasource) {
        $agencyController = new SearchController($request, new SearchModel($datasource), new PurchaseModel($datasource));
        $agencyController->getDetail();
    });

    $app->get('/create-show', function ($request) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $view->render('logged/show_form');
        }
        $view->redirect("/");
    });

    $app->post('/create-show', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
            $agencyController->postShow();
        }
        $view->redirect("/");
    });

    $app->get('/ticket-history', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_CLIENT) {
            $clientController = new ClientController($request, new ClientModel($datasource));
            $clientController->getTicketHistory();
        }
        $view->redirect("/");
    });

    $app->get("/tracking", function ($request) use ($datasource) {
        $trackingModel = new StatsModel($datasource);
        $id = $request->getParam("id") != null ? $request->getParam("id") : 0;
        $trackingModel->tracking(Util::getIpRequest(), $id);
    });

    $app->get('/welcome', function ($request) {
        $view = new View();
        if (Session::get("user_type") !== null && Session::get("user_id") != null) {
            $view->render('logged/welcome', ['title' => "Bem Vindo!"]);
        }
        $view->redirect("/");
    });

    $app->get('/tracking-stats', function ($request) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $view->render('logged/stats_tracking');
        }
        $view->redirect("/");

    });

    $app->get('/sales-stats', function ($request) {
        $view = new View();
        if (Session::get("user_type") !== null && Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $view->render('logged/stats_sales');
        }
        $view->redirect("/");
    });

    $app->get('/export-csv', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null && Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
            $agencyController->getExportCsv();
        }
        $view->redirect("/");
    });

    $app->get('/stats', function ($request) {
        $view = new View();
        if (Session::get("user_type") !== null && Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $view->render('logged/stats_list');
        }
        $view->redirect("/");
    });

    $app->get('/show-list', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
            $agencyController->getShows();
        }
        $view->redirect("/");
    });

    $app->get('/show', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
            $agencyController->getShow();
        }
        $view->redirect("/");
    });

    $app->get('/ticket-show', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
            $agencyController->getTicketsShow();
        }
        $view->redirect("/");
    });

    $app->post('/update-ticket', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
            $agencyController->postUpdateTicket();
        }
        $view->redirect("/");
    });

    $app->post('/update-show', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null && Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
            $agencyController->postUpdateShow();
        }
        $view->redirect("/");
    });

    $app->get('/approve', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_ADMIN) {
            $adminModel = new AdminModel($datasource);
            $adminController = new AdminController($request, $adminModel);
            $adminController->getApproves();
        }
        $view->redirect("/");
    });

    $app->get('/approve-agent', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_ADMIN) {
            $adminModel = new AdminModel($datasource);
            $adminController = new AdminController($request, $adminModel);
            $adminController->getApprove();
        }
        $view->redirect("/");
    });

    $app->get('/revoke-agent', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_ADMIN) {
            $adminModel = new AdminModel($datasource);
            $adminController = new AdminController($request, $adminModel);
            $adminController->getRevoke();
        }
        $view->redirect("/");
    });

    $app->get('/create-agency', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
            $agencyController->getAgencyForm();
        }
        $view->redirect("/");
    });

    $app->post('/create-agency', function ($request) use ($datasource) {
        $view = new View();
        if (Session::get("user_type") !== null &&  Session::get("user_type") == UserModel::USER_TYPE_AGENT) {
            $agencyController = new AgencyController($request, new SegmentModel($datasource), new AgencyModel($datasource));
            $agencyController->postAgency();
        }
        $view->redirect("/");
    });

    $app->get('/create-login', function ($request) {
        $view = new View();
        $view->render('login/create_login');
    });

    $app->get('/login', function ($request) {
        $view = new View();
        if (!Session::get("user_type")) {
            $view->render('login/login');
        }
        $view->redirect('/');
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
