<?php

require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");

/**
 * Essa � a classe utilizada para administar a tabela tpermission do banco de dados
 * @package db
 * @subpackage DAO
 * @access public
 */
class _tpermission extends mysql
{
    /**
     * Vari�vel recebe o nome da tabela tpermission do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $TableName = "tpermission";

    /**
     * Vari�vel recebe a chave prim�ria da tabela tpermission do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $PrimaryKey = "id";

    /**
     * Vari�vel recebe os nomes dos campos da tabela tpermission do banco de dados
     *  
     * @access protected 
     * @var array
     */
    var $Campos = array('id', 'title', 'tpermission_title_id', 'keyword', 'list', 'position', 'icon');

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