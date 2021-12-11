<?php

/**
 * Essa é a classe utilizada para redimensionar imagens
 

 * @access public
 */
class redimensionar
{
    /**
     * Variável recebe true se a imagem existir
     *  
     * @access public 
     * @var bool
     */
    var $IsImagem = false;
    
    /**
     * Variável recebe o caminho completo da imagem
     *  
     * @access public 
     * @var string
     */
    var $Caminho = "";

    /**
     * Variável recebe o nome da imagem
     *  
     * @access public 
     * @var string
     */
    var $Nome = "";

    /**
     * Variável recebe a extensão da imagem
     *  
     * @access public 
     * @var string
     */
    var $Extensao = "";

    /**
     * Variável recebe a largura da imagem original
     *  
     * @access public 
     * @var bool
     */
    var $Largura = 0;

    /**
     * Variável recebe a altura da imagem original
     *  
     * @access public 
     * @var bool
     */
    var $Altura = 0;

    /**
     * Variável recebe a largura da nova imagem
     *  
     * @access public 
     * @var bool
     */
    var $NovaLargura = 0;

    /**
     * Variável recebe a altura da nova imagem
     *  
     * @access public 
     * @var bool
     */
    var $NovaAltura = 0;

    /**
     * Variável recebe a largura da imagem redimensionada
     *  
     * @access public 
     * @var bool
     */
    var $NovaLarguraRedimensionada = 0;

    /**
     * Variável recebe a altura da imagem redimensionada
     *  
     * @access public 
     * @var bool
     */
    var $NovaAlturaRedimensionada = 0;

    /**
     * Variável recebe true se o for cortar a imagem
     *  
     * @access public 
     * @var bool
     */
    var $Cortar = false;
    
    /**
     * Variável recebe true se o for centralizar a imagem
     *  
     * @access public 
     * @var bool
     */
    var $Centralizar = false;
    
    /**
     * Variável recebe a qualidade da imagem jpg
     *  
     * @access public 
     * @var bool
     */
    var $QualidadeJPG = 100;
    
    /**
     * Variável recebe a qualidade da imagem png
     *  
     * @access public 
     * @var bool
     */
    var $QualidadePNG = 8;

    /**
     * Função que inicia essa classe
     * 
     * @param string $Imagem
     * @access public 
     * @return void
     */
    function redimensionar($Imagem)
    {
        $this->Caminho = $Imagem;
        $this->IsImagem = @is_file($this->Caminho);

        if ($this->IsImagem)
        {
            $this->Nome = basename($this->Caminho);
            $this->Extensao = strtolower(end(explode(".", $this->Caminho)));

            //largura e altura da imagem
            $arxy = getimagesize($this->Caminho);
            $this->Largura = $arxy[0];
            $this->Altura = $arxy[1];
        }
    }

    /**
     * Função que redimensiona  a imagem proporcionalmente
     * 
     * @access protected
     * @return void
     */
    function TamanhoProporcional()
    {
        if ($this->Cortar == false)
        {
            //height
            if ($this->Altura < $this->NovaAlturaRedimensionada)
            {
                $this->NovaAlturaRedimensionada = ceil($this->Altura);
            }

            //width
            if ($this->Largura < $this->NovaLarguraRedimensionada)
            {
                $this->NovaLarguraRedimensionada = ceil($this->Largura);
            }
        }

        //calcula o fator
        if (($this->Largura / $this->NovaLarguraRedimensionada) > ($this->Altura / $this->NovaAlturaRedimensionada))
        {
            $fator = ($this->Largura / $this->NovaLarguraRedimensionada);
        }
        else
        {
            $fator = ($this->Altura / $this->NovaAlturaRedimensionada);
        }

        $this->NovaLarguraRedimensionada = ceil($this->Largura / $fator);
        $this->NovaAlturaRedimensionada = ceil($this->Altura / $fator);
    }

