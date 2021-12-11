<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");
class _tnewsletter extends mysql{
    var $TableName = "tnewsletter";
    var $PrimaryKey = "id";
    var $Campos = array('id','nwl_nome','nwl_email','nwl_tell','date_created',);
    function __construct(){
        parent::__construct();
    }
}