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

    public function getAgencyForm()
    {
        $segments = $this->segmentModel->findSegments();
        $this->view->render('logged/agency_form', ['segments' => $segments]);
    }

    public function postAgency()
    {
        $loggedUser = Session::get("user_id");
        $this->redirectUnauthorized();
        $input = [
            'cnpj' => [$this->request->getAttribute('cnpj'), 'string'],
            'fantasy_name' => [$this->request->getAttribute('fantasy_name'), 'string'],
            'phone' => [$this->request->getAttribute('phone'), 'string'],
            'professional_mail' => [$this->request->getAttribute('professional_mail'), 'string'],
            'uf' => [$this->request->getAttribute('uf'), 'string'],
        ];
        $schema = Validator::validate($input);
        if (!empty($schema['errors'])) {
            $this->view->render('login/agency_form', ['message' => 'Campos inválidos']);
        }
        $schema['result']['user_id'] = $loggedUser;
        $segments = $this->request->getAttribute('segment');
        $this->agencyModel->create($schema['result'], $segments);
        $this->view->redirect('welcome');
    }

    public function postShow()
    {
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
        if (empty($data['title']) || empty($data['description']) || strtotime($data['end_date'] < strtotime($data['start_date']))) {
            http_response_code(400);
            exit();
        }
        $schemaShow = Validator::validate($inputShow);
        $schemaShow['result']['user_id'] = Session::get("user_id");
        $tickets = $data['tickets'];
        $success = $this->agencyModel->createShow($schemaShow['result'], $tickets);
        if (!$success) {
            http_response_code(400);
        }
    }

    public function getShows()
    {
        $loggedUser = Session::get("user_id");
        $shows = $this->agencyModel->findShows($loggedUser);
        $this->view->render("logged/show_list", ['shows' => $shows]);
    }


    public function getShow()
    {
        $loggedUser = Session::get("user_id");
        $showId = $this->request->getParam("id");
        $show = $this->agencyModel->findShow($showId, $loggedUser);
        $this->view->render("logged/show_edit", $show[0]);
    }

    public function postUpdateShow()
    {
        $loggedUser = Session::get("user_id");
        $showId = $this->request->getParam("id");
        $input = [
            'title' => [$this->request->getAttribute('title'), 'string'],
            'description' => [$this->request->getAttribute('description'), 'string'],
            'cep' => [$this->request->getAttribute('cep'), 'string'],
            'address' => [$this->request->getAttribute('address'), 'string'],
            'start_date' => [$this->request->getAttribute('start_date'), 'string'],
            'end_date' => [$this->request->getAttribute('end_date'), 'string'],
        ];
        $schema = Validator::validate($input);
        $this->agencyModel->updateShow($loggedUser, $showId, $schema['result']);
        $this->view->redirect('show-list');
    }

    public function getTicketsShow()
    {
        $loggedUser = Session::get("user_id");
        $showId = $this->request->getParam("id");
        $tickets = $this->agencyModel->findTickets($loggedUser, $showId);
        $this->view->render("logged/ticket_edit", ['tickets' => $tickets]);
    }

    public function postUpdateTicket()
    {
        $loggedUser = Session::get("user_id");
        $showId = $this->request->getParam("show");
        $ticketId = $this->request->getParam("id");;
        $input = [
            'description' => [$this->request->getAttribute('desc_ticket'), 'string'],
            'price' => [$this->request->getAttribute('price_ticket'), 'int'],
            'qtd_ticket' => [$this->request->getAttribute('qtd_ticket'), 'int'],
            'active' => [$this->request->getAttribute('active'), 'bool'],
        ];
        $schema = Validator::validate($input);
        if (!empty($schema['errors'])) {
            //$this->view->render('login/agency_form', ['message' => 'Campos inválidos']);
        }
        $this->agencyModel->updateTicket($loggedUser, $showId, $ticketId, $schema['result']);
        $this->view->redirect('show-list');
    }

    public function getExportCsv()
    {
        $loggedUser = Session::get("user_id");
        $shows = $this->agencyModel->findAllShows($loggedUser);
        array_unshift($shows, ['cep', 'address', 'title', 'description', 'start_date', 'end_date', 'price', 'qtd_ticket']);
        $this->getCsv(array_values($shows));
    }

    private function redirectUnauthorized()
    {
        $loggedUser = Session::get("user_id");
        if ($loggedUser == null || Session::get("user_type") != UserModel::USER_TYPE_AGENT) {
            $this->view->redirect('login/login');
        }
    }

    private function getCsv($data)
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header("Content-Disposition: attachment; filename=shows.csv");
        $handle = fopen('php://output', 'r+');
        ob_clean();
        foreach ($data as $line) {
            @fputcsv($handle, $this->replaceCommas($line), ",", '"');
        }
        fclose($handle);
        ob_end_flush();
        die();
    }

    private function replaceCommas($line)
    {
        $result = [];
        foreach ($line as $key => $value) {
            $result[$key] = str_replace(',', " | ", $value);
        }
        return $result;
    }

    private function upload($path, $ext)
    {
        $randomName = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 10);;
        $uploadPath = PATH . "\bin\\" . $randomName . '.' . $ext;
        move_uploaded_file($path, $uploadPath);
        return $randomName . '.' . $ext;
    }

}