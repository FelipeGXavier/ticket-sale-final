<?php

namespace App\Controller;

use Core\Controller;
use Core\Session;
use Core\Validator;

class SearchController extends Controller
{

    private $searchModel;
    private $purchaseModel;

    public function __construct($request, $searchModel, $purchaseModel)
    {
        parent::__construct($request);
        $this->searchModel = $searchModel;
        $this->purchaseModel = $purchaseModel;
    }

    public function getSearch()
    {
        $shows = $this->searchModel->findShowsSearch();
        $this->view->render("shared/search", ['shows' => $shows]);
    }

    public function getDetail()
    {
        $id = Validator::sanitize($this->request->getParam("id"), 'int');
        $result = $this->searchModel->findShowDetails($id);
        $this->view->render("shared/detail_show", $result);
    }

    public function postCheckout()
    {
        header('Content-type: application/json');
        $data = json_decode($this->request->getAttribute("json"), true);
        $result = $this->searchModel->findCheckoutItems($data);
        echo json_encode(['tickets' => $result]);
        exit();
    }

    public function postPurchase()
    {
        header('Content-type: application/json');
        $data = json_decode($this->request->getAttribute("json"), true);
        $loggedUser = Session::get("user_id");
        $userType = Session::get("user_type");
        if(!$loggedUser || $loggedUser == 0 || $userType > 1) {
            $this->view->redirect('login');
        }
        $purchaseInfo = $this->searchModel->findCheckoutItems($data);
        $this->purchaseModel->createPurchase($loggedUser, $purchaseInfo);
    }


}