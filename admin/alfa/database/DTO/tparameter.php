<?php

require_once (dirname(dirname(__file__)) . "/DAO/_tparameter.php");

/**
 * Essa � a classe utilizada para administar a tabela tparameter do banco de dados
 
 * @package db
 * @subpackage concrete

 * @access public
 */
class tparameter extends _tparameter
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
     * Fun��o que carrega um par�metro
     * 
     * @param string $keyword
     * @access public
     * @return bool
     */
    function LoadBykeyword($keyword)
    {
        $this->SQL_WHERE = "keyword = '" . $keyword . "'";
        return $this->LoadSQL();
    }

    /**
     * Fun��o que altera um par�metro
     * 
     * @param string $keyword
     * @param string $val
     * @access public
     * @return void
     */
    function setParametro($keyword, $val)
    {
        $oParametro = new tparameter();
        if ($oParametro->LoadBykeyword($keyword))
        {
            $oParametro->val = $val;
            $oParametro->Save();
        }
    }

    /**
     * Fun��o que carrega o valor de um par�metro
     * 
     * @param string $keyword
     * @access public
     * @return string
     */
    function getParametro($keyword)
    {
        $ret = "";
        $oParametro = new tparameter();
        if ($oParametro->LoadBykeyword($keyword))
        {
            $ret = $oParametro->val;
        }
        return $ret;
    }
    
    /**
     * Fun�ao que carrega todos os valores
     * 
     * @access public
     * @return array
     */
    function LoadObjetos()
    {
    	$ar = array();
    	if($this->LoadSQL())
    	{
	    	for($a = 0; $a < $this->RowsCount; $a++)
	    	{
	    		$ar[$this->keyword] = $this->val;
	    		$this->MoveNext();
	    	}
	    }
	    return $ar;
    }
}

?>