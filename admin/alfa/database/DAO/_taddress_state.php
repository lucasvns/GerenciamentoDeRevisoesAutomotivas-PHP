<?php

require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");

class _taddress_state extends mysql
{
    /**
     * Vari�vel recebe o nome da tabela tusuario do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $TableName = "taddress_state";

    /**
     * Vari�vel recebe a chave prim�ria da tabela tusuario do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $PrimaryKey = "id";

    /**
     * Vari�vel recebe os nomes dos campos da tabela tusuario do banco de dados
     *  
     * @access protected 
     * @var array
     */
    var $Campos = array('id', 'taddress_country_id', 'name', 'abrev');

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