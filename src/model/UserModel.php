<?php

namespace App\Model;

class UserModel extends \Core\AbstractDAO
{
    const USER_TYPE_AGENT = 0;
    const USER_TYPE_CLIENT = 1;
    const USER_TYPE_ADMIN = 2;

    public function create($input) {
        $sql = 'INSERT INTO tbuser (name, email, password, birth, user_type, accept, welcome) VALUES (?, ?, ?, ?, ?, ?, ?)';
        return $this->raw($sql, array_values($input));
    }

    public function findUserByEmail($email) {
        $sql = 'SELECT * FROM tbuser WHERE email = ?';
        $result = $this->raw($sql, [$email])->fetch();
        if($result != null && !empty($result)) {
            return $result[0];
        }
        return [];
    }



}