    /**
     * Função que corta a imagem
     * 
     * @access protected
     * @return void
     */
    function TamanhoCortar()
    {
        if ($this->Cortar)
        {
            $lm = ceil($this->NovaLarguraRedimensionada);
            $am = ceil($this->NovaAlturaRedimensionada);

            $x = ceil($this->Largura);
            $y = ceil($this->Altura);

            //Paisagem
            if (($x / $lm) > ($y / $am))
            {
                $dif = @abs($am - $y);
                $pct = ($dif * 100) / $y;
                $da = $am;
                $dl = $x + (($x * $pct) / 100);

                $x = ceil($dl);
                $y = ceil($da);
            }
            //Retrato
            else
            {
                if (($x / $lm) < ($y / $am))
                {
                    $dif = $lm - $x;
                    $dif = abs($dif);
                    $pct = ($dif * 100) / $x;
                    $dl = $lm;
                    $da = $y + (($y * $pct) / 100);

                    $x = ceil($dl);
                    $y = ceil($da);
                }
                //Quadrado
                else
                {
                    if ($lm > $am)
                    {
                        $x = $lm;
                        $y = $x;
                    }
                    else
                    {
                        $y = $am;
                        $x = $y;
                    }
                }
            }

            $this->NovaLarguraRedimensionada = ceil($x);
            $this->NovaAlturaRedimensionada = ceil($y);
        }
    }

    /**
     * Função que gera a imagem
     * 
     * @access protected
     * @return bool
     */
    function Gerar($Abrir = true, $Salvar = "")
    {
        //verifica se a imagem existe
        if (!$this->IsImagem)
        {
            return false;
        }

        //seta os tamanhos das imagens redimensionadas
        $this->NovaAlturaRedimensionada = ceil($this->NovaAltura);
        $this->NovaLarguraRedimensionada = ceil($this->NovaLargura);

        //corta a imagem
        $this->TamanhoCortar();

        //redimensiona a imagem proporcionalmente
        $this->TamanhoProporcional();

        //gera imagem
        if ($this->Cortar)
        {
            $imagem_fin = imagecreatetruecolor($this->NovaLargura, $this->NovaAltura);
        }
        else
        {
            $imagem_fin = imagecreatetruecolor($this->NovaLarguraRedimensionada, $this->NovaAlturaRedimensionada);
        }

        //verifica a extensão da imagem
        switch ($this->Extensao)
        {
            case "jpg":
                $imagem_orig = imagecreatefromjpeg($this->Caminho);
                break;
            case "jpeg":
                $imagem_orig = imagecreatefromjpeg($this->Caminho);
                break;
            case "gif":
                $imagem_orig = imagecreatefromgif($this->Caminho);
                break;
            case "png":
                $imagem_orig = imagecreatefrompng($this->Caminho);
                break;
        }

		//centralizar
		$dst_x = 0;
		$dst_y = 0;
		
		$src_x = 0;
		$src_y = 0;
		
		if($this->Centralizar && $this->Cortar)
		{
			//x
			$p = (($this->NovaLargura * 100) / $this->NovaLarguraRedimensionada);
			$c = (($this->Largura * $p) / 100);
			$src_x = (($this->Largura - $c) / 2);
			
			//y
			$p = (($this->NovaAltura * 100) / $this->NovaAlturaRedimensionada);
			$c = (($this->Altura * $p) / 100);
			$src_y = (($this->Altura - $c) / 2);
		}

        //gera imagem no tamanho correto
        imagecopyresampled($imagem_fin, $imagem_orig, $dst_x, $dst_y, $src_x, $src_y, $this->NovaLarguraRedimensionada, $this->NovaAlturaRedimensionada, $this->Largura, $this->Altura);

        //salva imagem de acordo com sua extensão
        if ($Salvar)
        {
            switch ($this->Extensao)
            {
                case "jpg":
                    imagejpeg($imagem_fin, $Salvar, $this->QualidadeJPG);
                    break;
                case "jpeg":
                    imagejpeg($imagem_fin, $Salvar, $this->QualidadeJPG);
                    break;
                case "gif":
                    imagegif($imagem_fin, $Salvar);
                    break;
                case "png":
                    imagepng($imagem_fin, $Salvar, $this->QualidadePNG);
                    break;
            }
        }

        //mostra a imagem
        if ($Abrir)
        {
            switch ($this->Extensao)
            {
                case "jpg":
                    header("Content-Type: image/jpg");
					imagejpeg($imagem_fin, null, $this->QualidadeJPG);
                    break;
                case "jpeg":
                	header("Content-Type: image/jpeg");
                    imagejpeg($imagem_fin, null, $this->QualidadeJPG);
                    break;
                case "gif":
                    header("Content-Type: image/gif");
					imagegif($imagem_fin);
                    break;
                case "png":
                    header("Content-Type: image/png");
					imagepng($imagem_fin, null, $this->QualidadePNG);
                    break;
            }
        }

        //destroi imagem
        imagedestroy($imagem_orig);
        imagedestroy($imagem_fin);

        return true;
    }

}

?>