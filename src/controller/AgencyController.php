<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Util\FileUploader;
use Core\Controller;
use Core\Session;
use Core\Validator;

class AgencyController extends Controller
{

    use FileUploader;

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
        $this->redirectUnauthorized();
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
        $this->view->redirect('welcome');
    }

    public function postShow() {
        //$this->redirectUnauthorized();
        $data = json_decode($this->request->getAttribute("json"), true);
        $file = $_FILES['thumbnail'];
        $path = $this->upload($file['tmp_name'], pathinfo($file['name'], PATHINFO_EXTENSION));
        $inputShow = [
            'cep' => [$data['cep'], 'string'],
            'thumbnail' => [$path, 'string'],
            'title' => [$data['title'], 'string'],
            'description' => [$data['description'], 'string'],
            'address' => [$data['address'], 'string'],
            'start_date' => [$data['start_date'], 'string'],
            'end_date' => [$data['end_date'], 'string'],
        ];
        $schemaShow = Validator::validate($inputShow);
        $schemaShow['result']['user_id'] = Session::get("user_id");
        $tickets = $data['tickets'];
        $success = $this->agencyModel->createShow($schemaShow['result'], $tickets);
        if(!$success) {
            http_response_code(400);
        }
    }

    public function getShows() {

    }

    public function getDisableShow() {

    }

    public function postUpdateShow() {

    }

    private function redirectUnauthorized() {
        $loggedUser = Session::get("user_id");
        if($loggedUser == null || Session::get("user_type") != UserModel::USER_TYPE_AGENT) {
            $this->view->redirect('login/login');
        }
    }

}