<?php
require_once(dirname(dirname(__file__)) . "/tools/util.php");

$_MYSQL_CONNECTED = false;

/**
 * Essa � a classe utilizada para armazenar dados da conex�o com o banco de dados
 
 * @package db
 * @subpackage conector

 * @access public
 */
class configuracao extends util
{	
	var $DBLocal = "localhost";
	var $DBNome = "projeto";
	var $DBUsuario = "root";
    var $DBSenha = "";

    /**
     * Fun��o que inicia essa classe
     * 
     * @access public
     * @return void
     */
    function __construct()
    {
    	parent::__construct();
    }
}
?>