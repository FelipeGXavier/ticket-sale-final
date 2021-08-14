<?php

namespace App\Model;

use Core\AbstractDAO;

class AdminModel extends AbstractDAO
{

    public function findPendingApproves() {
        $sql = "select cnpj, fantasy_name, email, user_id from tbshowagency t
                    inner join tbuser t2 on t.user_id = t2.id
                    WHERE t2.accept = false;";
        $pending = $this->raw($sql);
        return $pending->fetch();
    }

    public function approve($id) {
        $sql = "UPDATE tbuser SET accept = true where id = ?";
        $this->raw($sql, [$id]);
    }

}