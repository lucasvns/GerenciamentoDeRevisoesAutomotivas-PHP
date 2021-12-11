<?php
require_once (dirname(dirname(__file__)) . "/DAO/_tclientes.php");
class tclientes extends _tclientes{
    function __construct(){
        parent::__construct();
    }
    function LoadOrdered(){
        $this->SQL_ORDER = "id";
        return $this->LoadSQL();
    }
}