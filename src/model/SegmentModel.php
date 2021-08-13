<?php

namespace App\Model;

use Core\AbstractDAO;

class SegmentModel extends AbstractDAO
{

    public function findSegments() {
        $sql = "SELECT * FROM tbsegment";
        return $this->raw($sql)->fetch();
    }

}