<?php

namespace App\Model;

use Core\AbstractDAO;

class AgencyModel extends AbstractDAO
{

    /**
     * @throws \Exception
     */
    public function create($agency, $segments) {
        $sqlAgency = "INSERT INTO tbshowagency (cnpj, fantasy_name, phone, professional_mail, user_id) values (?, ?, ?, ?, ?)";
        $sqlSegment = "INSERT INTO tbshowagencysegment (segment_id, showagency_id) VALUES (?, ? )";
        $sqlUpdateWelcome = "UPDATE tbuser SET welcome = true WHERE id = " . $agency ['user_id'];
        try{
            $this->startTransaction();
            $this->raw($sqlAgency, array_values($agency));
            $id = $this->getInsertId();
            foreach ($segments as $segment) {
                $insert[] = $segment;
                $insert[] = $id;
                $this->raw($sqlSegment, $insert);
            }
            $this->raw($sqlUpdateWelcome);
            $this->commit();
        }catch (\Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    public function createShow($show, $tickets) {
        $sqlShow = "INSERT into tbshow (cep, thumbnail, title, description, address, start_date, end_date, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $sqlTicket = "INSERT into tbticket (description, price, qtd_ticket, show_id)  VALUES (?, ?, ?, ?)";
        try{
            $this->startTransaction();
            $this->raw($sqlShow, array_values($show));
            $id = $this->getInsertId();
            foreach ($tickets as $ticket) {
                $insert = array_values($ticket);
                $insert[] = $id;
                $this->raw($sqlTicket, array_values($insert));
            }
            $this->commit();
            return true;
        }catch (\Exception $e) {
            $this->rollback();
            return false;
        }
    }

}