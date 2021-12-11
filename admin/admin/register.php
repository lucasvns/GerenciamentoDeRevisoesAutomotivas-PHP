<?php
include_once("../barrier.php");
include_once(SERVER_PATH."/alfa/database/DTO/tadmin.php");
include_once(SERVER_PATH."/alfa/database/DTO/tpermission.php");
include_once(SERVER_PATH."/alfa/database/DTO/tpermission_title.php");
include_once(SERVER_PATH."/alfa/database/DTO/tadmin_permission.php");
include_once(SERVER_PATH."/alfa/tools/master.php");
include_once(SERVER_PATH."/alfa/tools/validacao.php");

$oUtil = new util();
$id = isset($_GET['ID'])?$_GET['ID']:'';
$oAdmin = new tadmin();
$IsEditar = $oAdmin->LoadByPrimaryKey($oUtil->Descriptografar($id));

//post
$msg = "";
if($oUtil->VerificaChaveForm($_POST))
{
	//vars
	$oAdmin->name = $_POST["name"];
	$sAdministrador = $oAdmin->name;
	if(!$IsEditar)
	{
		$oAdmin->hash_pass = md5($_POST["hash_pass"]);
	}
	$oAdmin->email = isset($_POST["email"])?$_POST["email"]:'';
	
	$Permissoes = (isset($_POST["cbPermissao"]) && is_array($_POST["cbPermissao"]) ? $_POST["cbPermissao"] : array());

	//verifica ja cadastrado
	function Verifica($v)
	{
		global $sname;
		$oAdminLoad = new tadmin();
		return !($sname != $v && $oAdminLoad->LoadByname($v));
	}

	//validação
	$oValidacao = new validacao();
	$oValidacao->Adicionar("name", $oAdmin->name, true, null, "Preencha o Nome.");
	$oValidacao->Adicionar("email", $oAdmin->email, true, "email", "Preencha o e-mail corretamente.");
	if(!$IsEditar)
	{
		$oValidacao->Adicionar("hash_pass", $oAdmin->hash_pass, true, null, "Preencha a senha.");
		$oValidacao->Adicionar("Confirmacaohash_pass", md5($_POST["txtConfirmacaohash_pass"]), true, "comparar", "Preencha a confirmação de senha corretamente.", $oAdmin->hash_pass);
	}
	if($oValidacao->Validar())
	{
		$allow_save = false;
		if (! $IsEditar)
		{

			//$f = file_get_contents('http://app.wexdigital.com.br/register.php?fn=create&e='.$oAdmin->email.'&p='.$_POST["hash_pass"].'&a=5&u='.$oAdmin->name.'');
			//$f = json_decode($f);
			//if($f->status==200){
			//	$allow_save = true;
			//	$oAdmin->AdminToken = $f->token;
			//	$oAdmin->session_id = $f->token;
			//	$oAdmin->AddNew();
			//}else{
			//	echo $f->msg;
			//	die();
			//}
			$allow_save = true;
			$oAdmin->AddNew();
			$oAdmin->Save();
			$token = md5($oAdmin->id);
			$oAdmin->AdminToken = $token;
			$oAdmin->session_id = $token;
			$oAdmin->date_created = date("Y-m-d H:i:s");
			$oAdmin->last_access = date("Y-m-d H:i:s");
		}else{
			//$f = file_get_contents('http://app.wexdigital.com.br/register.php?fn=update&e='.$oAdmin->email.'&u='.$oAdmin->name.'&p='.$_POST["hash_pass"].'&a=5');
			//$f = json_decode($f);
			//if($f->status==200){
				//$allow_save = true;
			//}
		}
		$oAdmin->Save();

		/**
		 * Permissões
		*/
		//deleta todas as permissoes
		$oAdminPermissaoDel = new tadmin_permission();
		$oAdminPermissaoDel->DeleteBytadmin_id($oAdmin->id);
		
		//permissoes
		foreach($Permissoes as $c => $v)
		{
			$oAdminPermissao = new tadmin_permission();
			$oAdminPermissao->AddNew();
			$oAdminPermissao->tpermission_id = $oAdmin->Descriptografar($v);
			$oAdminPermissao->tadmin_id = $oAdmin->id;
			$oAdminPermissao->Save();
		}
		
		if($oAdmin->name == "papaya")//pixelone
		{
			$oPermissao = new tpermission();
			$oPermissao->LoadByListar(0);
			for($x = 0; $x < $oPermissao->RowsCount; $x++)
			{
				$oAdminPermissao = new tadmin_permission();
				$oAdminPermissao->AddNew();
				$oAdminPermissao->PermissaoID = $oPermissao->id;
				$oAdminPermissao->nameID = $oAdmin->id;
				$oAdminPermissao->Save();
				
				$oPermissao->MoveNext();
			}
		}
		
		//redireciona
		$oUtil->SetMensagem(((!$IsEditar) ? "Cadastrar" : "Editar"));
		header("Location: index.php?" . $_SERVER['QUERY_STRING']);
		exit();
	}
	else
	{
		$msg = $oValidacao->MontaMensagem();
	}
}

$titulo = ($IsEditar)?'Admin. '.$oAdmin->name:'Novo Administrador';

