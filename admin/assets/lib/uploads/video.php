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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Meu - Soluções em Internet</title>
<link rel="stylesheet" href="<?=$pathAdmin?>css/layout.css" type="text/css" media="screen">
</head>
<style type="text/css">
form{margin:20px;width:400px}
input[type=text]{width:320px;height:22px;font-size:16px;}
li{margin-bottom:10px}
label{font-size:18px !important;display:block;margin-bottom:5px}
</style>
<body>
<form action="" method="post"  enctype="multipart/form-data">
<ul>
<li><label for="txtEnd">Endereço</label><input type="text" name="txtEnd" id="txtEnd" /></li>
<li><label for="txtFonte">Fonte</label><input type="text" name="txtFonte" id="txtFonte" /></li>
<li><label for="txtDesc">Descri&ccedil;&atilde;o</label><input type="text" name="txtDesc" id="txtDesc" /></li>
<li><label for="txtAlinhamento">Alinhamento</label>
<select name="txtAlinhamento" id="txtAlinhamento">
<option value="colLeft">Esquerda</option>
<option value="colCenter">Central</option>
<option value="colRight">Direita</option>
</select>
</li>
<li><input type="submit" value="Enviar" /></li>
</ul>
</form>

<textarea name="" id="" cols="30" rows="10">
<?php
if($_POST['txtEnd']){
	$url = $_POST['txtEnd'];
	$fonte = $_POST['txtFonte'];
	$desc = $_POST['txtDesc'];
	$alin = $_POST['txtAlinhamento'];

echo '
<table class="imgBox '.$alin.'"><tr><td class="imgBoxLat"></td><td><div class="imgBoxCont"><table><tr><td class="imgBoxInfo">'.$fonte.'</td></tr><tr><td><div id="player"></div></td></tr><tr><td class="descImg imgBoxInfo">'.$desc.'</td></tr></table></div></td><td class="imgBoxLat"></td></tr></table>

<script type="text/javascript">
$(document).ready(function(){
	$("#player").youTubeEmbed("'.$url.'");
});
</script>';
}?>
</textarea>
</body>
</html>