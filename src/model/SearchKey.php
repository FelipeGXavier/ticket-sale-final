<?php

namespace App\Model;

class SearchKey {

    private $uf;
    private $title;

    public function __construct($uf, $title)
    {
        $this->uf = trim(strtolower($uf));
        $this->title = trim(strtolower($title));
    }

    public function __toString()
    {
        $result = "";
        if (!is_null($this->uf)) {
            $result .= "uf:" . $this->uf . ";";
        }
        if (!is_null($this->title)) {
            $result .= "title:" . $this->title;
        }
        return $result;
    }
}