<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");
class _tveiculos extends mysql{
    var $TableName = "tveiculos";
    var $PrimaryKey = "id";
    var $Campos = array('id','cliente_id','numero_placa','modelo','ano_fabricacao','valor',);
    function __construct(){
        parent::__construct();
    }
}