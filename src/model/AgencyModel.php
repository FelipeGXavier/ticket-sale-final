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
            foreach ($segments as $segment) {
                $insert[] = $segment;
                $insert[] = $this->getInsertId();
                $this->raw($sqlSegment, $insert);
            }
            $this->raw($sqlUpdateWelcome);
            $this->commit();
        }catch (\Exception $e) {
            $this->rollback();
            throw $e;
        }
    }

}