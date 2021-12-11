<?php
	include_once("../barrier.php");
	include_once("../../alfa/database/DTO/tnoticia.php");
	include_once("../../alfa/database/DTO/tnoticiacategoria.php");
	include_once("../../alfa/tools/master.php");
	include_once("../../alfa/tools/validacao.php");
	include_once("../../alfa/tools/url.php");
	include_once("../../alfa/tools/fckeditor/fckeditor.php");
	include_once("../uploads/imgupload.class.php");

	$oUtil = new util();

if($_POST){
//TRANFORMA EM URL O NOME DA IMAGEM
	$oUrl = new url();
	$oUrl->URL 	= utf8_decode($_POST['txtNome']);
	$oUrl->Criar();
//CRIA AS VARIÁVEIS
	$IMG_UPLOAD = $_FILES["txtImg"];
	$IMG_NOME 	= $_POST['txtNome'];
	$IMG_URL 	= $oUrl->URL;
	$IMG_FONTE 	= $_POST['txtFonte'];
	$IMG_DESC 	= $_POST['txtDesc'];
	$IMG_ALIGN 	= $_POST['txtAlinhamento'];
	
//VERIFICA SE O CAMPO NOME FOI PREENCHIDO
	if(!$IMG_NOME=='' && !$IMG_UPLOAD==''){

		$IMG = new imagem();
		$IMG->Largura = 2000;
		$IMG->Altura = 2000;
//		$IMG->cropLar = 300;
//		$IMG->cropAlt = 230;
		$IMG->AlturaMax = 2000;
		$IMG->LarguraMax = 2000;
		$IMG->Tamanho = 1500000;
		$IMG->Arquivo = $IMG_UPLOAD;
		$IMG->Nome = $IMG_URL.'-'.date('d-m-y');
		$IMG->Pasta = 'arquivo/imagens/';
		$IMG->CriarImagem();


		$IMG_TAM = getimagesize('../../'.$IMG->Resultado);
		$IMG_TAM_L = $IMG_TAM[0];//LARGURA
		$IMG_TAM_A = $IMG_TAM[1];//ALTURA

		$thumb_nome = explode("/",$IMG->Resultado);
		$thumb_nome = $thumb_nome[2];

		$IMG_THUMB = $thumb_nome;
//SE A IMAGEM FOR MAIOR QUE 640px É CRIADO UM THUMB
		if($IMG_TAM_L > 640){
			$thumb = PhpThumbFactory::create('../../'.$IMG->Resultado);
			$thumb->resize(640,640);
			$thumb_nome = explode("/",$IMG->Resultado);
			$thumb_nome = $thumb_nome[2];
			$thumb->save('../../arquivo/imagens/thumbs/'.$thumb_nome);
			$IMG_THUMB = 'thumbs/'.$thumb_nome;			
		}

		$CODIGO = 
		'<table class="imgBox '.$IMG_ALIGN.'"><tr><td class="imgBoxLat"></td><td><div class="imgBoxCont"><table><tr><td class="imgBoxInfo">'.$IMG_FONTE.'</td></tr><tr><td>
		<a class="fancybox" href="http://www.meuguiadacidade.com.br/'.$IMG->Resultado.'"><img src="http://www.meuguiadacidade.com.br/arquivo/imagens/'.$IMG_THUMB.'" alt="'.$IMG_NOME.'" /></a></td></tr><tr><td class="descImg imgBoxInfo">'.$IMG_DESC.'</td></tr></table></div></td><td class="imgBoxLat"></td></tr></table>';

	}//fim do if
	else{ $msg = '<p class="aviso erro">Nome da Imagem é obrigatório!</p><br /><br /><br />';}
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload de Imagem</title>
<style type="text/css">
video,audio,mark,time,summary,section,ruby,output,nav,menu,hgroup,header,footer,figcaption,figure,embed,details,canvas,aside,article,td,th,tr,thead,tfoot,tbody,caption,table,legend,label,form,fieldset,li,ul,ol,dd,dt,dl,center,i,u,b,var,tt,sup,sub,strong,strike,small,samp,s,q,kbd,ins,img,em,dfn,del,code,cite,big,address,acronym,abbr,a,pre,blockquote,p,h6,h5,h4,h3,h2,h1,iframe,object,applet,span,div,body,html{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline}section,nav,menu,hgroup,header,footer,figure,figcaption,details,aside,article{display:block}body{line-height:1}ul,ol{list-style:none}q,blockquote{quotes:none}q:after,q:before,blockquote:after,blockquote:before{content:'';content:none}table{border-collapse:collapse;border-spacing:0}

*{font-family:Verdana, Geneva, sans-serif !important;font-size:12px !important;color:#3d3d3d !important}
a{text-decoration:none}
body{background:#EFEFEF}
.container{width:500px;margin:0 auto;margin-top:150px}
form{margin:20px;width:400px}
input[type=text]{width:450px;height:28px;font-size:16px;border-radius:5px;border:#333 solid 1px;padding:5px}
li{margin-bottom:10px}
label{font-size:18px !important;display:block;margin-bottom:10px}
label span{font-size:12px;display:block;margin:10px 0px 5px 0px}
.btn{cursor:pointer;
border: 1px solid #3079ed;
color: #fff !important;
text-shadow: 0 1px rgba(0,0,0,0.1);
background-color: #4d90fe;
background-image: -webkit-gradient(linear,left top,left bottom,from(#4d90fe),to(#4787ed));
background-image: -webkit-linear-gradient(top,#4d90fe,#4787ed);
background-image: -moz-linear-gradient(top,#4d90fe,#4787ed);
background-image: -ms-linear-gradient(top,#4d90fe,#4787ed);
background-image: -o-linear-gradient(top,#4d90fe,#4787ed);
background-image: linear-gradient(top,#4d90fe,#4787ed);
min-width: 46px;
text-align: center;
font-size: 14px;
font-weight: bold;
padding: 10px 20px;
-webkit-border-radius: 2px;
-moz-border-radius: 2px;
border-radius: 2px;
-webkit-transition: all 0.218s;
-moz-transition: all 0.218s;
-ms-transition: all 0.218s;
-o-transition: all 0.218s;
transition: all 0.218s;
-webkit-user-select: none;
-moz-user-select: none;
user-select: none;
}
.btn:hover{border-color:#265db5 !important;text-shadow:1px 1px #333}
.aviso{padding:10px 20px;border:#95c0d6 solid 1px;background:#d7eaf4;margin-bottom:10px;font-size:12px;font-weight:700;color:#333;border-radius:5px}
.aviso.erro{border:#e0aaaa solid 1px !important;background:#efcfcf !important;position:absolute;width:500px}
.aviso.funcionou{border:#80c592 solid 1px !important;background:#b7f1c6 !important}
</style>
</head>
<div class="container">
<?php if($CODIGO!=''){
	echo '<p class="aviso">A imagem foi gerada com sucesso!</p><p class="aviso funcionou">Copie o código:</p><textarea style="width:500px;resize:none;padding:10px;border-radius:10px" name="" id="" cols="30" rows="10">'.$CODIGO.'</textarea>';
}else{
?>
<?=($msg!='')? $msg:'';?>
<form action="" method="post"  enctype="multipart/form-data">
<ul>
<li><label for="txtNome">Nome da Imagem <span>(nome referente ao título da matéria, procure escrever poucas palavras. max.: 5)</span></label><input type="text" name="txtNome" id="txtNome" /></li>
<li><label for="txtFonte">Fonte <span>(de onde a imagem foi adquirida)</span></label><input type="text" name="txtFonte" id="txtFonte" /></li>
<li><label for="txtDesc">Descri&ccedil;&atilde;o <span>(descreva o que aparece na imagem)</span></label><input type="text" name="txtDesc" id="txtDesc" /></li>
<li><label for="txtAlinhamento">Alinhamento</label>
<select name="txtAlinhamento" id="txtAlinhamento">
<option value="colLeft">Esquerda</option>
<option value="colCenter">Central</option>
<option value="colRight">Direita</option>
</select>
</li>
<li><input type="file" name="txtImg" /></li>
<li><input type="submit" value="Enviar" class="btn" /></li>
</ul>
</form>
<?php }?>
</div>
<body>
</body>
</html>

