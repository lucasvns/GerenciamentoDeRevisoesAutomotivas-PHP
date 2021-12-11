<?php
require_once (dirname(dirname(__file__)) . "/DAO/_taddress_cep.php");
class taddress_cep extends _taddress_cep{
function taddress_cep(){
	parent::_taddress_cep();
}
function LoadOrdered(){
	$this->SQL_ORDER = "cep";
	return $this->LoadSQL();
}
}