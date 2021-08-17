<?php

namespace App\Model;

use App\Util\Util;
use Core\AbstractDAO;

class StatsModel extends AbstractDAO
{

    public function tracking($ip, $show)
    {
        $sql = "INSERT into tbclicktracking (ip, show_id) VALUES (?, ?)";
        $this->raw($sql, Util::flat([$ip, $show]));
    }

    public function findTrackingStats($userId)
    {
        $sqlClickPerDay = "select created_at, count(created_at) as value from tbclicktracking t1
                            inner join tbshow t2 on t2.id = t1.show_id
                            inner join tbuser t3 on t3.id = t2.user_id
                            where t3.id = ?
                            group by created_at
                            order by created_at asc
                          limit 30;";

        $sqlClickPerShow = "select t2.title, count(t.id) as value from tbclicktracking t
                                inner join tbshow t2 on t2.id = t.show_id
                                inner join tbuser t3 on t3.id = t2.user_id
								where t3.id = ?
                                group by t2.title
                                order by count(t.id) desc, t2.start_date
                            limit 30;";
        $clickDay = array_map(function ($click) {
            return [$click['created_at'], $click['value']];
        }, $this->raw($sqlClickPerDay, [$userId])->fetch());
        $clickShow = array_map(function ($click) {
            return [$click['title'], $click['value']];
        }, $this->raw($sqlClickPerShow, [$userId])->fetch());
        return ['click_day' => $clickDay, 'click_show' => $clickShow];
    }

    public function findSaleStats($userId)
    {
        $sql = "select t1.title, count(t3.ticket_id) as value from tbshow t1
                         inner join tbticket t2 on t2.show_id = t1.id
                         inner join tbuserpurchase t3 on t3.ticket_id = t2.id
                         inner join tbuser t4 on t4.id = t1.user_id
                         where t4.id = ?
                    group by t1.title;";
        return array_map(function ($click) {
            return [$click['title'], $click['value']];
        }, $this->raw($sql, [$userId])->fetch());
    }

}