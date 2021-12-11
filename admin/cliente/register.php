<?php
include_once("../barrier.php");
include_once("../alfa/tools/master.php");
include_once("../alfa/tools/validacao.php");
include_once("../alfa/tools/url.php");
require_once("../alfa/database/DTO/tclientes.php");

date_default_timezone_set('America/Sao_Paulo');

$oUtil = new util();
$id = isset($_GET['id'])?$_GET['id']:'';

$oRegister = new tclientes();
$IsEditar = $oRegister->LoadByPrimaryKey($oUtil->Descriptografar($id));

//post
$msg = "";
if($oUtil->VerificaChaveForm($_POST))
{

	$oRegister->nome = $_POST["nome"];
	$oRegister->telefone = preg_replace("/[^0-9]/", "", $_POST["telefone"]);
	$oRegister->endereco = $_POST["endereco"];
	$oRegister->cpf = preg_replace("/[^0-9]/", "", $_POST["cpf"]);
	
	//validação
	$oValidacao = new validacao();
	$oValidacao->Adicionar("nome", $oRegister->nome, true, null, "Digite o Nome do Beneficio.");
	$oValidacao->Adicionar("telefone", $oRegister->telefone, true, null, "Digite o Telefone.");
	$oValidacao->Adicionar("cpf", $oRegister->cpf, true, null, "Digite o CPF.");


	if($IsEditar){$query = ' id!= '.$oRegister->id.' AND ';}
	else{$query = '';}

	if($oRegister->cand_cpf!=''){
		//verifica se o cpf ja existe
		$oVerifi = new tclientes();
		$oVerifi->SQL_WHERE = $query.' cpf = "'.$oRegister->cpf.'"';
		$oVerifi->LoadSQL();
		if($oVerifi->RowsCount){
			//se ja existir adiciona a mensagem
			$oValidacao->Adicionar("cpf","", true, null, "CPF já cadastrado");
		}
		//valida cpf
		if($oUtil->validaCPF($oRegister->cand_cpf)==false){
			$oValidacao->Adicionar("cpfx", "", true, null, "CPF inválido");
		}
	}
	
	
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
$master_page->inicio("../master.php", "Registro de Clientes");
$master_page->addParametro("page_chave", "cliente");
$master_page->abrir("page_content");

?>
<?=$msg;?>

	<form class="form inputs" action="<?=htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post" enctype="multipart/form-data">
		<?=$oUtil->GerarChaveForm();?>
		<div class="card card-default"><!--card-->
			<div class="card-header bg-secondary"><!--card-heading-->
				<h2>Registro de Clientes</h2>
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
							<label class="control-label">Nome do Cliente</label>
							<input type="text" name="nome" class="form-control" value="<?=($IsEditar)?html_entity_decode($oRegister->nome):((isset($_POST["nome"]))?$_POST["nome"]:'');?>">
						</div><!--form-group-->

						<div class="form-group"><!--form-group-->
							<label class="control-label">Telefone do Cliente</label>
							<input type="text" name="telefone" class="form-control tel" value="<?=($IsEditar)?html_entity_decode($oRegister->telefone):((isset($_POST["telefone"]))?$_POST["telefone"]:'');?>">
						</div><!--form-group-->

						<div class="form-group"><!--form-group-->
							<label class="control-label">CPF do Cliente</label>
							<input type="text" name="cpf" class="form-control cpf" value="<?=($IsEditar)?html_entity_decode($oRegister->cpf):((isset($_POST["cpf"]))?$_POST["cpf"]:'');?>">
						</div><!--form-group-->

						<div class="form-group"><!--form-group-->
							<label class="control-label">Endereço</label>
							<textarea name="endereco" class="form-control" rows="5"><?=($IsEditar)?html_entity_decode($oRegister->endereco):((isset($_POST["endereco"]))?$_POST["endereco"]:'');?></textarea>
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


	<?php if($IsEditar){?>

	<div class="card-body">
		<div class="card-header bg-secondary">
            <h2>Veiculos</h2>
        </div>
		<div class="row">
			<div class="col-md-12">
				<table id="VeiculosTable" class="table table-bordered table-striped">
				<thead class="thead-dark">
					<tr>
						<th>Modelo</th>
						<th>Placa</th>
						<th>Ano</th>
						<th>Valor</th>
						<th>Opções</th>
					</tr>
				</thead>
				<tbody>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				</tbody>
				</table>
				<span id="btnModalVeiculos" class="btn btn-primary btn-sm" data-toggle="modal"
                        data-target="#modalVeiculo"><i class="fad fa-plus"></i> Adicionar</span>
			</div>
		</div>

	</div>

	<?php }?>



	<!-- Modal-->
	<div class="modal fade" id="modalVeiculo" tabindex="-1" role="dialog" aria-labelledby="modalDataLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body">
					<div class="col-md-12">

						<div class="form-group"> 
							<label class="control-label">Número da Placa</label>
								<input type="text" name="numero_placa" id="numero_placa" class="form-control" >
						</div>

						<div class="form-group">
							<label class="control-label">Modelo </label>
							<input type="text" name="modelo" id="modelo" class="form-control" >
						</div>

						<div class="form-group">
							<label class="control-label">Ano de fabricação </label>
							<input type="text" name="ano_fabricacao" id="ano_fabricacao" class="form-control" >
						</div>

						<div class="form-group">
							<label class="control-label">Valor </label>
							<input type="text" name="valor" id="valor" class="form-control money" >
						</div>

					</div>
					
					<div class="alert-wrapper"></div>
					<div class="response-wrapper"></div>

				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="setVeiculo()">Salvar</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>        
				</div>
			</div>
		</div>
	</div>


	<script>
		
		var getVeiculo = function(_cliente = <?=isset($oRegister->id)?$oRegister->id:0?>){
			var data = {
				cliente: _cliente,
			}

			$('#VeiculosTable tbody').html('<tr><td colspan="2" style="text-align: center;"><div class="spinner-grow" role="status"><span class="sr-only">Loading...</span></div></td></tr>');
			
			$("#modalLoading").modal('show');
			$.post("../../api/?fn=getVeiculo",data).done(function(result) {
				var html = '';
				if (result.status==200) {
					result.veiculos.forEach(element => {																																																																																																																																																																													    			 																			
						html += '<tr><td>' + element.modelo + '</td><td>' + element.numero_placa +
							'</td><td>' + element.ano_fabricacao + '</td><td>' + element.valor +
							'</td><td><span class="btn btn-outline-dark btn-sm" title="Remover" onclick="removeVeiculo(' +
							element.id + ')""><i class="fas fa-trash"></i></span></td></tr>';
					});                              
				} else {
					html = '<tr><td colspan="5" style="text-align: center;"><div class="alert alert-light">Nenhum veiculo encontrado </p></div></td>/tr>';
				}
				$('#VeiculosTable tbody').html(html);
			});

		}


		var setVeiculo = function(_cliente = <?=isset($oRegister->id)?$oRegister->id:0?>) {
			var data = {
				cliente_id: _cliente,
				valor: $('[name="valor"]').val(),
				ano_fabricacao: $('[name="ano_fabricacao"]').val(),
				numero_placa :  $('[name="numero_placa"]').val(),
				modelo :  $('[name="modelo"]').val(),
			}
			
			$.post("../../api/?fn=setVeiculo", data).done(function(result) {
				if (result.status == 200) {

					$('#modalVeiculo .alert-wrapper').html('<div class="alert alert-success">' + result.msg +'</div>');

					getVeiculo();
					setTimeout(function() {
						$('#modalVeiculo').modal('hide');
						$('[name="valor"]').val('');
						$('[name="ano_fabricacao"]').val('');
						$('[name="numero_placa"]').val('');
						$('[name="modelo"]').val('');
						$('#modalVeiculo .alert-wrapper').html('');
					}, 1000);
				} else {
					$('#modalVeiculo .alert-wrapper').html('<div class="alert alert-danger">' + result.msg +
						'</div>');
				}

			});
		}


		var removeVeiculo = function(_id) {
			var confirmado = confirm('Deseja realmente excluir este veiculo?');
				if(confirmado){
					var data = {
					id: _id
				}
				$('#VeiculosTable tbody').html('');
				$.post("../../api/?fn=removeVeiculo", data).done(function(result) {
					if (result.status == 200) {
						getVeiculo();
					}
				});
			}	 
		}  

		getVeiculo(<?=($IsEditar)?($oRegister->id):''?>);

	</script>



<?php
$master_page->fechar("page_content");
$master_page->fim();
?>