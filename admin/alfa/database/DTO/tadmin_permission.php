<?php

require_once (dirname(dirname(__file__)) . "/DAO/_tadmin_permission.php");

/**
 * Essa � a classe utilizada para administar a tabela tadmin_permission do banco de dados
 * @package db
 * @subpackage concrete
 * @access public
 */
class tadmin_permission extends _tadmin_permission
{
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

    /**
     * Fun��o que carrega as permiss�es do usu�rio
     * 
     * @param int $tadmin_id
     * @param int $tpermission_id
     * @access public
     * @return bool
     */
    function LoadByAgencyPersonIDAndPermissionID($tadmin_id, $tpermission_id)
    {
        $this->SQL_WHERE = " tadmin_id = '" . $tadmin_id . "' AND tpermission_id = '" . $tpermission_id .
            "' ";
        return $this->LoadSQL();
    }

    /**
     * Fun��o que deleta todas as permiss�es do usuario
     * 
     * @param int $tadmin_id
     * @access public
     * @return void
     */
    function DeleteBytadmin_id($tadmin_id)
    {
        $this->LoadByQueryNoResult("DELETE FROM " . $this->TableName . " WHERE tadmin_id = '" .
            $tadmin_id . "' ");
    }
}

?>