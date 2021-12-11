<?php
	include_once("../barrier.php");
	include_once("../../alfa/database/DTO/tnoticia.php");
	include_once("../../alfa/database/DTO/tnoticiacategoria.php");
	include_once("../../alfa/tools/master.php");
	include_once("../../alfa/tools/validacao.php");
	include_once("../../alfa/tools/url.php");
	include_once("../../alfa/tools/fckeditor/fckeditor.php");

	$oUtil = new util();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
form{margin:20px;width:400px}
input[type=text]{width:320px;height:22px;font-size:16px;}
li{margin-bottom:10px}
label{font-size:18px !important;display:block;margin-bottom:5px}
</style>
</head>
<form action="imgupload.php" method="post"  enctype="multipart/form-data">
<ul>
<li><label for="txtFonte">Fonte</label><input type="text" name="txtFonte" id="txtFonte" /></li>
<li><label for="txtDesc">Descri&ccedil;&atilde;o</label><input type="text" name="txtDesc" id="txtDesc" /></li>
<li><label for="txtNome">Nome da Imagem</label><input type="text" name="txtNome" id="txtNome" /></li>
<li><label for="txtAlinhamento">Alinhamento</label>
<select name="txtAlinhamento" id="txtAlinhamento">
<option value="colLeft">Esquerda</option>
<option value="colCenter">Central</option>
<option value="colRight">Direita</option>
</select>
</li>
<li><input type="file" name="txtImg" /></li>
<li><input type="submit" value="Enviar" /></li>
</ul>
</form>
<body>
</body>
</html>

