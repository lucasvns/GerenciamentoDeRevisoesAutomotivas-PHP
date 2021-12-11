<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?
include_once("../../alfa/tools/url.php");

$erro = $config = array();
$oUrl = new url();
$oUrl->URL = utf8_decode($_POST['txtNome']);
$oUrl->Criar();

$nomeImg = $oUrl->URL;
$fonteImg = ($_POST['txtFonte']);
$descImg = ($_POST['txtDesc']);
$aligImg = $_POST['txtAlinhamento'];

// Prepara a variável do arquivo
$arquivo = isset($_FILES["txtImg"]) ? $_FILES["txtImg"] : FALSE;

// Tamanho máximo do arquivo (em bytes)
$config["tamanho"] = 1068830;
// Largura máxima (pixels)
$config["largura"] = 640;
// Altura máxima (pixels)
$config["altura"]  = 640;

// Formulário postado... executa as ações
if($arquivo)
{  
    // Verifica se o mime-type do arquivo é de imagem
    if(!eregi("^image\/(pjpeg|jpeg|png|gif|bmp)$", $arquivo["type"]))
    {
        $erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, 
			bmp, gif ou png. Envie outro arquivo";
    }
    else
    {
        // Verifica tamanho do arquivo
        if($arquivo["size"] > $config["tamanho"])
        {
            $erro[] = "Arquivo em tamanho muito grande! 
		A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. 
		Envie outro arquivo";
        }
        
        // Para verificar as dimensões da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);
        
        // Verifica largura
        if($tamanhos[0] > $config["largura"])
        {
            $erro[] = "Largura da imagem não deve 
				ultrapassar " . $config["largura"] . " pixels";
        }

        // Verifica altura
        if($tamanhos[1] > $config["altura"])
        {
            $erro[] = "Altura da imagem não deve 
				ultrapassar " . $config["altura"] . " pixels";
        }
    }
    
    // Imprime as mensagens de erro
    if(sizeof($erro))
    {
        foreach($erro as $err)
        {
            echo " - " . $err . "<BR>";
        }

        echo "<a href=\"imagem.php\">Fazer Upload de Outra Imagem</a>";
    }

    // Verificação de dados OK, nenhum erro ocorrido, executa então o upload...
    else
    {
        // Pega extensão do arquivo
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);

        // Gera um nome único para a imagem
		if($nomeImg){
			$imagem_nome = $nomeImg . "." . $ext[1];			
			}else{ $imagem_nome = md5(uniqid(time())) . "." . $ext[1]; }
		
		

        // Caminho de onde a imagem ficará
        $imagem_dir = "../../arquivo/imagens/" . $imagem_nome;

        // Faz o upload da imagem
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);

        echo "Sua foto foi enviada com sucesso!";
    }
}
?>
<style type="text/css">
ul,li{list-style:none}
body{background:#dedede}
textarea{background:fefefe;border:none;width:400px;height:400px}
</style>
<ul>
<li></li>
<li>
<textarea name="" id="" cols="30" rows="10">
<?php
echo '
<table class="imgBox '.$aligImg.'"><tr><td class="imgBoxLat"></td><td><div class="imgBoxCont"><table><tr><td class="imgBoxInfo">'.$fonteImg.'</td></tr><tr><td><a href="http://www.meuguiadacidade.com.br/arquivo/imagens/'.$imagem_nome.'"><img src="http://www.meuguiadacidade.com.br/arquivo/imagens/'.$imagem_nome.'" alt="'.$descImg.'" title="'.$descImg.'"/></a></td></tr><tr><td class="descImg imgBoxInfo">'.$descImg.'</td></tr></table></div></td><td class="imgBoxLat"></td></tr></table>
';
?>
</textarea></li>
</ul>
<?php
echo '
';
?>
<!--<div class="imgBox '.$aligImg.'">
<ul>
<li>'.$fonteImg.'</li>
<li style="text-align:center"><img src="http://www.meuguiadacidade.com.br/sjc/arquivo/imagens/'.$imagem_nome.'" alt="'.$descImg.'" /></li>
<li class="descImg">'.$descImg.'</li>
</ul>
</div>-->