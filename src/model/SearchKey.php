<?php

namespace App\Model;

class SearchKey {

    private $uf;
    private $title;
    private $page;

    public function __construct($uf, $title, $page)
    {
        $this->uf = trim(strtolower($uf));
        $this->title = trim(strtolower($title));
        $this->page = $page;
    }

    public function __toString()
    {
        $result = "";
        if (!is_null($this->uf)) {
            $result .= "uf:" . $this->uf . ";";
        }
        if (!is_null($this->title)) {
            $result .= "title:" . $this->title . ";";
        }
        $result .= "page:" . $this->page;
        return $result;
    }
}