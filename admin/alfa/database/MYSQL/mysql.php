<?php

require_once (dirname(dirname(__file__)) . "/configuracao.php");

/**
 * Essa � a classe utilizada para administar as tabelas do banco de dados
 
 * @package db
 * @subpackage conector

 * @access public
 */
class mysql extends configuracao
{
	/**
     * Vari�vel recebe a conex�o do mysql
     *  
     * @access private 
     * @var $con
     */
    var $_Connection = 0;
    
    /**
     * Vari�vel recebe a quantidade de linhas afetadas da consulta no banco de dados
     *  
     * @access private 
     * @var int
     */
    var $_AffectedRows = 0;

    /**
     * Vari�vel recebe a �ltima chave primaria inserida no banco de dados 
     * 
     * @access private 
     * @var int
     */
    var $_InsertID = 0;

    /**
     * Vari�vel recebe o status do objeto (INSERT/DELETE/LOADED) setada pelo usu�rio 
     * 
     * @access private 
     * @var string
     */
    var $_STATE;

    /**
     * Vari�vel recebe o status do objeto (INSERT/DELETE/LOADED) setada pelo usu�rio 
     * 
     * @access private 
     * @var string
     */
    var $_RESULT;


    /**
     * Vari�vel recebe a �ltima SQL executada pelo usu�rio 
     * 
     * @access public 
     * @var string
     */
    var $GenerateSQL = "";

    /**
     * Vari�vel recebe um array dos registros encontrados na SQL executada pelo usu�rio 
     * 
     * @access public 
     * @var array 
     */
    var $DefaultView = array();

    /**
     * Vari�vel recebe a quantidade de registros encontrados na SQL executada pelo usu�rio 
     * 
     * @access public 
     * @var int
     */
    var $RowsCount = 0;

    /**
     * Vari�vel SQL_WHERE
     * 
     * @access public 
     * @var string
     */
    var $SQL_WHERE = null;

    /**
     * Vari�vel SQL_GROUP
     * 
     * @access public 
     * @var string
     */
    var $SQL_GROUP = null;

    /**
     * Vari�vel SQL_ORDER
     * 
     * @access public 
     * @var string
     */
    var $SQL_ORDER = null;

    /**
     * Vari�vel SQL_INICIO
     * 
     * @access public 
     * @var int
     */
    var $SQL_INICIO = null;

    /**
     * Vari�vel SQL_TOTAL
     * 
     * @access public 
     * @var int
     */
    var $SQL_TOTAL = null;

    /**
     * Vari�vel SQL_CAMPO
     * @access public 
     * @var string
     */
    var $SQL_CAMPO = null;

    /**
     * Vari�vel SQL_AS 
     * 
     * @access public 
     * @var string
     */
    var $SQL_AS = null;

    /**
     * Vari�vel SQL_FN
     * 
     * @access public 
     * @var string
     */
    var $SQL_FN = null;
    
    /**
     * Vari�vel SQL_FROM
     * 
     * @access public 
     * @var string
     */
    var $SQL_FROM = null;
    
    /**
     * Vari�vel SQL_JOIN
     * 
     * @access public 
     * @var string
     */
    var $SQL_JOIN = null;

    /**
     * Fun��o que inicia essa classe
     * 
     * @access public
     * @return void
     */
    function __construct()
    {
    	parent::__construct();
    	global $_MYSQL_CONNECTED;
    	
    	//conecta no banco
    	$this->_Connection = $_MYSQL_CONNECTED;
    	if(!$this->_Connection)
		{
			$_MYSQL_CONNECTED = $this->Conecta();
    	}
    }

    /**
     * Fun��o que conecta no banco de dados
     * 
     * @access public
     * @return void
     */
    function Conecta()
    {
    	$this->_Connection = mysqli_connect($this->DBLocal.'', $this->DBUsuario, $this->DBSenha) or die(mysql_error($this->_Connection));
        mysqli_select_db($this->_Connection,$this->DBNome) or die(mysqli_error($this->_Connection));
        return $this->_Connection;
    }

    /**
     * Fun��o que adiciona um novo registro no banco de dados
     * 
     * @access public
     * @return void
     */
    function AddNew()
    {
        $this->_STATE = "INSERT";
    }

    /**
     * Fun��o que remove um registro do banco de dados
     * 
     * @access public
     * @return void
     */
    function MarkAsDelete()
    {
        $this->_STATE = "DELETE";
    }

    /**
     * Fun��o que executa altera��es no banco de dados (INSERT/UPDATE/DELETE)
     * 
     * @access public
     * @return bool
     */
    function Save()
    {
        $bret = false;
        switch ($this->_STATE)
        {
            case "INSERT":
                if ($this->Insert() > 0)
                {
                    $this->_STATE = "LOADED";
                    $bret = true;
                }
                break;
            case "DELETE":
                if ($this->Delete() > 0)
                {
                    $this->AddNew();
                    $bret = true;
                }
                break;
            case "LOADED":
                if ($this->Update() > 0)
                {
                    $bret = true;
                }
                break;
        }
        return $bret;
    }

