<?php

namespace App\Model;

use App\Util\Util;
use Core\AbstractDAO;

class PurchaseModel extends AbstractDAO
{

    public function createPurchase($userId, $checkout)
    {
        $sqlInsertPurchase = "INSERT into tbuserpurchase (user_id, ticket_id, price_purchased) VALUES (?, ?, ?)";
        $sqlTicket = "SELECT id, price, qtd_ticket FROM tbticket where id = ? AND show_id = ?";
        $sqlUpdateTicket = "UPDATE tbticket SET qtd_ticket = ? WHERE id = ?";
        try {
            $this->startTransaction();
            foreach ($checkout as $purchase) {
                $purchaseTicketId = $purchase['ticket_id'];
                $purchaseShowId = $purchase['show_id'];
                $showTicket = $this->raw($sqlTicket, Util::flat([$purchaseTicketId, $purchaseShowId]))->fetch();
                if (!empty($showTicket)) {
                    $ticketAvailable = $showTicket[0]['qtd_ticket'];
                    if ($ticketAvailable - 1 > 0) {
                        $this->raw($sqlInsertPurchase, Util::flat([$userId, $purchaseTicketId, $showTicket[0]['price']]));
                        $this->raw($sqlUpdateTicket, Util::flat([($ticketAvailable - 1), $showTicket[0]['id']]));
                    } else {
                        throw new \Exception("Inconsistent state");
                    }
                } else {
                    throw new \Exception("Inconsistent state");
                }
                $this->commit();
            }
        } catch (\Exception $e) {
            $this->rollback();
        }

    }

    public function findPurchaseHistory($userId)
    {

    }

}