$master_page = new MasterPages();
$master_page->inicio("../master.php", "Administrador");
$master_page->addParametro("titulo", $titulo);
$master_page->addParametro("page_chave", "admin");
$master_page->abrir("page_content");
?>
<div class="card card-default"><!--card-->
<div class="card-header bg-secondary"><!--card-heading-->

<h2 class="card-title">Registro de Usuário</h2>

</div><!--card-heading-->
<div class="card-body"><!--card-body-->
<form class="form inputs" action="<?=htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
<?=$oUtil->GerarChaveForm();?>
<h3 class="card-title">Informações Principais</h3>
<hr />
<div class="form-group"><!--form-group-->
<label class="col-sm-2 control-label">Nome</label>
<div class="col-sm-10"><input class="form-control" id="name" name="name" placeholder="Entre com o nome do administrador" type="text" value="<?=isset($oAdmin->name)?$oAdmin->name:''?>"></div>
</div><!--form-group-->
<div class="form-group"><!--form-group-->
<label class="col-sm-2 control-label">E-mail</label>
<div class="col-sm-10"><input class="form-control" id="email" name="email" placeholder="Entre com o e-mail do administrador" type="text" value="<?=isset($oAdmin->email)?$oAdmin->email:''?>"></div>
</div><!--form-group-->

<?php if(!$IsEditar){ ?>
<?php /*?><div class="form-ln row"><!--ROW-->
<div class="col-md-6">
<label for="hash_pass">Senha:</label>
<input class="form-control" title="Digite a senha." type="password" maxlength="20" size="30" id="hash_pass" name="hash_pass" />
</div>
<div class="col-md-6">
<label for="txtConfirmacaohash_pass">Confirmação de senha:</label>
<input class="form-control" title="Digite a confirmação de senha corretamente." type="password" maxlength="20" size="30" id="txtConfirmacaohash_pass" name="txtConfirmacaohash_pass" />
</div>
</div><!--ROW-->
<?php */?>
<div class="form-group"><!--form-group-->
<label class="col-sm-2 control-label">Senha</label>
<div class="col-sm-10"><input class="form-control" id="hash_pass" name="hash_pass" placeholder="Digite a senha" type="password"></div>
</div><!--form-group-->
<div class="form-group"><!--form-group-->
<label class="col-sm-2 control-label">Confirmação de Senha</label>
<div class="col-sm-10"><input class="form-control" id="txtConfirmacaohash_pass" name="txtConfirmacaohash_pass" placeholder="Digite a confirmação de senha corretamente" type="password"></div>
</div><!--form-group-->
<?php }else{ ?>
<div class="form-group"><!--form-group-->
<div class="col-sm-2"></div>
<div class="col-sm-10"><a href="senha.php?ID=<?=$oUtil->Criptografar($oAdmin->id); ?>" class="btn btn-default btn-sm"><i class="fa fa-key"></i> Alterar Senha</a></div>
</div>
<?php }?>
<hr />

<?php
$oPermissao = new tpermission();
$b = $oPermissao->LoadBytadmin_idAndkeyword($oAdmin->GetSession(), "admin");
if($b || !$IsEditar){
$oPermissaoTitulo = new tpermission_title();
$oPermissaoTitulo->SQL_ORDER = 'position ASC';
if($oPermissaoTitulo->LoadSQL()){
?>
<div class="form-group"><!--form-group-->
<label class="col-sm-2 control-label">Permissões</label>
<div class="col-md-10">
	<?php
	$aux = 0;
	for($f=0;$f<$oPermissaoTitulo->RowsCount;$f++){
		$oPermissao = new tpermission();
		if($oPermissao->LoadBytpermission_title_idAndlist($oPermissaoTitulo->id, 1)){
	?>
		<table class="table table-bordered">
			<tr>
				<th colspan="5"><?=utf8_encode($oPermissaoTitulo->title)?></th>
			</tr>

				<?php
				$bPerm = false;
				for($a=0;$a<$oPermissao->RowsCount;$a++){
					if($_POST){
						$bPerm = in_array($oUtil->Criptografar($oPermissao->id), $Permissoes);
					}
					else{
						$oAdminPermissao  = new tadmin_permission();
						if(isset($oAdmin->id)){
						$bPerm = $oAdminPermissao->LoadByAgencyPersonIDAndPermissionID($oAdmin->id, $oPermissao->id);
						//echo $bPerm.': '.$oAdmin->id.' '.$oPermissao->id.'<br>';
						}
					}
					echo ($aux==0)?'<tr>':'';
				?>
				<td>
					<input <?=($bPerm)?'checked="checked"':''?> value="<?=$oUtil->Criptografar($oPermissao->id)?>" type="checkbox" class="cbPermissao" id="cbPermissao<?=$a;?>" name="cbPermissao[]" />
					<?=$bPerm.': '.utf8_encode($oPermissao->title)?>
				</td>
				<?php 
					echo ($a%4==0 && $a>2)?'</tr>':'';
					$aux=1;
					($a%4==0 && $a>2)?$aux=0:'';
					$oPermissao->MoveNext();
				}
				?>
		</table>
		<?php
		}
		$oPermissaoTitulo->MoveNext();
	}
?>
</div>
</div><!--form-group-->
<?php
}
}
?>
<button class="btn btn-success">Salvar</button>

<a href="index.php" class="btn btn-default">Voltar</a>
</form>
</div><!--card-body-->
</div><!--card-->
<?php
$master_page->fechar("page_content");
$master_page->fim();
?>