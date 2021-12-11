<?php

require_once (dirname(dirname(__file__)) . "/DAO/_tpermission.php");

/**
 * Essa � a classe utilizada para administar a tabela tpermission do banco de dados
 * @package db
 * @subpackage concrete
 * @access public
 */
class tpermission extends _tpermission
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
     * Fun��o que carrega as permiss�es do usu�rios
     * 
     * @param int $tadmin_id
     * @param int $tpermission_title_id
     * @access public
     * @return bool
     */
    function LoadBytadmin_idAndtpermission_title_id($tadmin_id, $tpermission_title_id)
    {
        return $this->LoadByQuery("SELECT tpermission.*
			FROM tpermission,tadmin_permission
			WHERE tadmin_permission.tadmin_id = '" . $tadmin_id . "'
			AND tpermission.tpermission_title_id = '" . $tpermission_title_id . "'
			AND tadmin_permission.tpermission_id = tpermission.id
			ORDER BY tpermission.position ASC");
    }

    /**
     * Fun��o que carrega as permiss�es do usu�rios
     * 
     * @param int $tadmin_id
     * @param string $keyword
     * @access public
     * @return bool
     */
    function LoadBytadmin_idAndkeyword($tadmin_id, $keyword)
    {
        return $this->LoadByQuery("SELECT tpermission.*
			FROM tpermission,tadmin_permission
			WHERE tadmin_permission.tadmin_id = '" . $tadmin_id . "'
			AND tpermission.keyword = '" . $keyword . "'
			AND tadmin_permission.tpermission_id = tpermission.id
			ORDER BY tpermission.position ASC");
    }

    /**
     * Fun��o que carrega as permiss�es
     * 
     * @param int $tpermission_title_id
     * @param int $list
     * @access public
     * @return bool
     */
    function LoadBytpermission_title_idAndlist($tpermission_title_id, $list)
    {
        $this->SQL_WHERE = " tpermission_title_id = '" . $tpermission_title_id . "' AND list = '" . $list . "'";
        $this->SQL_ORDER = "position ASC";
        return $this->LoadSQL();
    }
    
    /**
     * Fun��o que carrega as permiss�es
     * 
     * @param int $list
     * @access public
     * @return bool
     */
    function LoadBylist($list)
    {
        $this->SQL_WHERE = " list = '" . $list . "'";
        $this->SQL_ORDER = "position ASC";
        return $this->LoadSQL();
    }

    /**
     * Fun��o que carrega as permiss�es
     * 
     * @param string $title
     * @access public
     * @return bool
     */
    function LoadBytitle($title)
    {
        $this->SQL_WHERE = " title = '" . $title . "' ";
        $this->SQL_ORDER = "position ASC";
        return $this->LoadSQL();
    }
    
    /**
     * Fun��o que carrega a permiss�o
     * 
     * @param string $keyword
     * @access public
     * @return bool
     */
    function LoadBykeyword($keyword)
    {
        $this->SQL_WHERE = " keyword = '" . $keyword . "' ";
        $this->SQL_ORDER = "position ASC";
        return $this->LoadSQL();
    }
}

?>