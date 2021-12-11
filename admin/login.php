<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: text/html;  charset=ISO-8859-1", true);
include_once("alfa/database/DTO/tparameter.php");
include_once("alfa/database/DTO/tadmin.php");

$bAcesso = true;

$oUtil = new util();
$oParametro = new tparameter();
$sitetitle = $oParametro->getParametro('Sitetitle');

if ($_POST){
	if (isset($_POST["checkLembrar"]) == "1"){
		setcookie("AdminUsuario", $_POST["textLogin"], time() + 3600000);
		setcookie("AdminSalvar", "true", time() + 3600000);
	}
	$oUsuario = new tadmin();
	$oUsuario->email = $_POST["qLogin"];
	$oUsuario->hash_pass = md5($_POST["qPass"]);
//	echo $oUsuario->email.' '.$oUsuario->hash_pass;
	$bAcesso = $oUsuario->Acesso();
	if($bAcesso){
		$oUsuario->SetSession();
		$oUsuario->UltimoAcesso = date("Y-m-d H:i:s");
		$oUsuario->Save();
		$_SESSION['token'] = $oUsuario->AdminToken;
		header("Location: " . (($_GET["u"]) ? urldecode($_GET["u"]) : "index.php"));
		exit();
	}else{
		$msg = '<div class="alert alert-warning" style="width:100%;position:absolute;z-index:100;text-align:center;font-size:16px !important;border-radius:0px">Login ou Senha inv&aacute;lidos.</div>';		
	}
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Painel Administrativo | <?=$sitetitle?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="src/img/ico_lock.ico" />
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,300,700,800" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="assets/lib/bootstrap/dist/css/bootstrap.css" />
<style type="text/css">html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{border:0;font:inherit;margin:0;padding:0;vertical-align:baseline}article,aside,details,figcaption,figure,footer,header,hgroup,menu,nav,section{display:block}body{line-height:1}ol,ul{list-style:none}blockquote,q{quotes:none}blockquote:before,blockquote:after,q:before,q:after{content:none}table{border-collapse:collapse;border-spacing:0}html,body{height:100%;position:relative;width:100%;padding:0 !important;margin:0 !important}
*{font:12px 'Open Sans', Arial, Helvetica, sans-serif !important;font-weight:300 !important}
</style>
</head>

<body id="login">
<?=(isset($msg))?$msg:'';?>

<div class="table-wrapper">
<div class="table-cell-wrapper">
<div class="container">

<div class="card">
<div class="card-body">

<form method="post" action="" class="formulario">
	<div class="row">
	<div class="col-md-6">
		<label>Login:</label><input type="text" name="qLogin" class="form-control">
	</div>
	<div class="col-md-6">
		<label>Senha:</label><input type="password" name="qPass" class="form-control">
	</div>
	</div>
	<hr />
	<input type="submit" class="btn btn-primary btn-block" value="Entrar">
</form>

</div>
</div>

</div>
</div>
</div>
<style>
.table-wrapper label{font-weight: 700;}
.table-wrapper{display: table;width: 100%;height: 100vh;}
.table-wrapper .table-cell-wrapper{display: table-cell;vertical-align: middle;}
.table-wrapper .table-cell-wrapper .card{max-width: 600px;margin: 0 auto;}
</style>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>