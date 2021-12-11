<?php
require_once (dirname(dirname(__file__)) . "/DAO/_tpoints.php");
class tpoints extends _tpoints{
function tpoints(){
	parent::_tpoints();
}
function LoadOrdered(){
	$this->SQL_ORDER = "id";
	return $this->LoadSQL();
}
}