    /**
     * Fun��o que carrega um registro do banco de dados atrav�s de sua chave prim�ria
     * 
     * @param int $ID
     * @access public
     * @return bool
     */
    function LoadByPrimaryKey($ID)
    {
        $this->SQL_WHERE = $this->PrimaryKey . " = '" . $this->AntiSQLInjection($ID) . "'";
        return $this->LoadSQL();
    }

    /**
     * Fun��o que executa a query passada pelo usu�rio
     * 
     * @param string $sql
     * @access public
     * @return bool
     */
    function LoadByQuery($sql)
    {
        return $this->prepare($sql);
    }

    /**
     * Fun��o que executa a query passada pelo usu�rio e preenche o DefaultView
     * 
     * @param string $sql
     * @access public
     * @return void
     */
    function LoadByQueryNoResult($sql)
    {
        return $this->ExecuteQuery($sql);
    }

    /**
     * Fun��o que monta e executa a sql montada pelo usu�rio
     * 
     * @access public
     * @return bool, int
     */
    function LoadSQL()
    {
        $order = "";
        $where = "";
        $group = "";
        $limit = "";
        $as = "";
        $fn = "";
        $campo = "";

        if ($this->SQL_WHERE)
        {
            $where = " WHERE " . $this->SQL_WHERE;
        }
        if ($this->SQL_GROUP)
        {
            $group = " GROUP BY " . $this->SQL_GROUP;
        }
        if ($this->SQL_ORDER)
        {
            $order = " ORDER BY " . $this->SQL_ORDER;
        }
        if ($this->SQL_TOTAL)
        {
            $limit = " Limit " . (($this->SQL_INICIO) ? $this->SQL_INICIO : 0) . " , " . $this->SQL_TOTAL;
        }
        if ($this->SQL_FN)
        {
            $fn = $this->SQL_FN;
        }
        if ($this->SQL_AS)
        {
            $as = $this->SQL_AS;
        }
        if ($this->SQL_CAMPO)
        {
            $campo = $this->SQL_CAMPO;
        }
        else
        {
            $campo = $this->PrimaryKey;
        }

        if (! $fn)
        {
            return $this->prepare("SELECT * FROM " . $this->TableName . $where . $group . $order . $limit);
        }
        else
        {
            if ($as)
            {
                return $this->prepare("SELECT *, " . $fn . "(" . $campo . ") as " . $as . " FROM " . $this->TableName . $where . $group . $order . $limit);
            }
            else
            {
                $ar = $this->ExecuteQuery("SELECT " . $fn . "(" . $campo . ") FROM " . $this->TableName . $where . $group . $order . $limit);
                $fetch = $this->fetch($ar);
                return $fetch[0];
            }
        }
    }
    
    /**
     * Fun��o que executa uma pr�-query
     * 
     * @access public
     * @return bool
     */
	function LoadSQLAssembled()
	{
		$sql = " SELECT " .
			   (($this->SQL_CAMPO) ? $this->SQL_CAMPO : $this->TableName . ".*") .
			   " FROM " .
			   (($this->SQL_FROM) ? $this->SQL_FROM : $this->TableName) .
			   " " . $this->SQL_JOIN .
			   (($this->SQL_WHERE) ? " WHERE " . $this->SQL_WHERE : "") .
			   (($this->SQL_GROUP) ? " GROUP BY " . $this->SQL_GROUP : "") .
			   (($this->SQL_ORDER) ? " ORDER BY " . $this->SQL_ORDER : "") .
			   (($this->SQL_TOTAL) ? " LIMIT " . (($this->SQL_INICIO) ? $this->SQL_INICIO : 0) . ", " . $this->SQL_TOTAL : "");
		
		return $this->prepare($sql);
	}
	
    /**
     * Fun��o que passa para o pr�ximo registro do DefaultView
     * 
     * @param int $Position
     * @access public
     * @return void
     */
    function MoveNext($Position = null)
	{
		$return = false;
		if($Position === null)
		{
			$return = next($this->DefaultView);
			$row = current($this->DefaultView);
		}
		else
		{
			$row = $this->DefaultView[$Position];
			$return = true;
		}
		$this->SetRow($row);
		return ((@is_bool($return)) ? $return : true);
	}

    /**
     * Fun��o que voltra para o primeira registro do DefaultView
     * 
     * @access public
     * @return void
     */
    function Rewind()
    {
        reset($this->DefaultView);
        $row = current($this->DefaultView);
        $this->SetRow($row);
    }

