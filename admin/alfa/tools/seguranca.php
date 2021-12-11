<?php

require_once (dirname(__file__) . "/util.php");

$oUtil = new util();

//variavel do local onde os arquivos ficarão
$_DIR = dirname(dirname(dirname(__file__)));
$_DIRFILES = $_DIR . "/src/content";

//valores padrão
@session_start();
@set_time_limit(0);
@error_reporting(0);
@ini_set("safe_mode", "Off");
@ini_set("register_globals","Off");
@ini_set("allow_url_fopen", "Off");
@ini_set('max_execution_time', "0");
@ini_set('track_errors', "On");
@ini_set('display_errors', "On");
@ini_set('file_uploads', "On");
@ini_set('upload_max_filesize', "100MB");
@ini_set('post_max_size', "128MB");
//@ini_set('memory_limit', "128MB");

//limpa variavies
$_SERVER["QUERY_STRING"] = strip_tags($_SERVER["QUERY_STRING"]);

//passa por todas as variáveis
function callback(&$v, $k)
{
//	$v = util::HTMLEncode($v);
$oUtilP = new util();
	$v = $oUtilP->HTMLEncode($v);
}

if(is_array($_GET)) { array_walk_recursive($_GET, "callback"); }
if(is_array($_POST)) { array_walk_recursive($_POST, "callback"); }
if(is_array($_REQUEST)) { array_walk_recursive($_REQUEST, "callback"); }
if(is_array($_COOKIE)) { array_walk_recursive($_COOKIE, "callback"); }
/*if(is_array($HTTP_COOKIE_VARS)) { array_walk_recursive($HTTP_COOKIE_VARS, "callback"); }
if(is_array($HTTP_GET_VARS)) { array_walk_recursive($HTTP_GET_VARS, "callback"); }
if(is_array($HTTP_POST_VARS)) { array_walk_recursive($HTTP_POST_VARS, "callback"); }*/
if(is_array($_COOKIE)) { array_walk_recursive($_COOKIE, "callback"); }
if(is_array($_GET)) { array_walk_recursive($_GET, "callback"); }
if(is_array($_POST)) { array_walk_recursive($_POST, "callback"); }

?>