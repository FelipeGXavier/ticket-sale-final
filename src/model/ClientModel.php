<?php

namespace App\Model;

use Core\AbstractDAO;

class ClientModel extends AbstractDAO
{

    public function findTicketHistory($userId)
    {
        $sql = " select t3.fantasy_name, t4.purchased_at, t5.description, t.id, title, start_date, end_date, address from tbshow t
                    inner join tbuser t2 on t2.id = t.user_id
                    inner join tbshowagency t3 on t3.user_id = t2.id
                    inner join tbuserpurchase t4 on t4.user_id = t2.id
                    inner join tbticket t5 on t5.id = t4.ticket_id
                    where t2.id = ?";
        return $this->raw($sql, [$userId])->fetch();
    }

}