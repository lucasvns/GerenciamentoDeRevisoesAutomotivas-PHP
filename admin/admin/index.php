<?php
include_once("../barrier.php");
include_once(SERVER_PATH."/alfa/tools/master.php");
include_once(SERVER_PATH."/alfa/database/DTO/tadmin.php");

$oUtil = new util();
$search = '';

$query = " 1=1 ";
$busca = '';
if($_GET){
	$busca = (isset($_GET["query"]) && $_GET["query"]!='')?$_GET["query"]:'';
	if($busca){
		$search = $busca;
		$query .= " AND name like '%" . $busca . "%' OR email like '%" . $busca . "%'";
	}
}

$oAdmin2 = new tadmin();
$oAdmin2->SQL_WHERE = $query;
$oAdmin2->SQL_FN = "Count";
$total = $oAdmin2->LoadSQL();

$portela = 200;
if($_GET){
	$pg = isset($_GET["pg"]) ? intval($_GET["pg"]) : 0;
}else{
	$pg = 0;
}
$pg = ($pg >= ceil($total / $portela)) ? 0 : $pg;
$parametro = "busca=" . $busca;
$paginacao = $oUtil->Paginar("pg", $total, $portela, $parametro);

$oAdmin = new tadmin();
$oAdmin->SQL_WHERE = $query;
$oAdmin->SQL_ORDER = "name ASC";
$oAdmin->SQL_INICIO = ($pg * $portela);
$oAdmin->SQL_TOTAL = $portela;
$oAdmin->LoadSQL();

$master_page = new MasterPages();
$master_page->inicio("../master.php");
$master_page->addParametro("titulo", "Administradores");
$master_page->addParametro("page_chave", "admin");
$master_page->abrir("page_content");
?>
<div class="card card-default"><!--card-->
<div class="card-header bg-secondary"><!--card-heading-->
<h2 class="card-title">Usuários do Sistema</h2>
</div><!--card-heading-->
<div class="card-body"><!--card-body-->


<?php if($total > 0){ ?>

<div class="search-title">
<div class="row">
<div class="col-md-12"><h3><?=$total?> registro<?=($total > 1)?'s':''?> no total</h3></div>
<hr />
<div class="col-md-3">
<label>Pesquise por (Usuário, E-mail)
<input size="60" value="<?=$search?>" type="text" id="search" name="search" maxlength="150" placeholder="Buscar" class="form-control" />
</label>
</div>
<div class="col-md-12">
<br />
<a href="register.php" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-plus"></i> Adicionar</a>
<button class="btn btn-outline-dark btn-sm"><i class="glyphicon glyphicon-filter"></i> Filtrar</button>
<button class="btn btn-outline-dark btn-sm" onClick="cleanFilters();return false;"><i class="fa fa-eraser"></i> Limpar</button>

</div>

</div>
</div>

<table class="table table-bordered table-striped">
<tbody>
<thead>
<tr>
	<th>Usuário</th>
    <th>E-mail</th>
    <th>Opções</th>
</tr>
</thead>
<?php
for($i=0;$i<$oAdmin->RowsCount;$i++){

?>
<tr>
	<td><?=$oAdmin->name;?></td>
	<td><?=$oAdmin->email;?></td>
	<td valign="middle" align="center" class="edit-tools">
		<a href="register.php?ID=<?=$oUtil->Criptografar($oAdmin->id)?>&<?=$parametro;?>&pg=<?=$pg;?>" class="btn btn-default btn-sm" title="Editar"><i class="fas fa-edit"></i></a>
		<a href="remover.php?ID=<?=$oUtil->Criptografar($oAdmin->id)?>&<?=$parametro;?>&pg=<?=$pg;?>" class="btn btn-default btn-sm" title="Excluir" onclick="javascript:return confirm('Deseja realmente excluir?')"><i class="far fa-trash-alt"></i></a>
		<a href="senha.php?ID=<?=$oUtil->Criptografar($oAdmin->id); ?>&<?=$parametro;?>&pg=<?=$pg;?>" class="btn btn-default btn-sm" title="Alterar Senha"><i class="fa fa-key"></i></a>
	</td>
</tr>
<?php $oAdmin->MoveNext();}?>
</tbody>
</table>

<?=$paginacao;}
else{ echo '<h2 style="text-align:center">Nenhum registro encontrado.</h2><br />
<a href="index.php" class="btn btn-default"><i class="glyphicon glyphicon-chevron-left"></i> Voltar</a>';}
?>


</div><!--card-body-->
</div><!--card-->

<?php
    $master_page->fechar("page_content");
	$master_page->fim();
?>