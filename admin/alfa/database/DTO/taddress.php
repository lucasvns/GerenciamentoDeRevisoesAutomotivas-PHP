<?php
require_once (dirname(dirname(__file__)) . "/DAO/_taddress.php");
class taddress extends _taddress{
function __construct(){
	parent::__construct();
}
function LoadOrdered(){
	$this->SQL_ORDER = "id";
	return $this->LoadSQL();
}
}