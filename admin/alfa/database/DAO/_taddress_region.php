<?php

require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");

class _taddress_region extends mysql
{
    /**
     * Variсvel recebe o nome da tabela tusuario do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $TableName = "taddress_region";

    /**
     * Variсvel recebe a chave primсria da tabela tusuario do banco de dados
     *  
     * @access protected 
     * @var string
     */
    var $PrimaryKey = "id";

    /**
     * Variсvel recebe os nomes dos campos da tabela tusuario do banco de dados
     *  
     * @access protected 
     * @var array
     */
    var $Campos = array('id', 'name');

    /**
     * Funчуo que inicia essa classe
     * 
     * @access public
     * @return void
     */
    function _taddress_region()
    {
        parent::mysql();
    }
}

?>