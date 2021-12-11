<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");
class _taddress extends mysql{
    var $TableName = "taddress";
    var $PrimaryKey = "id";
    var $Campos = array('id', 'tuser_id', 'tempresa_id' , 'taddress_district_id', 'code', 'street', 'number', 'reference', 'latitude', 'longitude');
    function __construct(){
        parent::__construct();
    }
}