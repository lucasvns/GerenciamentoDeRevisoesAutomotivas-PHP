<?php

require_once (dirname(__file__) . "/util.php");

/**
 * Essa � a classe utilizada para uploads
 

 * @access public
 */
class upload extends util
{
    /**
     * Vari�vel recebe o arquivo
     *  
     * @access private 
     * @var $Resposta
     */
    var $Resposta;
    /**
     * Vari�vel recebe o arquivo
     *  
     * @access private 
     * @var $_FILES
     */
    var $_file;

    /**
     * Vari�vel recebe a descri��o do erro
     *  
     * @access public 
     * @var string
     */
    var $Erro = "";

    /**
     * Vari�vel recebe a extens�o do arquivos
     *  
     * @access public 
     * @var string
     */
    var $Extensao = "";

    /**
     * Fun��o que inicia essa classe
     * 
     * @param $_FILES $file
     * @access public
     * @return void
     */
    function upload($file)
    {
        $this->_file = $file;
        $this->Extensao = $this->GetExtensao($this->_file["name"]);
    }
    
    /**
     * Fun��o que verifica se o arquivo foi selecionado
     * 
     * @access public
     * @return bool
     */
    function Validar($obrigatorio = false, $arExtensao = array())
    {
    	if($this->_file['name'] || $obrigatorio)
    	{
	        if($this->_file['error'] == UPLOAD_ERR_OK)
	        {
	        	
	        	if(count($arExtensao) > 0)
	        	{
	        		return $this->ValidarExtensao($arExtensao);
				}
				else
				{
					return true;
				}	        	
	        }
	        else
	        {
	        	$this->Erro = $this->UploadErro();
	            return false;
	        }
	    }
	    else
	    {
	    	return true;
	    }
    }
    
    /**
     * Fun��o que verifica se o arquivo foi selecionado
     * 
     * @access public
     * @return bool
     */
    function ValidarTemporario()
    {
        return ($this->_file["tmp_name"]);
    }

    /**
     * Fun��o que valida a extens�o
     * 
     * @param array $ar
     * @access public
     * @return bool
     */
    function ValidarExtensao($ar)
    {
        if (!in_array($this->Extensao, $ar))
        {
            $this->Erro = "Arquivo inv�lido! Extens�es permitidas:  (*." . implode(", *.", $ar) . ")";
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Fun��o que executa o upload
     * 
     * @param string $local
     * @param string $name
     * @param string $ext
     * @param bool $SaveName
     * @access public
     * @return string
     */
    function Salvar($local, $name = null, $ext = null, $SaveName = false)
    {
        //verifica upload
        if ($this->Validar() && $this->ValidarTemporario())
        {
        	$arquivo = $this->ArquivoDisponivel($local, (($ext == null) ? $this->Extensao : $ext), $name, $SaveName);
        	$sFilePath = $arquivo["CaminhoCompleto"];

        	@move_uploaded_file($this->_file["tmp_name"], $sFilePath);
        	
            if (@is_file($sFilePath))
            {                $oldumask = @umask(0);
                @chmod($sFilePath, 0777);
                @umask($oldumask);
            }
			$this->Resposta = $arquivo["Caminho"];
            return $arquivo["Caminho"];
        }
    }

	/**
     * Fun��o que retorna o erro do upload
     * 
     * @access public
     * @return string
     */
    function UploadErro()
    {
    	$message = "";
        switch ($this->_file['error'])
        {
            case UPLOAD_ERR_INI_SIZE:
                $message = "Arquivo muito grande! Tamanho m�ximo permitido " . intval(ini_get('upload_max_filesize')) . " MB";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $message = "Arquivo muito grande! Tamanho m�ximo permitido " . intval(ini_get('upload_max_filesize')) . " MB";
                break;
            case UPLOAD_ERR_PARTIAL:
                $message = "Arquivo inv�lido! Falha ao carregar arquivo!";
                break;
            case UPLOAD_ERR_NO_FILE:
                $message = "Arquivo inv�lido! Nenhum arquivo foi selecionado!";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = "Arquivo inv�lido! Falha ao salvar arquivo!";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $message = "Arquivo inv�lido! Falha ao salvar arquivo!";
                break;
            case UPLOAD_ERR_EXTENSION:
                $message = "Arquivo inv�lido! Falha ao salvar arquivo!";
                break;
            default:
                $message = "Arquivo desconhecido!";
                break;
        }
        return $message;
    }
}

?>