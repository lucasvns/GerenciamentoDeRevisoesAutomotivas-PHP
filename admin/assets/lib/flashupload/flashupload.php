<?php

/**
 * Essa � a classe utilizada para criar upload em flash
 

 * @access public
 */
class flashupload
{
    /**
     * Vari�vel recebe a largura
     *  
     * @access public 
     * @var int
     */
    var $Width = "550";

    /**
     * Vari�vel recebe a altura
     *  
     * @access public 
     * @var int
     */
    var  $Height = "100";

    /**
     * Vari�vel recebe as extens�es permitidas
     *  
     * @access public 
     * @var string
     */
    var $Extensao = "";

    /**
     * Vari�vel recebe a descri��o
     *  
     * @access public 
     * @var string
     */
    var $Descricao = "";

    /**
     * Vari�vel recebe a url da p�gina a ser executada
     *  
     * @access public 
     * @var string
     */
    var $UploadPage = "";

    /**
     * Vari�vel recebe o nome da fun��o em javascript
     *  
     * @access public 
     * @var string
     */
    var $JavaScriptComlete = "";

    /**
     * Vari�vel recebe o caminho
     *  
     * @access public 
     * @var string
     */
    var $Path = "";

    /**
     * Fun��o que inicia essa classe
     * 
     * @access public
     * @return void
     */
    function flashupload()
    {
    }

    /**
     * Fun��o que cria o v�deo
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