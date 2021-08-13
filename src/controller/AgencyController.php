<?php

namespace App\Controller;

use App\Model\UserModel;
use Core\Controller;
use Core\Session;
use Core\Validator;

class AgencyController extends Controller
{

    private $segmentModel;
    private $agencyModel;

    public function __construct($request, $segmentModel, $agencyModel)
    {
        parent::__construct($request);
        $this->segmentModel = $segmentModel;
        $this->agencyModel = $agencyModel;
    }

    public function getAgencyForm() {
        $segments = $this->segmentModel->findSegments();
        $this->view->render('logged/agency_form', ['segments' => $segments]);
    }

    public function postAgency() {
        $loggedUser = Session::get("user_id");
        if($loggedUser == null || Session::get("user_type") != UserModel::USER_TYPE_AGENT) {
            $this->view->redirect('login/login');
        }
        $input = [
            'cnpj' => [$this->request->getAttribute('cnpj'), 'string'],
            'fantasy_name' => [$this->request->getAttribute('fantasy_name'), 'string'],
            'phone' => [$this->request->getAttribute('phone'), 'string'],
            'professional_mail' => [$this->request->getAttribute('professional_mail'), 'string'],
        ];
        $schema = Validator::validate($input);
        if(!empty($schema['errors'])) {
            $this->view->render('login/agency_form', ['message' => 'Campos inválidos']);
        }
        $schema['result']['user_id'] = $loggedUser;
        $segments = $this->request->getAttribute('segment');
        $this->agencyModel->create($schema['result'], $segments);
        $this->view->redirect('agent-dashboard');
    }

}