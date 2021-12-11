<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");
class _taddress_cep extends mysql{
    var $TableName = "taddress_cep";
    var $PrimaryKey = "id";
    var $Campos = array('id', 'cep', 'street', 'district', 'city', 'state');
    function _taddress_cep(){
        parent::mysql();
    }
}