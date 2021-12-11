<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");
class _tuser extends mysql{
    var $TableName = "tuser";
    var $PrimaryKey = "id";
    var $Campos = array('id','tmedical_insurance_id','name','cpf','rg','date_created','date_birth','gender','email','login_password','token','phone_code','phone_area','phone_number','address_code','address_street','address_number','address_reference','address_district','address_city','address_state','address_country','photo','date_last_login','did_login','device_token',);
    function __construct(){
        parent::__construct();
    }
}