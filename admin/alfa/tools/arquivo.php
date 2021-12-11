<?php

/**
 * Essa � a classe utilizada para gerenciar arquivos
 

 * @access public
 */
class arquivo
{
    /**
     * Vari�vel recebe true se o arquivo existir
     *  
     * @access public 
     * @var bool
     */
    var $IsArquivo = false;

    /**
     * Vari�vel recebe a extens�o do arquivo
     *  
     * @access public 
     * @var string
     */
    var $Extensao = "";

    /**
     * Vari�vel recebe o conte�do do arquivo
     *  
     * @access public 
     * @var string
     */
    var $Conteudo = "";

    /**
     * Vari�vel recebe o caminho completo do arquivo
     *  
     * @access public 
     * @var string
     */
    var $Caminho = "";

    /**
     * Vari�vel recebe o nome do arquivo
     *  
     * @access public 
     * @var string
     */
    var $Nome = "";

    /**
     * Vari�vel recebe o conte�do do arquivo em linhas
     *  
     * @access public 
     * @var string
     */
    var $Linhas = "";

    /**
     * Fun��o que inicia essa classe
     * 
     * @param string $Arquivo
     * @access public 
     * @return void
     */
    function __construct($Arquivo)
    {
        $this->Caminho = $Arquivo;
        $this->IsArquivo = @is_file($this->Caminho);

        if ($this->IsArquivo)
        {
            $this->Nome = basename($this->Caminho);
            $this->Extensao = strtolower(end(explode(".", $this->Caminho)));

            @chmod($this->Caminho, 0777);

            $fp = @fopen($this->Caminho, 'r');
            $this->Conteudo = @fread($fp, filesize($this->Caminho));
            @fclose($fp);

            $this->Linhas = explode("\r\n", $this->Conteudo);
        }
    }

    /**
     * Fun��o que copia o arquivo
     * 
     * @param string $Destino
     * @access public 
     * @return bool
     */
    function Copiar($Destino)
    {
    	if (!$this->IsArquivo)
        {
        	return false;
        }
        
    	if(@is_file($Destino))
    	{
    		return false;
    	}
    	
        return @copy($this->Caminho, $Destino);
    }
    
    /**
     * Fun��o que renomeia o arquivo
     * 
     * @param string $Destino
     * @access public 
     * @return bool
     */
    function Renomear($Destino)
    {
    	if (!$this->IsArquivo)
        {
        	return false;
        }
        
    	if(@is_file($Destino))
    	{
    		return false;
    	}
    	
        return @rename($this->Caminho, $Destino);
    }

    /**
     * Fun��o que remove o arquivo caso exista
     * 
     * @access public 
     * @return bool
     */
    function Remover()
    {
        if (!$this->IsArquivo)
        {
        	return false;
        }
        
        @unlink($this->Caminho);
        return true;
    }

    /**
     * Fun��o que salva o conte�do do arquivo, caso o arquivo n�o exista cria
     * 
     * @access public 
     * @return void
     */
    function Salvar()
    {
        $fp = @fopen($this->Caminho, 'w+');
        @fwrite($fp, $this->Conteudo);
        @fclose($fp);
    }
    
    /**
     * Fun��o que formata os bytes do arquivo
     * 
     * @access public 
     * @param int $precision
     * @return void
     */
    function FormatarBytes($precision = 0)
	{
		$bytes = ((!$this->IsArquivo) ? 0 : filesize($this->Caminho));
	    $units = array('B', 'KB', 'MB', 'GB', 'TB');
	    $bytes = max($bytes, 0);
	    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
	    $pow = min($pow, count($units) - 1);
	    $bytes /= pow(1024, $pow);
	    return round($bytes, $precision) . ' ' . $units[$pow];
	}
}

?>