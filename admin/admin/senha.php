<?php
	include_once("../barrier.php");
	include_once("../alfa/tools/master.php");
	include_once("../alfa/tools/validacao.php");
	include_once("../alfa/database/DTO/tadmin.php");
	
	$oUtil = new util();
	
	$oAdmin = new tadmin();
	if(!$oAdmin->LoadByPrimaryKey($oUtil->Descriptografar($_GET['ID'])))
	{
		header("Location: index.php?" . $_SERVER['QUERY_STRING']);
		exit();
	}
	
	//post
	$msg = "";
	if($oUtil->VerificaChaveForm($_POST))
	{
		//vars
		$sSenha = ($oAdmin->hash_pass);
		$txtSenhaAntiga = md5($_POST["txtSenhaAntiga"]);
		$txtNovaSenha = $_POST["txtNovaSenha"];
		$txtConfirmacaoSenha = $_POST["txtConfirmacaoSenha"];
		
		/*//verifica senha
		function Verifica($v)
		{
			global $sSenha;
			echo $sSenha.'  '.$v;
			die();
			return !($v != $sSenha);
		}*/
		
		//validação
		$oValidacao = new validacao();
		$oValidacao->Adicionar("SenhaAntiga", $txtSenhaAntiga, true, "funcao", "Digite a senha antiga corretamente.");
		$oValidacao->Adicionar("NovaSenha", $txtNovaSenha, true, null, "Digite a nova senha.");
		$oValidacao->Adicionar("ConfirmacaoSenha", $txtConfirmacaoSenha, true, "comparar", "Digite a confirmação de senha corretamente.", $txtNovaSenha);
		if($oValidacao->Validar())
		{
			$oAdmin->hash_pass = md5($txtNovaSenha);
			$oAdmin->Save();
			$f = file_get_contents('http://app.wexdigital.com.br/register.php?fn=password&e='.$oAdmin->email.'&u='.$oAdmin->name.'&a=1&p='.$txtNovaSenha);

			//redireciona
			$oUtil->SetMensagem("Editar");
			header("Location: index.php?" . $_SERVER['QUERY_STRING']);
			exit();
		}
		else
		{
			$msg = $oValidacao->MontaMensagem();
		}
	}
	
	$master_page = new MasterPages();
	$master_page->inicio("../master.php", "Usuários");
	$master_page->abrir("page_content");
?>
<?=$msg;?>
<div class="row">

<div class="col-md-6">

<div class="card">
	<div class="card-header bg-secondary"><h2>Senha - <?=$oAdmin->name;?></h2></div>
	<div class="card-body">

		<div class="alert alert-info"><p>Para prosseguir com o cadastro, apenas preencha corretamente os campos abaixo:</p></div>
		<form class="form" action="?<?=$_SERVER['QUERY_STRING'];?>" method="post" enctype="multipart/form-data">
			<?=$oUtil->GerarChaveForm();?>
			<div class="form-group">
				<label class="control-label">Senha antiga:</label>
				<input class="form-control small-input" title="Digite a senha antiga corretamente." type="password" maxlength="20" size="30" id="txtSenhaAntiga" name="txtSenhaAntiga" />
			</div>
			<div class="form-group">
				<label class="control-label">Nova senha:</label></label></td>
				<input class="form-control small-input" title="Digite a nova senha."  type="password" maxlength="20" size="30" id="txtNovaSenha" name="txtNovaSenha" />
			</div>
			<div class="form-group">
				<label for="txtConfirmacaoSenha" class="control-label">Confirmação de senha:</label>
				<input class="form-control small-input" title="Digite a confirmação de senha corretamente." type="password" maxlength="20" size="30" id="txtConfirmacaoSenha" name="txtConfirmacaoSenha" />
			</div>
			<input type="submit" alt="Gravar" value="Gravar" title="Gravar" class="btn btn-success" />
			<a href="index.php?<?=$_SERVER['QUERY_STRING'];?>" class="btn btn-secondary">Cancelar</a>
		</form>

	</div>
</div>

</div>

</div>
<?php
    $master_page->fechar("page_content");
	$master_page->fim();
?>