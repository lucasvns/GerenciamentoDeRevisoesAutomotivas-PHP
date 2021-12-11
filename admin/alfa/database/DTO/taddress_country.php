<?php
require_once (dirname(dirname(__file__)) . "/DAO/_taddress_country.php");
/**
 * Essa é a classe utilizada para administar a tabela tequipe do banco de dados
 * @package database
 * @subpackage concrete
 * @access public
 */
class taddress_country extends _taddress_country{
/**
 * Função que inicia essa classe
 * 
 * @access public
 * @return void
 */
function taddress_country(){
	parent::_taddress_country();
}
function LoadOrdered(){
	$this->SQL_ORDER = "id";
	return $this->LoadSQL();
}
}
?>