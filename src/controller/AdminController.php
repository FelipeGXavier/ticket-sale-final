<?php

namespace App\Controller;

use Core\Controller;
use Core\Validator;

class AdminController extends Controller
{
    private $adminModel;

    public function __construct($request, $adminModel)
    {
        parent::__construct($request);
        $this->adminModel = $adminModel;
    }

    public function getApproves() {
        $pending = $this->adminModel->findPendingApproves();
        $this->view->render('logged/approve', ['pendings' => $pending]);
    }

    public function getRevoke() {
        $id = Validator::sanitize($this->request->getParam("id"), 'int');
        if($id && $id > 0) {
            $this->adminModel->revoke($id);
        }
        $this->view->redirect('approve');
    }

    public function getApprove() {
        $id = Validator::sanitize($this->request->getParam("id"), 'int');
        if($id && $id > 0) {
            $this->adminModel->approve($id);
        }
        $this->view->redirect('approve');
    }

}