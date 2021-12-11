<?php
require_once (dirname(dirname(__file__)) . "/DAO/_tveiculos.php");
class tveiculos extends _tveiculos{
    function __construct(){
        parent::__construct();
    }
    function LoadOrdered(){
        $this->SQL_ORDER = "id";
        return $this->LoadSQL();
    }
}