<?php

require_once (dirname(__file__) . "/util.php");

$oUtil = new util();

$filename = $_GET["path"];
$filename = preg_replace("/\.+\/+/", "", $filename);
$filename = preg_replace("/^\/*(arquivo\/)?/", "", $filename);
$filename = dirname(dirname(dirname(__FILE__))) . '/' . $filename;
$name = $_GET["name"];

$oUtil->ForceDownload($filename, $name);
			
?>