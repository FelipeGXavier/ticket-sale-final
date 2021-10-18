<?php

namespace App\Model;

use Core\AbstractDAO;

class EmailTrackingModel extends AbstractDAO {

    public function saveTrackingLog($data) {
        $sql = "INSERT into tbemailtracking (status_code, headers, body, exception) VALUES (?, ?, ?, ?)";
        $this->raw($sql, $data);
    }

    public function getUsersReminders() {
        $sql = "select distinct t4.email, t4.name, t3.title from tbuserpurchase t1
            inner join tbticket t2 on t2.id = t1.ticket_id
            inner join tbshow t3 on t2.show_id = t3.id
            inner join tbuser t4 on t1.user_id = t4.id
            where DATE_SUB(t3.start_date , INTERVAL 1 DAY) = DATE(NOW());";
        return $this->raw($sql)->fetch();
    }

}