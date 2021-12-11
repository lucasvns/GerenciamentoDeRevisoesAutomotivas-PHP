<?php
include_once("../barrier.php");
include_once("/var/www/system.drodonto.com.br/alfa/tools/master.php");
include_once("/var/www/system.drodonto.com.br/alfa/tools/validacao.php");
include_once("/var/www/system.drodonto.com.br/alfa/tools/url.php");
include_once("/var/www/system.drodonto.com.br/alfa/database/DTO/tparameter.php");

$oUtil = new util();

$news_to = $oParametro->getParametro('news_to');
$news_expiration_days = $oParametro->getParametro('news_expiration_days');
$ad_interval = $oParametro->getParametro('ad_interval');

//post
$msg = "";
if($oUtil->VerificaChaveForm($_POST))
{
	//vars
	$news_to = trim($_POST["news_to"]);
	$news_expiration_days = trim($_POST["news_expiration_days"]);
	$ad_interval = trim($_POST["ad_interval"]);
	//validação
	$oValidacao = new validacao();

	if($oValidacao->Validar())
	{
		$oParametro->setParametro('news_to', $news_to);
		$oParametro->setParametro('news_expiration_days', $news_expiration_days);
		$oParametro->setParametro('ad_interval', $ad_interval);
		
		$_SESSION['msg'] = '<div class="alert alert-success"><p>Registro realizado com sucesso!</p></div>';
		//redireciona
		$oUtil->SetMensagem(((! $IsEditar) ? "Cadastrar" : "Editar"));
		header("Location: index.php");
		exit();
	}
	else
	{
		$msg = $oValidacao->MontaMensagem();
	}
}

$master_page = new MasterPage();
$master_page->inicio("../master.php", "Parâmetros");
$master_page->addParametro("page_chave", "params");
$master_page->abrir("page_content");
?>
<?=$msg;?>
<div class="panel panel-default"><!--panel-->
<div class="panel-heading"><!--panel-heading-->

<div class="row">
<div class="col-md-6"><h2 class="panel-title">Parâmetros</h2></div>
</div>

</div><!--panel-heading-->
<div class="panel-body"><!--panel-body-->
<form class="form inputs" action="<?=htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
<?=$oUtil->GerarChaveForm();?>

<h3 class="panel-title">Informações Principais</h3>
<hr />

<div class="form-group"><!--form-group-->
<label class="control-label">E-mail [Notícia Recebida]<small>Separar e-mails por vírgula</small></label>
<input class="form-control" id="news_to" name="news_to" type="email" value="<?=isset($news_to)?$news_to:''?>">
</div><!--form-group-->

<div class="form-group"><!--form-group-->
<label class="control-label">Dias Expiração de Notícia Recebida<small>0 = não são excluídas</small></label>
<input class="form-control" id="news_expiration_days" name="news_expiration_days" type="number" value="<?=isset($news_expiration_days)?$news_expiration_days:''?>">
</div><!--form-group-->

<div class="form-group"><!--form-group-->
<label class="control-label">Anúncios na Timeline<small>intervalo de repetições</small></label>
<input class="form-control" id="ad_interval" name="ad_interval" type="number" value="<?=isset($ad_interval)?$ad_interval:''?>">
</div><!--form-group-->

<button class="btn btn-success">Salvar</button>

</form>
</div><!--panel-body-->
</div><!--panel-->
<?php
$master_page->fechar("page_content");
$master_page->fim();
?>