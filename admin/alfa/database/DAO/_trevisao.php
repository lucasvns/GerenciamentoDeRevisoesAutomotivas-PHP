<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");
class _trevisao extends mysql{
    var $TableName = "trevisao";
    var $PrimaryKey = "id";
    var $Campos = array('id','veiculo_id','data','horario','date_created','status','servicos','cliente_id');
    function __construct(){
        parent::__construct();
    }
}