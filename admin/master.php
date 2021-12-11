<?php
include_once(SERVER_PATH . "/alfa/database/DTO/tadmin.php");
include_once(SERVER_PATH . "/alfa/database/DTO/tpermission.php");
include_once(SERVER_PATH . "/alfa/database/DTO/tparameter.php");
include_once(SERVER_PATH . "/alfa/database/DTO/tpermission_title.php");

date_default_timezone_set('America/Sao_Paulo');

$oUtil = new util();
$oParameter = new tparameter();
$path = $oParameter->getParametro('admin-url');
$sitetitle = $oParameter->getParametro('site-title');

$page_chave = (isset($page_chave))?$page_chave:'';

if(!isset($page_validar))
{
	$oAdmin = new tadmin();
	if(!$oAdmin->LoadByPrimaryKey($oAdmin->GetSession()))
	{
		header('Location:' . $path . 'login.php?u=' . $_SERVER["REQUEST_URI"]);
		exit();
	}
}

//verifica se o usuario tem permissao
if($page_chave!=''){
	$oPermissaoVerifica = new tpermission();
	if(!$oPermissaoVerifica->LoadBytadmin_idAndkeyword($oAdmin->id, $page_chave)){
		$oUtil->SetMensagem("Erro", "Você não tem permissão para acessar essa ferramenta!", "Atenção!");
		header('Location: ' . $path);
		exit();
	}
}

/*MENU*/
//Carrega as permissoes
$oPermissaoTitulo = new tpermission_title();
$oPermissaoTitulo->LoadBytadmin_id($oAdmin->GetSession());
$item = '';
$hasActive = false;
for($f=0;$f<$oPermissaoTitulo->RowsCount;$f++){
    $oPermissao = new tpermission();
    $oPermissao->LoadBytadmin_idAndtpermission_title_id($oAdmin->GetSession(), $oPermissaoTitulo->id);

    $oPermissao2 = new tpermission();
    $oPermissao2->LoadBykeyword($oPermissao->keyword);
    
    $oPermissao3 = new tpermission();
    $oPermissao3->LoadBykeyword($page_chave);
    
    $oPermissaoTitulo2 = new tpermission_title();
    
    if(isset($oPermissao3->PermissaoTituloID) && isset($oPermissao2->PermissaoTituloID)){
		if($oPermissao3->PermissaoTituloID == $oPermissao2->PermissaoTituloID){
	        $current = " active";
		}else{
	        $current = '';
		}
    }else{
        $current = '';
    }
	$area_active = '';
	$subitem = '';
	//Carrega os links das permissoes
	for($a = 0; $a < $oPermissao->RowsCount; $a++) {
		if($oPermissao->list){		
			$active = (($page_chave == $oPermissao->keyword) ? 'active' :'');
			if($area_active=='' && $active!=''){
				$area_active = $active;
			}
			$subitem .= 
			'<li class="'.$active.'">
			<span class="icon"><i class="'.$oPermissao->icon.'"></i></span>
			<span class="title"><a href="'.$path.$oPermissao->keyword.'/">'.utf8_encode($oPermissao->title).'</a></span>
			</li>';
		}
		$oPermissao->MoveNext();
	}

	$item .= '
	<li class="with-sub '.$area_active.'">
		<a href="#"><span class="icon"><i class="'.$oPermissaoTitulo->icon.'"></i></span><span class="title">'.utf8_encode($oPermissaoTitulo->title).'</span></a>
		<ul class="sub">'.$subitem.'</ul>
	</li>';

	$area_active = '';
	$oPermissaoTitulo->MoveNext();
}
$menu = '<ul>'.$item.'</ul>';
/*MENU*/
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?=($page_title)?$page_title.' | ':''?>Painel Administrativo</title>
<!--styles-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Open+Sans:400,300,600,700" type="text/css" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" />
<link rel="stylesheet" href="<?=$path?>assets/lib/fontawesome-pro-5-13-0/css/all.min.css" />
<link rel="stylesheet" href="<?=$path?>assets/lib/jquery-ui/jquery-ui-timepicker-addon.css" />
<link rel="stylesheet" href="<?=$path?>assets/lib/colorpicker/css/colorpicker.css" media="screen" type="text/css" />
<link rel="stylesheet" href="<?=$path?>assets/lib/easyautocomplete/easy-autocomplete.min.css">
<link rel="stylesheet" href="<?=$path?>assets/css/layout.css?var=<?=date('YmdHis');?>" type="text/css" />
<!--scripts-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyA5Kfyfy6OAHPRUGlmZOLYoS9aJ0jQDdbk"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<!-- <script src="<?=$path?>assets/js/jquery.maskedinput-1.3.min.js" type="text/javascript"></script> -->
<script src="<?=$path?>assets/js/jquery.maskedinput.min.js" type="text/javascript"></script>

