<?php

namespace App\Controller;

use Core\Controller;
use Core\Validator;

class SearchController extends Controller
{

    private $searchModel;

    public function __construct($request, $searchModel)
    {
        parent::__construct($request);
        $this->searchModel = $searchModel;
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


}