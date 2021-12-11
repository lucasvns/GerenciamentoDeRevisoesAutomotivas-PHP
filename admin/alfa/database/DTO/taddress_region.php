<?php
require_once (dirname(dirname(__file__)) . "/DAO/_taddress_region.php");
/**
 * Essa é a classe utilizada para administar a tabela tequipe do banco de dados
 * @package database
 * @subpackage concrete
 * @access public
 */
class taddress_region extends _taddress_region{
/**
 * Função que inicia essa classe
 * 
 * @access public
 * @return void
 */
function taddress_region(){
	parent::_taddress_region();
}
function LoadOrdered(){
	$this->SQL_ORDER = "id";
	return $this->LoadSQL();
}
}
?>