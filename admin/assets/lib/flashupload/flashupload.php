<?php

/**
 * Essa é a classe utilizada para criar upload em flash
 

 * @access public
 */
class flashupload
{
    /**
     * Variável recebe a largura
     *  
     * @access public 
     * @var int
     */
    var $Width = "550";

    /**
     * Variável recebe a altura
     *  
     * @access public 
     * @var int
     */
    var  $Height = "100";

    /**
     * Variável recebe as extensões permitidas
     *  
     * @access public 
     * @var string
     */
    var $Extensao = "";

    /**
     * Variável recebe a descrição
     *  
     * @access public 
     * @var string
     */
    var $Descricao = "";

    /**
     * Variável recebe a url da página a ser executada
     *  
     * @access public 
     * @var string
     */
    var $UploadPage = "";

    /**
     * Variável recebe o nome da função em javascript
     *  
     * @access public 
     * @var string
     */
    var $JavaScriptComlete = "";

    /**
     * Variável recebe o caminho
     *  
     * @access public 
     * @var string
     */
    var $Path = "";

    /**
     * Função que inicia essa classe
     * 
     * @access public
     * @return void
     */
    function flashupload()
    {
    }

    /**
     * Função que cria o vídeo
     * 
     * @access public
     * @return bool
     */
    function Criar()
    {

        if (! $this->UploadPage)
        {
            return false;
        }

        if (! $this->JavaScriptComlete)
        {
            return false;
        }

        if (! $this->Path)
        {
            return false;
        }

        echo '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
					  codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"
					  width="' . $this->Width . '" height="' . $this->Height . '" id="fileUpload" align="middle">
					  <param name="allowScriptAccess" value="*" />
					  <param name="movie" value="' . $this->Path . 'flashupload.swf" />
					  <param name="quality" value="high" />
				      <param name="wmode" value="transparent"/>
					  <param name="FlashVars" value="fileExtension=' . $this->Extensao . '&fileDescription=' .
            $this->Descricao . '&uploadPage=' . $this->UploadPage . '&completeFunction=' . $this->
            JavaScriptComlete . '" />
					  <embed src="' . $this->Path . 'flashupload.swf"
					  	FlashVars="fileExtension=' . $this->Extensao . '&fileDescription=' . $this->
            Descricao . '&uploadPage=' . $this->UploadPage . '&completeFunction=' . $this->JavaScriptComlete .
            '"
						quality="high" wmode="transparent" width="' . $this->Width . '" height="' .
            $this->Height . '" 
						name="fileUpload" align="middle" allowScriptAccess="sameDomain" 
						type="application/x-shockwave-flash" 
						pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>';

        return true;
    }

}

?>