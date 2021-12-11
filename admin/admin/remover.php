<?php
include_once("../barrier.php");
include_once(SERVER_PATH."/alfa/database/DTO/tadmin.php");
include_once(SERVER_PATH."/alfa/database/DTO/tadmin_permission.php");

$oUtil = new util();

$oAdmin = new tadmin();
if ($oAdmin->LoadByPrimaryKey($oUtil->Descriptografar($_GET['ID'])))
{
	if($oAdmin->id != 13){
		$oAdminPermissao = new tadmin_permission();
		$oAdminPermissao->DeleteBytadmin_id($oAdmin->id);
		$oAdmin->MarkAsDelete();
		$oAdmin->Save();
		$oUtil->SetMensagem("Remover");
	}
}

header("Location: index.php?" . $_SERVER['QUERY_STRING']);
?>