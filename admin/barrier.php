<?php
session_start();

date_default_timezone_set('America/Sao_Paulo');

define('SERVER_PATH', $_SERVER['DOCUMENT_ROOT'].'/projeto/admin/');
include_once(SERVER_PATH . "/alfa/tools/util.php");
include_once(SERVER_PATH . "/alfa/database/DTO/tadmin.php");
include_once(SERVER_PATH . "/alfa/database/DTO/tparameter.php");

$token = isset($_SESSION['token'])?$_SESSION['token']:'';

$oUtil = new util();
$oParametro = new tparameter();
$pathAdmin = $oParametro->getParametro('admin-url');

$oAdmin = new tadmin();
$oAdmin->SQL_WHERE = ' AdminToken = "'.$token.'" ';
$oAdmin->LoadSQL();

if (!$oAdmin->RowsCount)
{
	header('Location: '.$pathAdmin.'login.php');
    exit();
}

$_SESSION["Session"] = $oAdmin->id;