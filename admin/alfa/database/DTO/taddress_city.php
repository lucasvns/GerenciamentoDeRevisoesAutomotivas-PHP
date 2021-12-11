<?php
require_once (dirname(dirname(__file__)) . "/DAO/_taddress_city.php");
/**
 * Essa é a classe utilizada para administar a tabela tequipe do banco de dados
 * @package database
 * @subpackage concrete
 * @access public
 */
class taddress_city extends _taddress_city{
/**
 * Função que inicia essa classe
 * 
 * @access public
 * @return void
 */
function __construct(){
	parent::__construct();
}
function LoadOrdered(){
	$this->SQL_ORDER = "id";
	return $this->LoadSQL();
}
}
?>