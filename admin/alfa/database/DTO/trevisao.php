<?php
require_once (dirname(dirname(__file__)) . "/DAO/_trevisao.php");
class trevisao extends _trevisao{
    function __construct(){
        parent::__construct();
    }
    function LoadOrdered(){
        $this->SQL_ORDER = "id";
        return $this->LoadSQL();
    }
}