    /**
     * Fun��o que cria as vari�veis de acordo com o array CAMPOS
     * 
     * @param array $row
     * @access private
     * @return void
     */
    function SetRow($row)
    {
    	if(is_array($this->Campos))
    	{
    		foreach($this->Campos as $c => $v)
    		{
    			//$this->{$v} = $row[$v];
    			$this->{$v} = null;
    		}
    	}
    	if(is_array($row))
    	{
    		foreach($row as $c => $v)
    		{
    			$this->{$c} = $v;
    		}
    	}
    }

    /**
     * Fun��o que cria array atrav�s das vari�veis criadas com o array CAMPOS
     * 
     * @access private
     * @return array
     */
    function GetRow()
    {
    	$row = array();
    	foreach($this->Campos as $c => $v)
    	{
			if(isset($this->{$v})){
    			$row[$v] = $this->AntiSQLInjection($this->{$v});
			}
    	}
    	return $row;
    }

    /**
     * Fun��o que retorna uma matriz que corresponde a linha obtida e move o ponteiro interno dos dados adiante.
     * 
     * @param mysql_query $result
     * @access private
     * @return mysql_fetch_array
     */
    function fetch($result)
    {
        return mysqli_fetch_array($result);
    }

    /**
     * Fun��o que prepara o DefaultView
     * 
     * @param string $sql
     * @access private
     * @return bool
     */
    function prepare($sql)
    {
        $result = $this->ExecuteQuery($sql);
        if ($result)
        {
            while ($row = $this->fetch($result))
            {
                array_push($this->DefaultView, $row);
            }
        }
        return $this->setLoaded();
    }

    /**
     * Fun��o que executa query no banco de dados
     * 
     * @param string $sql
     * @access private
     * @return mysql_query
     */
    function ExecuteQuery($sql)
    {
        $this->GenerateSQL = $sql;
        $query = mysqli_query($this->_Connection,$sql) or die(mysqli_error($this->_Connection));
        $this->_AffectedRows = mysqli_affected_rows($this->_Connection);
        $this->_InsertID = mysqli_insert_id($this->_Connection);
        $this->SQL_AS = null;
        $this->SQL_CAMPO = null;
        $this->SQL_FN = null;
        $this->SQL_GROUP = null;
        $this->SQL_INICIO = null;
        $this->SQL_ORDER = null;
        $this->SQL_TOTAL = null;
        $this->SQL_WHERE = null;
        return $query;
    }

    /**
     * Fun��o que insere registro no banco de dados
     * 
     * @access private
     * @return int
     */
    function Insert()
    {
        $rows = $this->GetRow();
        $cols = array_keys($rows);
        $values = array_values($rows);
        $sql = "INSERT INTO " . $this->TableName . ' (' . implode(', ', $cols) . ') ' . 'VALUES ("' . implode('", "', $values) . '")';
        $result = $this->ExecuteQuery($sql);
        $this->{$this->PrimaryKey} = $this->_InsertID;
        return $this->_InsertID;
    }

    /**
     * Fun��o que altera registro no banco de dados
     * 
     * @access private
     * @return int
     */
    function Update()
    {
        $set = array();
        $rows = $this->GetRow();
        foreach ($rows as $col => $val)
        {
            $set[] = $col . " = '" . $val . "'";
        }
        $sql = " UPDATE " . $this->TableName . " SET " . implode(', ', $set) . " WHERE " . $this->PrimaryKey . " = '" . $this->{$this->PrimaryKey} . "'";
        $result = $this->ExecuteQuery($sql);
        return $this->_AffectedRows;
    }

    /**
     * Fun��o que deleta registro no banco de dados
     * 
     * @access private
     * @return int
     */
    function Delete()
    {
        $sql = " DELETE FROM " . $this->TableName . 
		" WHERE " . $this->PrimaryKey . " = '" . $this->AntiSQLInjection($this->{$this->PrimaryKey}) . "'";
        $result = $this->ExecuteQuery($sql);
        return $this->_AffectedRows;
    }

    /**
     * Fun��o que carrega as vari�veis criadas com o array CAMPOS atrav�s do DefaultView
     * 
     * @access private
     * @return bool
     */
    function setLoaded()
    {
        if (! $this->DefaultView)
        {
            return false;
        }
        else
        {
            $this->_STATE = "LOADED";
            $this->RowsCount = count($this->DefaultView);
            $row = current($this->DefaultView);
            $this->SetRow($row);
            return true;
        }
    }
    
    /**
     * Fun��o que fecha a conex�o do mysql
     * 
     * @access private
     * @return void
     */
    function Close()
    {
    	mysql_close($this->_Connection);
    }
    
    
    /**
     * Fun��o que verifica a string
     * 
     * @param string $string
     * @access private
     * @return string
     */
    function AntiSQLInjection($string)
	{
	    $string = get_magic_quotes_gpc() ? stripslashes($string) : $string;
	    $string = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($this->_Connection,$string) : mysqli_escape_string($string);
	    return $string;
	}

}

?>