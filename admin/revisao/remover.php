<?php
include_once("../barrier.php");
require_once("../alfa/database/DTO/trevisao.php");

$oUtil = new util();

$oRegister = new trevisao();
if ($oRegister->LoadByPrimaryKey($oUtil->Descriptografar($_GET['id'])))
{
    $oRegister->MarkAsDelete();
    $oRegister->Save();

    $oUtil->SetMensagem("Remover");
}

header("Location: index.php?" . $_SERVER['QUERY_STRING']);