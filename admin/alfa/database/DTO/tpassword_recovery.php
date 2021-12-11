<?php
require_once (dirname(dirname(__file__)) . "/DAO/_tpassword_recovery.php");
class tpassword_recovery extends _tpassword_recovery{
function tpassword_recovery(){
	parent::_tpassword_recovery();
}
function LoadOrdered(){
	$this->SQL_ORDER = "id";
	return $this->LoadSQL();
}
}