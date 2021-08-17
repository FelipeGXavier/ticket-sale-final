<?php

namespace App\Model;

use App\Util\Util;
use Core\AbstractDAO;

class AgencyModel extends AbstractDAO
{

    /**
     * @throws \Exception
     */
    public function create($agency, $segments)
    {
        $sqlAgency = "INSERT INTO tbshowagency (cnpj, fantasy_name, phone, professional_mail, uf, user_id) values (?, ?, ?, ?, ?, ?)";
        $sqlSegment = "INSERT INTO tbshowagencysegment (segment_id, showagency_id) VALUES (?, ? )";
        $sqlUpdateWelcome = "UPDATE tbuser SET welcome = true WHERE id = " . $agency ['user_id'];
        try {
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
        } catch (\Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

    public function createShow($show, $tickets)
    {
        $sqlShow = "INSERT into tbshow (cep, thumbnail, title, description, address, start_date, end_date, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $sqlTicket = "INSERT into tbticket (description, price, qtd_ticket, show_id)  VALUES (?, ?, ?, ?)";
        try {
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
        } catch (\Exception $e) {
            $this->rollback();
            return false;
        }
    }

    public function findShows($userId)
    {
        $sql = "select t.title, t.id, t.start_date, t.end_date, t.address from tbshow t
                    inner join tbuser t2 on t2.id = t.user_id
                where t2.id = ?";
        return $this->raw($sql, [$userId])->fetch();
    }

    public function findShow($showId, $userId)
    {
        $sql = "select t.* from tbshow t
                    inner join tbuser t2 on t2.id = t.user_id
                where t2.id = ? and t.id = ?";
        return $this->raw($sql, [$userId, $showId])->fetch();
    }

    public function updateShow($userId, $showId, $data)
    {
        $sqlShowUser = "SELECT t1.id from tbshow t1
                            inner join tbuser t2 on t2.id = t1.user_id
                        where t2.id = ?";

        $sqlUpdateShow = "UPDATE tbshow SET title = ?, description = ?, cep = ?, address = ?, start_date = ?, end_date = ? where id = ? and user_id = ?";
        $this->raw($sqlUpdateShow, Util::flat([$data, $showId, $userId]));
    }

    public function findAllShows($userId)
    {
        $sql = "select t1.cep, t1.address, t1.title, t1.description, t1.start_date, t1.end_date, t2.description as ticket, t2.price, t2.qtd_ticket from tbshow t1
                    inner join tbticket t2 on t1.id = t2.show_id
                    inner join tbuser t3 on t1.user_id = t3.id
                where t3.id = ?;";
        return $this->raw($sql, [$userId])->fetch();
    }

    public function findTickets($userId, $showId)
    {
        $sql = "SELECT * from tbticket where show_id = ?";
        return $this->raw($sql, [$showId])->fetch();
    }

    public function updateTicket($loggedUser, $showId, $ticketId, $data)
    {
        $sql = "UPDATE tbticket SET description = ?, price = ?, qtd_ticket = ?, active = ? where id = ? and show_id = ?";
        return $this->raw($sql, Util::flat([$data, $ticketId, $showId]));
    }

}