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

    public function findTrackingStats()
    {
        $sqlClickPerDay = "select created_at, count(created_at) as value from tbclicktracking
                                group by created_at
                                order by created_at asc
                            limit 30;";
        $sqlClickPerShow = "select t2.title, count(t.id) as value from tbclicktracking t
                                inner join tbshow t2 on t2.id = t.show_id
                                group by t2.title
                                order by count(t.id) desc, t2.start_date
                            limit 30;";
        $clickDay = array_map(function ($click) {
            return [$click['created_at'], $click['value']];
        },   $this->raw($sqlClickPerDay)->fetch());
        $clickShow = array_map(function ($click) {
            return [$click['title'], $click['value']];
        },   $this->raw($sqlClickPerShow)->fetch());
        return ['click_day' => $clickDay, 'click_show' => $clickShow];
    }

}