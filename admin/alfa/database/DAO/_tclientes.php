<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");
class _tclientes extends mysql{
    var $TableName = "tclientes";
    var $PrimaryKey = "id";
    var $Campos = array('id','nome','telefone','cpf','endereco','date_created');
    function __construct(){
        parent::__construct();
    }
}