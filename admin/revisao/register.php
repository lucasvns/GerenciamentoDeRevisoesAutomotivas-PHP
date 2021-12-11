<?php
include_once("../barrier.php");
include_once("../alfa/tools/master.php");
include_once("../alfa/tools/validacao.php");
include_once("../alfa/tools/url.php");
require_once("../alfa/database/DTO/trevisao.php");
require_once("../alfa/database/DTO/tclientes.php");
require_once("../alfa/database/DTO/tveiculos.php");



date_default_timezone_set('America/Sao_Paulo');

$oUtil = new util();
$id = isset($_GET['id'])?$_GET['id']:'';

$oRegister = new trevisao();
$IsEditar = $oRegister->LoadByPrimaryKey($oUtil->Descriptografar($id));

//post
$msg = "";
if($oUtil->VerificaChaveForm($_POST))
{

	$oRegister->veiculo_id = $_POST["veiculo_id"];
	$oRegister->cliente_id = $_POST["cliente"];
	$oRegister->data = $_POST["data"];
	$oRegister->horario = $_POST["horario"];
	$oRegister->status = $_POST["status"];
	$oRegister->servicos = $_POST["servicos"];
	 
	
	//validação
	$oValidacao = new validacao();
	$oValidacao->Adicionar("veiculo_id", $oRegister->veiculo_id, true, null, "Selecione o Veiculo.");
	$oValidacao->Adicionar("cliente_id", $oRegister->cliente_id, true, null, "Selecione o Cliente.");
	$oValidacao->Adicionar("data", $oRegister->data, true, null, "Digite a Data.");
	$oValidacao->Adicionar("horario", $oRegister->horario, true, null, "Digite o Horário.");
	$oValidacao->Adicionar("status", $oRegister->status, true, null, "Selecione o Status.");
	$oValidacao->Adicionar("servicos", $oRegister->servicos, true, null, "Digite os Serviços.");
	
	
	if($oValidacao->Validar())
	{
		if (! $IsEditar)
		{
			$oRegister->date_created = date('Y-m-d H:i:s');
			$oRegister->AddNew();
		}
		
		//$oRegister->Imagem = (($oUpload->ValidarTemporario()) ? $oUpload->Salvar("banner") : $oRegister->Imagem);
		$oRegister->Save();

		$_SESSION['msg'] = '<div class="alert alert-success"><p>Registro na Timeline salva com sucesso!</p></div>';

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

$master_page = new MasterPages();
$master_page->inicio("../master.php", "Registro de Revisão");
$master_page->addParametro("page_chave", "revisao");
$master_page->abrir("page_content");

?>
<?=$msg;?>

	<form class="form inputs" action="<?=htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
		<?=$oUtil->GerarChaveForm();?>
		<div class="card card-default"><!--card-->
			<div class="card-header bg-secondary"><!--card-heading-->
				<h2>Registro de Revisão</h2>
			</div><!--card-heading-->

			<div class="card-body"><!--card-body-->

				<div class="row"><!--row-->
					<div class="col-md-12"><!--col-md-6-->

						
						
						<?php if($IsEditar){?>
							<div class="form-group"><!--form-group-->
								<label class="control-label">Data do Cadastro</label>
								<div class=""><div class="copy-field"><p><?=($IsEditar)?date('d/m/Y H:i:s', $oUtil->DataMostrar($oRegister->date_created)):''?></p></div></div>
							</div><!--form-group-->
						<?php }?>
						

						<div class="form-group"><!--form-group-->
							<label class="control-label">Selecione o Cliente</label>
							<select name="cliente" id="cliente" class="form-control">
								<option value="">Selecione</option>
								<?php 
									$oClientes = new tclientes();
									$oClientes->SQL_ORDER = 'nome ASC ';
									$oClientes->LoadSQL();
									if($oClientes->RowsCount){
										for($i=0;$i<$oClientes->RowsCount;$i++){
											$select = "";

											if($IsEditar){
												if($oClientes->id == $oRegister->cliente_id){
													$select = "selected";
												}												
											}

											echo " <option ".$select." value='".$oClientes->id."' >".$oClientes->nome."</option> ";

											$oClientes->MoveNext();
										}
									}
								?>

							</select>
						</div><!--form-group-->


						<div class="form-group"><!--form-group-->
							<label class="control-label">Selecione o Veiculo</label>
							<select name="veiculo_id" id="veiculo" class="form-control" >

							<?php 
								if($IsEditar){

									$oVeiculos = new tveiculos();
									$oVeiculos->SQL_ORDER = 'modelo ASC ';
									$oVeiculos->LoadSQL();
									if($oVeiculos->RowsCount){
										for($i=0;$i<$oVeiculos->RowsCount;$i++){
											$select = "";
												
												if($oVeiculos->id == $oRegister->veiculo_id){
													$select = "selected";
												}

											echo " <option ".$select." value='".$oVeiculos->id."' >".$oVeiculos->modelo."</option> ";

											$oVeiculos->MoveNext();
										}
									}

								}else{
									echo ' <option value=""> Selecione um Cliente </option> ';
								}

								?>
								
							</select>

						</div> 

						<div class="form-group"><!--form-group-->
							<label class="control-label">Status</label>
							<select name="status" id="status" class="form-control">
								<option value="" > Selecione </option>
								<option value="1"  <?=($IsEditar && $oRegister->status=='1')?'selected':'';?>  > pendente </option>
								<option value="2"  <?=($IsEditar && $oRegister->status=='2')?'selected':'';?>  > executando </option>
								<option value="3"  <?=($IsEditar && $oRegister->status=='3')?'selected':'';?>  > concluído </option>
								<option value="4"  <?=($IsEditar && $oRegister->status=='4')?'selected':'';?>  > cancelado </option>
							</select>
						</div>

						<div class="form-group"><!--form-group-->
							<label class="control-label">Digite a data </label>
							<input type="text" name="data" class="form-control date" value="<?=($IsEditar)?html_entity_decode($oRegister->data):((isset($_POST["data"]))?$_POST["data"]:'');?>">
						</div><!--form-group-->

						<div class="form-group"><!--form-group-->
							<label class="control-label">Digite o Horário</label>
							<input type="text" name="horario" class="form-control time" value="<?=($IsEditar)?html_entity_decode($oRegister->horario):((isset($_POST["horario"]))?$_POST["horario"]:'');?>">
						</div><!--form-group-->

						<div class="form-group"><!--form-group-->
							<label class="control-label">Serviços</label>
							<textarea name="servicos" class="form-control" rows="5"><?=($IsEditar)?html_entity_decode($oRegister->servicos):((isset($_POST["servicos"]))?$_POST["servicos"]:'');?></textarea>
						</div><!--form-group-->


					</div>

				</div><!--card-body-->

				<div class="card-footer">
					<button class="btn btn-success"><i class="fad fa-check"></i> Salvar</button>
					<a href="index.php" class="btn btn-secondary"><i class="fad fa-arrow-left"></i> Voltar</a>
				</div>

			</div><!--card-->
		
		</div><!--card default-->

	</form>


	<script>	

		$( "#cliente" ).change(function() {

			$( "#veiculo" ).find('option')
					.remove()
					.end()
					.append('<option value="">Aguarde</option>')
					.val('');

				var data = {
					cliente_id: $("#cliente").val()
				}

				jQuery.post("../../api/?fn=getVeiculo", data).done(function( result ) {

					if(result.status==200){

						$( "#veiculo" ).find('option')
						.remove()
						.end()
						.append('<option value="">Selecione</option>')
						.val('');

						result.veiculos.forEach(element => {	
							$( "#veiculo" ).append('<option value="'+element.id+'">'+element.modelo+'</option>');
						});

					}else if(result.status==400){
						$( "#veiculo" ).find('option')
						.remove()
						.end()
						.append('<option value="">Nenhum Encontrado</option>')
						.val('');
					}
			});
		});

	</script>


<?php
$master_page->fechar("page_content");
$master_page->fim();
?>