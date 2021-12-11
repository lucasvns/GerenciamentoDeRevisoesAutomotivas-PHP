<?php
include_once("../barrier.php");
include_once("../alfa/tools/master.php");
require_once("../alfa/database/DTO/tclientes.php");


$oUtil = new util();

$query = " 1 = 1 ";

$search = isset($_GET["search"])?$_GET["search"]:'';

if($search){$query .= " AND (nome like '%" . $search . "%') ";}

$oRegister2 = new tclientes();
$oRegister2->SQL_WHERE = $query;
$oRegister2->SQL_FN = "Count";
$total = $oRegister2->LoadSQL();

$portela = 100;
$pg = isset($_GET["pg"]) ? intval($_GET["pg"]) : 0;
$pg = ($pg >= ceil($total / $portela)) ? 0 : $pg;
$parametro = "palavra=" . $search;
$paginacao = $oUtil->Paginar("pg", $total, $portela, $parametro);


$oRegister = new tclientes();
$oRegister->SQL_WHERE = $query;
$oRegister->SQL_ORDER = "id DESC";
$oRegister->SQL_INICIO = ($pg * $portela);
$oRegister->SQL_TOTAL = $portela;
$oRegister->LoadSQL();


$master_page = new MasterPages();
$master_page->inicio("../master.php", "Clientes");
$master_page->addParametro("page_chave", "Cliente");
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

<h2 class="card-title">Clientes</h2>

</div><!--card-heading-->
<div class="card-body"><!--card-body-->

<form method="get" action="?" enctype="multipart/form-data" role="form">
<div class="search-title">
<div class="row">
<div class="col-md-12"><h3><?=$total?> registro<?=($total > 1)?'s':''?> no total</h3></div>
<hr />
<div class="col-md-3">
<label class="control-label">Pesquise por Nome</label>
<input size="60" value="<?=$search?>" type="text" id="search" name="search" maxlength="150" placeholder="Buscar" class="form-control" />
</div>



<!--
<div class="col-md-3">
<label style="width: 100px;display:inline-block;">De: <input type="text" name="date1" class="form-control datepicker2" placeholder="Data Inicial" value="<?=(isset($_GET['date1']) && $_GET['date1']!='')?$_GET['date1']:''?>"></label>
<label style="width: 100px;display:inline-block;">Até: <input type="text" name="date2" class="form-control datepicker2" placeholder="Data Final" value="<?=(isset($_GET['date2']) && $_GET['date2']!='')?$_GET['date2']:''?>"></label>
</div>
-->

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
<th>Nome </th>
<th>CPF </th>
<th>Telefone </th>
<th>Data de Cadastro </th>
<th>Opções</th>
</tr>
</thead>
<?php for($i=0;$i<$oRegister->RowsCount;$i++){

$data = date('d/m/Y H:i:s', $oUtil->DataMostrar($oRegister->date_created));

?>
<tr>
	<td valign="middle"><a href="register.php?id=<?=$oUtil->Criptografar($oRegister->id)?>&<?=$parametro;?>&pg=<?=$pg;?>" class="edit" title="Editar"><?=($oRegister->nome)?></a></td>
    <td><?=$oRegister->cpf?></td>
    <td><?=$oRegister->telefone?></td>
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