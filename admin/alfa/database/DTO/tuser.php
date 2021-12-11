<?php
require_once (dirname(dirname(__file__)) . "/DAO/_tuser.php");
/**
 * Essa é a classe utilizada para administar a tabela tequipe do banco de dados
 * @package database
 * @subpackage concrete
 * @access public
 */
class tuser extends _tuser
{
	
    /**
     * Função que inicia essa classe
     * 
     * @access public
     * @return void
     */
    function __construct()
    {
        parent::__construct();
    }

    /**
     * Função que verifica se o usuário e senha são válidos
     * 
     * @access public
     * @return bool
     */
    function Acesso()
    {
        $this->SQL_WHERE = " email = '" . $this->email . "' AND login_password = '" . $this->
            hash_pass . "' ";
        return $this->LoadSQL();
    }
    
    /**
     * Função que retorna a sessão do admin
     * 
     * @access public
     * @return $_SESSION
     */
    function GetSession()
    {
        return $_SESSION["Session"];
    }

    /**
     * Função que seta a sessão do admin
     * 
     * @access public
     * @return void
     */
    function SetSession()
    {
        $_SESSION["Session"] = $this->id;
    }

    /**
     * Função que verifica se o usuário existe
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
     * Função que carrega um <select> com os usuários ordenadas pelo nome ascendente
     * 
     * @param int $tuser_id
     * @access public
     * @return void
     */
    function ddl($tuser_id = null)
    {
        $oAdmin = new tuser();
        $oAdmin->SQL_ORDER = " email ASC ";
        $oAdmin->LoadSQL();
        for ($it = 0; $it < $oAdmin->RowsCount; $it++)
        {
            $sel = "";
            if ($tuser_id == $oAdmin->id)
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