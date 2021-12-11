<?php
require_once (dirname(dirname(__file__)) . "/DAO/_.php");
class  extends _{
    function __construct(){
        parent::__construct();
    }
    function LoadOrdered(){
        $this->SQL_ORDER = "id";
        return $this->LoadSQL();
    }
}