<script src="<?=$path?>assets/js/jquery.maskMoney.min.js"></script>
<script src="<?=$path?>assets/lib/jquery-ui/datepicker-pt-BR.js"></script>
<script src="<?=$path?>assets/lib/jquery-ui/jquery-ui-timepicker-addon.js"></script>
<script src="<?=$path?>assets/lib/ckeditor/ckeditor.js"></script>
<script src="<?=$path?>assets/lib/tinymce/js/tinymce/tinymce.min.js"></script>
<script src="<?=$path?>assets/lib/colorpicker/js/colorpicker.js" type="text/javascript"></script>
<script src="<?=$path?>assets/lib/easyautocomplete/jquery.easy-autocomplete.min.js"></script>
</head>
<body ng-app="agencyApp">

<div id="topbar" class="row-fluid"><!--MENU-->
<?php
/*
<nav class="navbar" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?=$path?>">Painel Administrativo</a>
	</div>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-newspaper-o"></i></a>
            <ul class="dropdown-menu">
                <li><span>Nenhuma nova notícia recebida</span></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i></a>
            <ul class="dropdown-menu">
                <li><span>Nenhum novo usuário cadastrado</span></li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=$oAdmin->name?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="<?=$path.'logout.php'?>">Sair</a></li>
            </ul>
        </li>
    </ul>
</nav>
*/
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?=$path?>">Administrativo  </a>

<p style="text-align: center;"></p>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
	  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		<?=$oAdmin->name?>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="<?=$path.'logout.php'?>">Sair</a>
        </div>
      </li>
    </ul>
  </div>
</nav>

</div><!--MENU-->

<div id="content"><!--CONTENT-->

<div id="menu">
<?=$menu?>
</div>


	<div id="main">
		<?=$page_content?>	
	</div>
<br class="clear" />
</div><!--CONTENT-->

<script type="text/javascript">
$(function() {
	$('.datepicker').datetimepicker($.datepicker.regional[ "pt-BR" ]);
	$('.datepicker2').datepicker($.datepicker.regional[ "pt-BR" ]);
});

$('.colorpicker').ColorPicker({
	color: '#0000ff',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#colorSelector div').css('backgroundColor', '#' + hex);
	}
});
//FUNCIONAMENTO DO MENU
$('.with-sub > a').click(function(event) {
	if($(this).attr('href') == '#') {
		event.preventDefault();
	}
	if(!$(this).parents().hasClass('active')) {
		//Encontra o active
		var active = $('.with-sub.active');
		$('.menu-section .arrow').removeClass('open');
		//Recolhe todos menus abertos
		$('.with-sub ul').slideUp(200);
		//Remove a classe active
		$('.with-sub').not($(this).parent()).not(active).removeClass('active');
		//Coloca a class open no arrow
		$(this).find('.arrow').addClass('open');
		$(this).parent().find('ul').slideDown(200,function() {
			//Tira o active do active atual
			active.removeClass('active');
		});
		//Adiciona a classe active
		$(this).parent().addClass('active');
	}else{
		$('.with-sub').removeClass('active');
		$(this).removeClass('active');
		$(this).parent().find('ul').slideUp(200);
		$('.menu-section .arrow').removeClass('open');
	}
});

/*CKEDITOR.config.allowedContent = true;
CKEDITOR.replace('texteditor', {
  filebrowserUploadUrl: "<?=$path?>upload_img.php"
});*/

function cleanFilters(){
	$('form input').val('');
	$('form select').val('');
	$('form').submit();
	return false;
}
function cleanFilters2(){
	$('#search').val('');
	$('#status').val('');
	$('#curso').val('');
	$('#tipovaga').val('');
	$('#escolaridade').val('');
	
	$('form').submit();
	return false;
}
$(document).ready(function(e) {
    $('.n1').last().find('.item').addClass('last');
});

$(function() {
	//maskedinput
	$(".cpf").mask("999.999.999-99",{autoclear: false, placeholder: ""})
	$(".cpf_number").mask("99999999999",{autoclear: false, placeholder: ""})
	$(".cnpj").mask("99.999.999/9999-99",{autoclear: false, placeholder: ""});
	$(".cnpj_number").mask("99999999999999",{autoclear: false, placeholder: ""});
	$(".rg").mask("99.999.999-*",{autoclear: false})
	$(".date").mask("99/99/9999",{autoclear: false})
	$(".time").mask("99:99",{autoclear: false})
	$(".tel").mask("(99) 9999-9999?9",{autoclear: false})
	$(".cep").mask("99999-999",{autoclear: false})
	//moneymask
	// $('.money').maskMoney();
	$(".money").maskMoney({thousands:'.', decimal:',', symbolStay: true});
	$('.weight').maskMoney({
		thousands: '',
		decimal: '.',
		precision: 3
	});
})
</script>

</body>
</html>