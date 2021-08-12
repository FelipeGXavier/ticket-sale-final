<?php

namespace App;

class PasswordService
{

    public function hash($password) {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function compare($plain, $encoded) {
        return password_verify($plain, $encoded);
    }

}