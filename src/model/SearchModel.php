<?php

namespace App\Model;

use App\Util\Util;
use Core\AbstractDAO;

class SearchModel extends AbstractDAO
{

    public function findShowsSearch($params)
    {
        $sql = "select id, thumbnail, title, start_date, end_date, address from tbshow t1 WHERE 1 = 1 AND t1.user_id in (select id from tbuser where accept = true)";
        $key = null;
        $uf = null;
        if (isset($params['uf']) && !empty($params['uf'])) {
            $uf = $params['uf'];
            $sql = "select t1.id, thumbnail, title, start_date, end_date, address from tbshow t1
                        inner join tbuser t2 on t2.id = t1.user_id
                        inner join tbshowagency t3 on t3.user_id = t2.id
                        WHERE 1 = 1 and uf = ? AND t1.user_id in (select id from tbuser where accept = true)";
        }
        if (isset($params['keyword'])) {
            $key = $params['keyword'];
            $sql .= " and lower(title) like CONCAT(?, '%')";
        }
        
        if($uf != null && $key != null) {
            return $this->raw($sql, [$uf, $key])->fetch();
        }
        if($uf != null && $key == null) {
            return $this->raw($sql, [$uf])->fetch();
        }
        if($uf == null && $key != null) {
            return $this->raw($sql, [$key])->fetch();
        }
        return $this->raw($sql)->fetch();
    }

    public function findShowDetails($id)
    {
        $sqlShow = "select t3.fantasy_name, t.id, t.description, title, start_date, end_date, address from tbshow t
                    inner join tbuser t2 on t2.id = t.user_id
                    inner join tbshowagency t3 on t3.user_id = t2.id
                    where t.id = ?;";
        $sqlTickets = "select id, price, qtd_ticket, description from tbticket where active = true and show_id = ?";
        $show = $this->raw($sqlShow, [$id])->fetch();
        $tickets = $this->raw($sqlTickets, [$id])->fetch();
        return ['show' => $show, 'tickets' => $tickets];
    }

    public function findCheckoutItems($checkout)
    {
        $showIds = $checkout['showIds'];
        $ticketIds = $checkout['ticketIds'];
        $qMarksEvent = str_repeat('?,', count($showIds) - 1) . '?';
        $qMarkTicket = str_repeat('?,', count($ticketIds) - 1) . '?';
        $sql = "select t4.id as ticket_id, t4.price, t4.description, t3.fantasy_name, t.id as show_id, title from tbshow t
                    inner join tbuser t2 on t2.id = t.user_id
                    inner join tbshowagency t3 on t3.user_id = t2.id
                    inner join tbticket t4 on t4.show_id = t.id
                    where t4.id in ($qMarkTicket) and t.id in ($qMarksEvent);";
        return $this->raw($sql, Util::flat([$ticketIds, $showIds]))->fetch();
    }


}