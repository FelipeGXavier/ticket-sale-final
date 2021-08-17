<?php

namespace App\Model;

use Core\AbstractDAO;

class ClientModel extends AbstractDAO
{

    public function findTicketHistory($userId)
    {
        $sql = " select fantasy_name, purchased_at, t1.price_purchased, t2.description, title, start_date, end_date, address from tbuserpurchase t1 
                  inner join tbticket t2 on t2.id = t1.ticket_id
                  inner join tbshow t3 on t3.id = t2.show_id
                  inner join tbuser t4 on t3.user_id = t4.id
                  inner join tbshowagency t5 on t5.user_id = t4.id
                  where t1.user_id = ?";
        return $this->raw($sql, [$userId])->fetch();
    }

}