<style type="text/css">
.permission{padding:0px 50px}
.permission h4{font-size:13px;font-weight:300;background:#d6d6d6}
.permission-iten{display: inline-block;margin-bottom: 15px;padding:10px;vertical-align: top;}
.permission-iten:hover{background:#efefef}
.permission-iten .holder{width: 130px;}
.permission-iten .img{text-align:center}
.permission-iten .title{display:block;font-size: 13px;margin-top: 8px;text-align:center}
</style>
<?php
//Carrega os Titulos
$oPermissaoTitulo = new tpermissaotitulo();
$oPermissaoTitulo->LoadByUsuarioID($UsuarioID);
for($f=0;$f<$oPermissaoTitulo->RowsCount;$f++){
?>
<!--PERMISSION-->
<div class="permission">
	<h4><?=utf8_encode($oPermissaoTitulo->Titulo)?></h4>
<?php
$oPermissao = new tpermissao();
if($oPermissao->LoadByUsuarioIDAndPermissaoTituloID($UsuarioID, $oPermissaoTitulo->ID)){
	for($a = 0; $a < $oPermissao->RowsCount; $a++){
?>
<!--PERMISSION-ITEN-->
<div class="permission-iten">
<a href="<?=$oPermissao->Chave?>/">
	<div class="holder">
        <div class="img">
            <img src="src/img/ico-48-<?=$oPermissao->Chave?>.png" title="<?=$oPermissaoTitulo->Titulo;?>" />
        </div>
        <span class="title"><?=utf8_encode($oPermissao->Titulo)?></span>
    </div>
</a>
</div>
<!--PERMISSION-ITEN-->
<?php $oPermissao->MoveNext(); } }?>
</div>
<!--PERMISSION-->
<?php $oPermissaoTitulo->MoveNext();}?>