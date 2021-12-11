<?php
include_once ('classes/ThumbLib.inc.php');

class imagem{

var $Arquivo = '';

var $Nome = '';

var $Largura = '';

var $Altura = '';

var $cropLar = '';

var $cropAlt = '';

var $LarguraMax = '2000';

var $AlturaMax = '2000';

var $Tamanho = '';

var $Pasta = '';

var $Erro;

var $Resultado;

function CriarImagem(){

$arquivo = isset($this->Arquivo) ? $this->Arquivo : FALSE;

// Tamanho máximo do arquivo (em bytes)
$config["tamanho"] = $this->Tamanho;
// Largura máxima (pixels)
$config["largura"] = $this->LarguraMax;
// Altura máxima (pixels)
$config["altura"]  = $this->AlturaMax;

// Formulário postado... executa as ações
if($arquivo)
{  
    // Verifica se o mime-type do arquivo é de imagem
    if(!preg_match("/^image\/(pjpeg|jpeg|png|gif|bmp)$/", $arquivo["type"]))
    {
        $this->Erro[] = "Arquivo em formato inválido! A imagem deve ser jpg, jpeg, 
			bmp, gif ou png. Envie outro arquivo";
    }
    else
    {
        // Verifica tamanho do arquivo
        if($arquivo["size"] > $config["tamanho"])
        {
            $this->Erro[] = "Arquivo em tamanho muito grande! 
		A imagem deve ser de no máximo " . $config["tamanho"] . " bytes. 
		Envie outro arquivo";
        }
        
        // Para verificar as dimensões da imagem
        $tamanhos = getimagesize($arquivo["tmp_name"]);
        
        // Verifica largura
        if($tamanhos[0] > $config["largura"])
        {
            $this->Erro[] = "Largura da imagem não deve 
				ultrapassar " . $config["largura"] . " pixels";
        }

        // Verifica altura
        if($tamanhos[1] > $config["altura"])
        {
            $this->Erro[] = "Altura da imagem não deve 
				ultrapassar " . $config["altura"] . " pixels";
        }
    }
    
    // Imprime as mensagens de erro
    if(sizeof($this->Erro))
    {
        foreach($this->Erro as $err)
        {
            echo " - " . $err . "<BR>";
        }
    }

    // Verificação de dados OK, nenhum erro ocorrido, executa então o upload...
    else
    {
        // Pega extensão do arquivo
        preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $arquivo["name"], $ext);

        // Gera um nome único para a imagem
		if($this->Nome){
			$imagem_nome = $this->Nome . "." . $ext[1];			
			}else{ $imagem_nome = md5(uniqid(time())) . "." . $ext[1]; }

        // Caminho de onde a imagem ficará
        $imagem_dir = $this->Pasta . $imagem_nome;

		if(file_exists($imagem_dir)) {
			$imagem_nome = rand(0,100).'-'.$imagem_nome;

			$imagem_dir = $this->Pasta . $imagem_nome;
		}
		$imagem_dir = '../'.$imagem_dir;

        // Faz o upload da imagem
		if(!file_exists('../'.$this->Pasta)){mkdir('../'.$this->Pasta, 0777, true);}
        move_uploaded_file($arquivo["tmp_name"], $imagem_dir);
		$this->GerarThumb($imagem_dir,$this->Largura,$this->Altura);

		$this->Resultado = str_replace ("../", "",$imagem_dir);
    }
}

}//CriarImagem

function GerarThumb($img, $lar, $alt){
	$thumb = PhpThumbFactory::create($img);
	$thumb->resize($lar, $alt);
	//VERIFICA SE É PRECISO RECORTAR A IMAGEM
	if($this->cropLar){$thumb->cropFromCenter($this->cropLar, $this->cropAlt);}
	$thumb->save($img);
}

}