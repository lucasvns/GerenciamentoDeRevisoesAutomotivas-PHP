<?php

/**
 * Essa � a classe utilizada para criar v�deos do youtube
 

 * @access public
 */
class youtube
{
    /**
     * Vari�vel recebe a largura
     *  
     * @access public 
     * @var int
     */
    var $Width = "560";

    /**
     * Vari�vel recebe a altura
     *  
     * @access public 
     * @var int
     */
    var $Height = "315";

    /**
     * Vari�vel recebe a url do arquivo
     *  
     * @access public 
     * @var string
     */
    var $URL = "";

    /**
     * Fun��o que inicia essa classe
     * 
     * @access public
     * @return void
     */
    function youtube()
    {
    }

    /**
     * Fun��o que acerta url do youtube
     * 
     * @access private
     * @return void
     */
	function decode(){

		if(strpos($this->URL,'v=')){
			$this->URL = explode('v=',$this->URL);
			$this->URL = explode('&amp;',$this->URL[1]);
		}else if(strpos($this->URL,'youtu.be/')){
			$this->URL = explode('youtu.be/',$this->URL);
			$this->URL = explode('&amp;',$this->URL[1]);
		}else if(strpos($this->URL,'/v/')){
			$this->URL = explode('/v/',$this->URL);
			$this->URL = explode('&amp;',$this->URL[1]);
		}
		$this->URL = $this->URL[0];

    }

    /**
     * Fun��o que cria o v�deo
     * 
     * @access public
     * @return bool
     */
    function Criar(){

        if (!$this->URL){
            return false;
        }

		echo '<iframe width="'.$this->Width.'" height="'.$this->Height.'" src="http://www.youtube.com/embed/'.$this->URL.'?rel=0&showinfo=0&theme=light" frameborder="0" allowfullscreen></iframe>';
        return true;
    }


}



?>