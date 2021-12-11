<?php

/**
 * Essa é a classe utilizada para criar vídeos do youtube
 

 * @access public
 */
class youtube
{
    /**
     * Variável recebe a largura
     *  
     * @access public 
     * @var int
     */
    var $Width = "560";

    /**
     * Variável recebe a altura
     *  
     * @access public 
     * @var int
     */
    var $Height = "315";

    /**
     * Variável recebe a url do arquivo
     *  
     * @access public 
     * @var string
     */
    var $URL = "";

    /**
     * Função que inicia essa classe
     * 
     * @access public
     * @return void
     */
    function youtube()
    {
    }

    /**
     * Função que acerta url do youtube
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
     * Função que cria o vídeo
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