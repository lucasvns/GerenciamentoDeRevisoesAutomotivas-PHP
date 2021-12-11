<?php

require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");

/**
 * Essa � a classe utilizada para administar a tabela tparameter do banco de dados
 * @package db
 * @subpackage DAO
 * @access public
 */
class _tparameter extends mysql
{
    /**
     * Vari�vel recebe o nome da tabela tparameter do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $TableName = "tparameter";

    /**
     * Vari�vel recebe a chave prim�ria da tabela tparameter do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $PrimaryKey = "id";

    /**
     * Vari�vel recebe os nomes dos campos da tabela tparameter do banco de dados
     *  
     * @access protected 
     * @var array
     */
    var $Campos = array('id', 'val', 'keyword');

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