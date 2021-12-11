<?php

require_once (dirname(dirname(__file__)) . "/DAO/_tpermission_title.php");

/**
 * Essa � a classe utilizada para administar a tabela tpermission_title do banco de dados
 
 * @package db
 * @subpackage concrete

 * @access public
 */
class tpermission_title extends _tpermission_title
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
     * Fun��o que carrega os t�tulos das permiss�es do usu�rio
     * 
     * @param int $tadmin_id
     * @access public
     * @return bool
     */
    function LoadBytadmin_id($tadmin_id)
    {
        return $this->LoadByQuery("SELECT tpermission_title.*
			FROM tpermission_title,tpermission,tadmin_permission
			WHERE tadmin_permission.tadmin_id = '" . $tadmin_id . "'
			AND tadmin_permission.tpermission_id = tpermission.id
			AND tpermission.tpermission_title_id = tpermission_title.id
			GROUP BY tpermission_title.id
			ORDER BY tpermission_title.position ASC");
    }
}

?>