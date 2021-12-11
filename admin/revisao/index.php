<?php
include_once("../barrier.php");
include_once("../alfa/tools/master.php");
require_once("../alfa/database/DTO/trevisao.php");
require_once("../alfa/database/DTO/tclientes.php");
require_once("../alfa/database/DTO/tveiculos.php");


$oUtil = new util();

$query = " 1 = 1 ";

$cliente = isset($_GET["cliente"])?$_GET["cliente"]:'';

if($cliente){$query .= " AND (cliente_id = ".$cliente.") ";}

$oRegister2 = new trevisao();
$oRegister2->SQL_WHERE = $query;
$oRegister2->SQL_FN = "Count";
$total = $oRegister2->LoadSQL();

$portela = 100;
$pg = isset($_GET["pg"]) ? intval($_GET["pg"]) : 0;
$pg = ($pg >= ceil($total / $portela)) ? 0 : $pg;
$parametro = "palavra=" . $search;
$paginacao = $oUtil->Paginar("pg", $total, $portela, $parametro);


$oRegister = new trevisao();
$oRegister->SQL_WHERE = $query;
$oRegister->SQL_ORDER = "id DESC";
$oRegister->SQL_INICIO = ($pg * $portela);
$oRegister->SQL_TOTAL = $portela;
$oRegister->LoadSQL();


$master_page = new MasterPages();
$master_page->inicio("../master.php", "Revisão");
$master_page->addParametro("page_chave", "revisao");
$master_page->abrir("page_content");

?>
<?=isset($msg)?$msg:''?>
<?=(isset($_SESSION['msg']) && $_SESSION['msg']!='')?$_SESSION['msg']:''?>
<?php
if(isset($_SESSION['msg']) && $_SESSION['msg']!=''){
	$_SESSION['msg'] = '';
	unset($_SESSION['msg']);
}
?>

<div class="card card-default"><!--card-->
<div class="card-header bg-secondary"><!--card-heading-->

<h2 class="card-title">Revisão</h2>

</div><!--card-heading-->
<div class="card-body"><!--card-body-->

<form method="get" action="?" enctype="multipart/form-data" role="form">
<div class="search-title">
<div class="row">
<div class="col-md-12"><h3><?=$total?> registro<?=($total > 1)?'s':''?> no total</h3></div>
<hr />
<div class="col-md-3">
	<label class="control-label">Selecione o Cliente</label>
	<select name="cliente" id="cliente" class="form-control" >
	<option value=""> Selecione um Cliente </option>
		<?php 

			$oCliente = new tclientes();
			$oCliente->SQL_ORDER = 'nome ASC ';
			$oCliente->LoadSQL();
			if($oCliente->RowsCount){
				for($i=0;$i<$oCliente->RowsCount;$i++){
					$select = "";

					if(isset($_GET['cliente']) && $_GET['cliente'] != ""){
						if($oCliente->id == $_GET['cliente']){
							$select = "selected";
						}
					}

					echo " <option ".$select." value='".$oCliente->id."' >".$oCliente->nome."</option> ";

					$oCliente->MoveNext();
				}
			}

		?>
		
	</select>
</div>



<div class="col-md-12">
<br />
<a href="register.php" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-plus"></i> Adicionar</a>
<button class="btn btn-outline-dark btn-sm"><i class="glyphicon glyphicon-filter"></i> Filtrar</button>
<button class="btn btn-outline-dark btn-sm" onClick="cleanFilters();return false;"><i class="fa fa-eraser"></i> Limpar</button>

</div>

</div>
</div>
</form>

<table class="table table-bordered table-striped">
<thead class="thead-dark">
<tr>
<th>Nome do Cliente </th>
<th>Carro </th>
<th>Data </th>
<th>Horário </th>
<th>Status </th>
<th>Data de Cadastro </th>
<th>Opções</th>
</tr>
</thead>
<?php for($i=0;$i<$oRegister->RowsCount;$i++){

$data = date('d/m/Y H:i:s', $oUtil->DataMostrar($oRegister->date_created));

$nome = "";
$carro = "";

$oVeiculo = new tveiculos();
$oVeiculo->LoadByPrimaryKey($oRegister->veiculo_id);
if($oVeiculo->RowsCount){
	$carro = $oVeiculo->modelo;
}

$oClientes = new tclientes();
$oClientes->LoadByPrimaryKey($oRegister->cliente_id);
if($oClientes->RowsCount){
	$nome = $oClientes->nome;
}


$status = "";

if($oRegister->status==3){
	$status = '<span class="badge badge-success">CONCLUIDO</span>';
}elseif($oRegister->status==2){
	$status = '<span class="badge badge-secondary">EXECUTANDO</span>';
}elseif($oRegister->status==4){
	$status = '<span class="badge badge-danger">CANCELADO</span>';
}elseif($oRegister->status==1){
	$status = '<span class="badge badge-warning">PENDENTE</span>';
}

	// 1 = pendente / 2 = executando / 3 = concluído / 4 = cancelado	}


?>
<tr>
	<td valign="middle"><a href="register.php?id=<?=$oUtil->Criptografar($oRegister->id)?>&<?=$parametro;?>&pg=<?=$pg;?>" class="edit" title="Editar"><?=($nome)?></a></td>
    <td><?=$carro?></td>
    <td><?=$oRegister->data?></td>
    <td><?=$oRegister->horario?></td>
    <td><?=$status?></td>
	<td><?=$data?></td>
	<td valign="middle" align="center" class="edit-tools">
    <a href="register.php?id=<?=$oUtil->Criptografar($oRegister->id)?>&<?=$parametro;?>&pg=<?=$pg;?>" class="btn btn-outline-dark btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
    <a href="remover.php?id=<?=$oUtil->Criptografar($oRegister->id)?>&<?=$parametro;?>&pg=<?=$pg;?>" class="btn btn-outline-dark btn-sm" title="Excluir" onclick="javascript:return confirm('Deseja realmente excluir?')"><i class="far fa-trash-alt"></i></a>
	</td>
</tr>
<?php $oRegister->MoveNext();}?>
</table>
<?=$paginacao;?>
</div><!--card-body-->
</div><!--card-->


<?php
$master_page->fechar("page_content");
$master_page->fim();
?>