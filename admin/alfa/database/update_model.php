<?php
include_once("DTO/tparameter.php");

$oUpdate = new tparameter();
$oUpdate->LoadByQuery(' SHOW TABLES; ');

for ($i=0; $i < $oUpdate->RowsCount; $i++) { 
    echo $oUpdate->Tables_in_projeto.' = ';
    echo file_exists('DAO/_'.$oUpdate->Tables_in_projeto.'.php');
    echo '<br />';
    //DTO
    if(!file_exists('DTO/'.$oUpdate->Tables_in_projeto.'.php')){
        $dto = 
'<?php
require_once (dirname(dirname(__file__)) . "/DAO/_'.$oUpdate->Tables_in_projeto.'.php");
class '.$oUpdate->Tables_in_projeto.' extends _'.$oUpdate->Tables_in_projeto.'{
    function __construct(){
        parent::__construct();
    }
    function LoadOrdered(){
        $this->SQL_ORDER = "id";
        return $this->LoadSQL();
    }
}';
        $fp=fopen('DTO/'.$oUpdate->Tables_in_projeto.'.php','w');
        fwrite($fp, $dto);
        fclose($fp);
    }
    //DAO
    if(!file_exists('DAO/_'.$oUpdate->Tables_in_projeto.'.php')){
        //
        $columns = '';
        $oUpdate2 = new tparameter();
        $oUpdate2->LoadByQuery("SHOW COLUMNS FROM ".$oUpdate->Tables_in_projeto.";");
        for ($j=0; $j < $oUpdate2->RowsCount; $j++) {
            $columns .= "'".$oUpdate2->DefaultView[$j][0]."',";
            $oUpdate2->MoveNext();
        }
        //
        $dto = 
'<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");
class _'.$oUpdate->Tables_in_projeto.' extends mysql{
    var $TableName = "'.$oUpdate->Tables_in_projeto.'";
    var $PrimaryKey = "id";
    var $Campos = array('.$columns.');
    function __construct(){
        parent::__construct();
    }
}';
        $fp=fopen('DAO/_'.$oUpdate->Tables_in_projeto.'.php','w');
        fwrite($fp, $dto);
        fclose($fp);
    }
    $oUpdate->MoveNext();
}