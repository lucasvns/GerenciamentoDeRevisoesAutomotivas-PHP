<?php

require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");

/**
 * Essa � a classe utilizada para administar a tabela tpermission_title do banco de dados
 * @package db
 * @subpackage DAO
 * @access public
 */
class _tpermission_title extends mysql
{
    /**
     * Vari�vel recebe o nome da tabela tpermission_title do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $TableName = "tpermission_title";

    /**
     * Vari�vel recebe a chave prim�ria da tabela tpermission_title do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $PrimaryKey = "id";

    /**
     * Vari�vel recebe os nomes dos campos da tabela tpermission_title do banco de dados
     *  
     * @access protected 
     * @var array
     */
    var $Campos = array('id', 'title', 'Imagem', 'position');

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