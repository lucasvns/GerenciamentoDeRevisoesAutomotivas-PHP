<?php

/**
 * Essa &eacute; a classe utilizada para criar p�ginas mestres
 

 * @access public
 */
class MasterPages
{
    /**
     * Vari�vel recebe o caminho do template
     *  
     * @access private 
     * @var array
     */
    var $template;

    /**
     * Vari�vel recebe o t�tulo da p�gina
     *  
     * @access private 
     * @var array
     */
    var $title;

    /**
     * Vari�vel recebe o conte&uacute;do das �reas
     *  
     * @access private 
     * @var array
     */
    var $content_areas;

    /**
     * Vari�vel recebe os par�metros da p�gina
     *  
     * @access private 
     * @var array
     */
    var $parans = array();

    /**
     * Fun��o que inicia essa classe
     * 
     * @access public
     * @return void
     */
    function __construct()
    {

    }

    /**
     * Fun��o que adiciona par�metros na p�gina mestre
     * 
     * @param string $name
     * @param string $valor
     * @access public
     * @return void
     */
    function addParametro($name, $valor)
    {
        $this->parans[$name] = $valor;
    }

    /**
     * Fun��o que define o template e o t�tulo da p�gina
     * 
     * @param string $template_path
     * @param string $title
     * @access public
     * @return void
     */
    function inicio($template_path, $title = null)
    {
        $this->template = $template_path;
        $this->title = $title;
        $this->content_areas = array();
    }

    /**
     * Fun��o que finaliza a classe
     * 
     * @access public
     * @return void
     */
    function fim()
    {
        /* parametro */
        foreach ($this->parans as $p => $v)
        {
            ${$p} = $v;
        }

        /* areas */
        foreach ($this->content_areas as $s)
        {
            ${$s} = $this->{$s};
        }

        $page_title = $this->title;
        include ($this->template);
    }

    /**
     * Fun��o que abre �rea
     * 
     * @param string $content_area_name
     * @access public
     * @return void
     */
    function abrir($content_area_name)
    {
        if (! in_array($content_area_name, $this->content_areas))
        {
            $this->content_areas[] = $content_area_name;
        }

        ob_start();
    }

    /**
     * Fun��o que fecha �rea
     * 
     * @param string $content_area_name
     * @access public
     * @return void
     */
    function fechar($content_area_name)
    {
        if (! in_array($content_area_name, $this->content_areas))
        {

        }
        else
        {
            $this->{$content_area_name} = ob_get_contents();
        }

        ob_end_clean();
    }
}

?>