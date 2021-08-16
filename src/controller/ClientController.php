<?php

namespace App\Controller;

use Core\Controller;
use Core\Session;

class ClientController extends Controller
{

    private $clientModel;

    public function __construct($request, $clientModel)
    {
        parent::__construct($request);
        $this->clientModel = $clientModel;
    }

    public function getTicketHistory()
    {
        $loggedUser = Session::get("user_id");
        $tickets = $this->clientModel->findTicketHistory($loggedUser);
        $this->view->render("logged/ticket_history", ['tickets' => $tickets]);
    }


}