<?php
/**
 * Essa � a classe utilizada para gerenciar diret�rios
 

 * @access public
 */
class diretorio
{
    /**
     * Vari�vel recebe true se o diret�rio existir
     *  
     * @access public 
     * @var bool
     */
    var $IsDiretorio = false;

    /**
     * Vari�vel recebe o caminho do diret�rio
     *  
     * @access public 
     * @var string
     */
    var $Caminho = "";

    /**
     * Fun��o que inicia essa classe
     * 
     * @param string $Diretorio
     * @access public 
     * @return void
     */
    function __construct($Diretorio)
    {
        $this->Caminho = $Diretorio;
        $this->IsDiretorio = @is_dir($this->Caminho);
    }

    /**
     * Fun��o que remove o diret�rio
     * 
     * @param bool $empty
     * @access public
     * @return bool
     */
    function Remover($empty = false)
    {

        $directory = $this->Caminho;

        // if the path has a slash at the end we remove it here
        if (substr($directory, -1) == '/')
        {
            $directory = substr($directory, 0, -1);
        }

        // if the path is not valid or is not a directory ...
        if (!@file_exists($directory) || !@is_dir($directory))
        {
            // ... we return false and exit the function
            return false;

            // ... if the path is not readable
        } elseif (!@is_readable($directory))
        {
            // ... we return false and exit the function
            return false;

            // ... else if the path is readable
        }
        else
        {
            @chmod($directory, 0777);

            // we open the directory
            $handle = @opendir($directory);

            // and scan through the items inside
            while (false !== ($item = @readdir($handle)))
            {
                // if the filepointer is not the current directory
                // or the parent directory
                if ($item != '.' && $item != '..')
                {
                    // we build the new path to delete
                    $path = $directory . '/' . $item;

                    // if the new path is a directory
                    if (@is_dir($path))
                    {
                        // we call this function with the new path
                        $oDiretorioR = new diretorio($path);
                        $oDiretorioR->Remover();

                        // if the new path is a file
                    }
                    else
                    {
                        // we remove the file
                        @unlink($path);
                    }
                }
            }
            // close the directory
            @closedir($handle);

            // if the option to empty is not set to true
            if ($empty == false)
            {
                // try to delete the now empty directory
                if (!@rmdir($directory))
                {
                    // return false if not possible
                    return false;
                }
            }
            // return success
            return true;
        }
    }

    /**
     * Fun��o que cria o diret�rio
     * 
     * @access public
     * @return void
     */
    function Criar()
    {
        $dirs = explode("/", $this->Caminho);
        $dir = substr($_SERVER["DOCUMENT_ROOT"], 0, 1);
        if($dir != DIRECTORY_SEPARATOR)
        {
			$dir = "";
		}
        for ($z = 0; $z < count($dirs); $z++)
        {
            if (trim($dirs[$z]) != "")
            {
                $dir .= $dirs[$z] . "/";

                if (!@is_dir($dir))
                {
                    @mkdir($dir, 0777);
                    @umask(0000);
                    @chmod($dir, 0777);
                }
            }
        }
    }

    /**
     * Fun��o que carrega todos os diret�rios
     * 
     * @access public
     * @return array
     */
    function getArquivos()
    {
        $ar = array();
        if ($handle = @opendir($this->Caminho))
        {
            @chmod($this->Caminho, 0777);
            while (false !== ($file = @readdir($handle)))
            {
                if (@is_file($this->Caminho . "/" . $file) && $file != "." && $file != "..")
                {
                    array_push($ar, $file);
                }
            }
            @closedir($handle);
        }
        return $ar;
    }

    /**
     * Fun��o que carrega todos os arquivos
     * 
     * @access public
     * @return array
     */
    function getDiretorios()
    {
        $ar = array();
        if ($handle = @opendir($this->Caminho))
        {
            @chmod($this->Caminho, 0777);
            while (false !== ($file = @readdir($handle)))
            {
                if (@is_dir($this->Caminho . "/" . $file) && $file != "." && $file != "..")
                {
                    array_push($ar, $file);
                }
            }
            @closedir($handle);
        }
        return $ar;
    }
}
?>