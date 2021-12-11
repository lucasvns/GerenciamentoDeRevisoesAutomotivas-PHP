<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");

/**
 * Essa � a classe utilizada para administar a tabela tadmin do banco de dados
 * @package db
 * @subpackage DAO
 * @access public
 */
class _tadmin extends mysql
{
    /**
     * Vari�vel recebe o nome da tabela tadmin do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $TableName = "tadmin";

    /**
     * Vari�vel recebe a chave prim�ria da tabela tadmin do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $PrimaryKey = "id";

    /**
     * Vari�vel recebe os nomes dos campos da tabela tadmin do banco de dados
     *  
     * @access protected 
     * @var array
     */
    var $Campos = array('id', 'name', 'hash_pass', 'date_created', 'last_access', 'email', 'birth_date', 'image', 'session_id', 'AdminToken', 'device_token');

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