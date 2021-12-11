<?php
require_once (dirname(dirname(__file__)) . "/DAO/_tadmin.php");

/**
 * Essa � a classe utilizada para administar a tabela tadmin do banco de dados
 * @package db
 * @subpackage concrete
 * @access public
 */
class tadmin extends _tadmin
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
     * Fun��o que verifica se o usu�rio e senha s�o v�lidos
     * 
     * @access public
     * @return bool
     */
    function Acesso()
    {
        $this->SQL_WHERE = " email = '" . $this->email . "' AND hash_pass = '" . $this->
            hash_pass . "' ";
        return $this->LoadSQL();
    }
    
    /**
     * Fun��o que retorna a sess�o do admin
     * 
     * @access public
     * @return $_SESSION
     */
    function GetSession()
    {
        return $_SESSION["Session"];
    }

    /**
     * Fun��o que seta a sess�o do admin
     * 
     * @access public
     * @return void
     */
    function SetSession()
    {
        $_SESSION["Session"] = $this->id;
    }

    /**
     * Fun��o que verifica se o usu�rio existe
     * 
     * @param string $email
     * @access public
     * @return bool
     */
    function LoadByUsuario($email)
    {
        $this->SQL_WHERE = " email = '" . $email . "' ";
        return $this->LoadSQL();
    }

    /**
     * Fun��o que carrega um <select> com os usu�rios ordenadas pelo nome ascendente
     * 
     * @param int $tadmin_id
     * @access public
     * @return void
     */
    function ddl($tadmin_id = null)
    {
        $oAdmin = new tadmin();
        $oAdmin->SQL_ORDER = " email ASC ";
        $oAdmin->LoadSQL();
        for ($it = 0; $it < $oAdmin->RowsCount; $it++)
        {
            $sel = "";
            if ($tadmin_id == $oAdmin->id)
            {
                $sel = 'selected="selected"';
            }

            echo '<option ' . $sel . ' value="' . $oAdmin->id . '">' . $oAdmin->name .
                '</option>';
            $oAdmin->MoveNext();
        }
    }
}

?>