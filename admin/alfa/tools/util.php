<?php
ini_set ('gd.jpeg_ignore_warning', 1);
require_once (dirname(__file__) . "/seguranca.php");
require_once (dirname(__file__) . "/diretorio.php");
require_once (dirname(__file__) . "/arquivo.php");

/**
 * Essa é a classe utilizada para várias funcionalidades
 

 * @access public
 */
class util
{
	/**
     * Variável recebe as letras do alfabeto
     *  
     * @access public 
     * @var array
     */
    var $letra = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
    
    /**
     * Variável recebe os dias da semana
     *  
     * @access public 
     * @var array
     */
    var $semana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');

    /**
     * Variável recebe os meses do ano
     *  
     * @access public 
     * @var array
     */
    var $mes = array('', 'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    var $mesabrev = array('', 'Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez');

    /**
     * Variável recebe as siglas dos estados
     *  
     * @access public 
     * @var array
     */
    var $sigla = array('AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'MT', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO');

    /**
     * Variável recebe os estados
     *  
     * @access public 
     * @var array
     */
    var $estado = array('AC' => 'Acre', 'AL' => 'Alagoas', 'AM' => 'Amazonas', 'AP' => 'Amapá', 'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás',
        'MA' => 'Maranhão', 'MG' => 'Minas Gerais', 'MS' => 'Mato Grosso do Sul', 'MT' => 'Mato Grosso', 'PA' => 'Pará', 'PB' => 'Paraiba', 'PE' => 'Pernambuco', 'PI' => 'Piaui', 'PR' => 'Paraná', 'RJ' =>
        'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'RS' => 'Rio Grande do Sul', 'SC' => 'Santa Catarina', 'SE' => 'Sergipe', 'SP' => 'São Paulo', 'TO' => 'Tocantins');

    /**
     * Função que inicia essa classe
     * 
     * @access public 
     * @return void
     */
    function __construct()
    {
    	
    }
    
    /**
     * Função que remove os acentos
     * 
     * @param string $str
     * @access public 
     * @return string
     */
    function RemoverAcento($str)
	{
	    $from = 'ÀÁÃÂÉÊÍÓÕÔÚÜÇàáãâéêíóõôúüç';
	    $to   = 'AAAAEEIOOOUUCaaaaeeiooouuc';
	    return strtr($str, $from, $to);
	}

    /**
     * Função que cortar texto
     * 
     * @param string $string
     * @param int $caracter
     * @access public 
     * @return string
     */
    function CortarTexto($string, $caracter)
    {
        $string = strip_tags($this->HTMLDecode($string));

        if (strlen($string) > $caracter)
        {
            $string = substr($string, 0, $caracter) . "...";
        }

        return $string;
    }

    /**
     * Função que remove protocolo
     * 
     * @param string $url
     * @access public 
     * @return void
     */
    function RemoverProtocolo($url)
    {
    	return preg_replace("/^[^:]+:\/+(.*)$/", "\\1", $url);
    }

    /**
     * Função que corta o texto sem cortar as palavras no meio
     * 
     * @access public
     * @param string $Texto 
     * @param int $Limite
	 * @param int $Padding 
     * @return void
     */
    function AbreviaTexto($Texto, $Limite, $Padding = "...")
    { 
    	$Texto = strip_tags($this->HTMLDecode($Texto));
        if(strlen($Texto) > $Limite)
		{  
			$Limite--;
			$Last = substr($Texto, $Limite - 1, 1);
			while($Last != ' ' && $Limite > 0)
			{  
				$Limite--;  
				$Last = substr($Texto, $Limite - 1, 1);
			}
			
			$Last = substr($Texto, $Limite - 2, 1);
			if($Last == ',' || $Last == ';'  || $Last == ':')
			{
				$Texto = substr($Texto, 0, $Limite - 2) . $Padding;
			}
			else if($Last == '.' || $Last == '?' || $Last == '!')
			{
				$Texto = substr($Texto, 0, $Limite - 1);
			}
			else
			{
				$Texto = substr($Texto, 0, $Limite - 1) . $Padding;
			}
       }  
       return $Texto;  
    }

    /**
     * Função que transforma texto
     * 
     * @param string $texto
     * @access public 
     * @return string
     */
    function HTMLDecode($texto)
    {
        return html_entity_decode(html_entity_decode($texto));
    }
    
    /**
     * Função que retorna a saudação dependendo da hroa
     * 
     * @access public 
     * @return string
     */
    function Saudacao()
    {
    	$hora = date("H");
		if ($hora < 12)
		{
			return "Bom dia";
		}
		elseif ($hora < 18)
		{
			return "Boa tarde";
		}
		else
		{
			return "Boa noite";
		}
    }

    /**
     * Função que transforma texto
     * 
     * @param string $texto
     * @access public 
     * @return string
     */
    function HTMLEncode($texto)
    {
        //return htmlentities($texto, ENT_QUOTES);
        return htmlspecialchars($texto, ENT_QUOTES);
    }

    /**
     * Função que valida e-mail
     * 
     * @param string $email
     * @access public
     * @return bool
     */
    function ValidarEmail($email)
    {
        if (!preg_match("/[a-z0-9_-]+(\.[a-z0-9_-]+)*@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4})/i", $email))
        {
            return false;
        }
        return true;
    }

    /**
     * Função que gera altura e largura de uma imagem proporcionalmente
     * 
     * @param string $Caminho
     * @param int $NovaLargura
     * @param int $NovaAltura
     * @access public
     * @return array
     */
    function TamanhoProporcional($Caminho, $NovaLargura, $NovaAltura, $Maior = true)
    {
        if (!@is_file($Caminho))
        {
            return;
        }

        $Tamanho = getimagesize($Caminho);
        $Altura = $Tamanho[1];
        $Largura = $Tamanho[0];

        if ($Maior == true)
        {
            //height
            if ($Altura < $NovaAltura)
            {
                $NovaAltura = $Altura;
            }

            //width
            if ($Largura < $NovaLargura)
            {
                $NovaLargura = $Largura;
            }
        }

        //calcula o fator
        if (($Largura / $NovaLargura) > ($Altura / $NovaAltura))
        {
            $fator = ($Largura / $NovaLargura);
        }
        else
        {
            $fator = ($Altura / $NovaAltura);
        }

        $NovaLargura = ($Largura / $fator);
        $NovaAltura = ($Altura / $fator);

        return array('Largura' => $Largura, 'Altura' => $Altura, 'NovaLargura' => $NovaLargura, 'NovaAltura' => $NovaAltura, 'Caminho' => $Caminho);
    }

    /**
     * Função que cria objeto do flash em html
     * 
     * @param string $url
     * @param int $width
     * @param int $height
     * @access public
     * @return bool
     */
    function Flash($url, $width = "400", $height = "300")
    {

        if (!$url)
        {
            return false;
        }

        echo '<object width="' . $width . '" height="' . $height . '" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"
					 codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" align="middle">
						<param name="allowScriptAccess" value="*" />
						<param name="movie" value="' . $url . '" />
						<param name="quality" value="high" />
						<param name="wmode" value="transparent">
						<embed width="' . $width . '" height="' . $height . '" src="' . $url . '"
						 quality="high" wmode="transparent" align="middle" allowScriptAccess="sameDomain" 
						 type="application/x-shockwave-flash" 
						 pluginspage="http://www.macromedia.com/go/getflashplayer" />
					</object>';

        return true;
    }

    /**
     * Função que gera um nome randômico
     * 
     * @param integer $len
     * @access public
     * @return string
     */
    function GerarNome($len = 10)
    {
        $toquen = md5(uniqid(rand(), true));
        $val = strtolower(substr($toquen, 0, $len));
        return $val;
    }

    /**
     * Função que criptografa
     * 
     * @param string $texto
     * @access public
     * @return string
     */
    function Criptografar($texto)
    {
        return base64_encode($this->HTMLEncode($texto));
    }
	function CriptografarMD5($texto)
    {//Hash de 128 bits 32 caracteres hexadecimal
        return md5($this->HTMLEncode($texto));
    }
	function CriptografarSHA1($texto)
    {//Hash de 160 bits 40 caracteres hexadecimal
        return sha1($this->HTMLEncode($texto));
    }
    /**
     * Função que descriptografa
     * 
     * @param string $texto
     * @access public
     * @return string
     */
    function Descriptografar($texto)
    {
        return $this->HTMLDecode(base64_decode($texto));
    }
    
    /**
     * Função que aumenta
     * 
     * @param string $str
     * @access public
     * @return string
     */
    function StringUpper($str)
	{
    	return strtr(strtoupper($str), "àáâãçéêíóôõüú", "ÀÁÂÃÇÉÊÍÓÔÕÜÚ");
	}
	
	/**
     * Função que aumenta
     * 
     * @param string $str
     * @access public
     * @return string
     */
    function StringLower($str)
	{
    	return strtr(strtolower($str), "ÀÁÂÃÇÉÊÍÓÔÕÜÚ", "àáâãçéêíóôõüú");
	}

    /**
     * Função que formata valor para mostrar para o usuário
     * 
     * @param decimal $valor
     * @access public
     * @return string
     */
    function ValorMostrar($valor)
    {
        return number_format($valor, 2, ',', '.');
    }

    /**
     * Função que formata valor para salvar no banco de dados
     * 
     * @param string $valor
     * @access public
     * @return decimal
     */
    function ValorSalvar($valor)
    {
        return str_replace(",", ".", str_replace(".", "", $valor));
    }

    /**
     * Função que formata data para salvar no banco de dados
     * 
     * @param string $data
     * @access public
     * @return datetime
     */
    function DataSalvar($data)
    {
        $sepData = explode(" ", $data);
        $d = explode("/", $sepData[0]);
        $dia = $d[0];
        $mes = $d[1];
        $ano = $d[2];
        $h = explode(":", $sepData[1]);
        $hora = $h[0];
        $minito = $h[1];
        $segundo = $h[2];

        return "$ano-$mes-$dia $hora:$minito:$segundo";
    }

    /**
     * Função que formata data para mostrar para o usuário
     * 
     * @param datetime $data
     * @access public
     * @return strtotime
     */
    function DataMostrar($data)
    {
        $dia = date("d", strtotime($data));
        $mes = date("m", strtotime($data));
        $ano = date("Y", strtotime($data));
        $hora = date("H", strtotime($data));
        $minito = date("i", strtotime($data));
        $segundo = date("s", strtotime($data));

        $d = "$mes/$dia/$ano $hora:$minito:$segundo";

        return strtotime($d);
    }

    /**
     * Função que procura uma palavra no diretório
     * 
     * @param string $procura
     * @param string $diretorio
     * @param array $arquivos
     * @param bool $loop
     * @access public
     * @return array
     */
    function Procurar($procura, $diretorio, $arquivos = array(), $loop = false, $quantidade = 0)
    {
        $dadobusca = $this->HTMLDecode($procura);

        $arRet = array();

        if (in_array($diretorio, $arquivos) == false)
        {
            $oDiretorio = new Diretorio($diretorio);
            $arFiles = $oDiretorio->getArquivos();
            $qtdFiles = count($arFiles);
            for ($a = 0; $a < $qtdFiles; $a++)
            {
            	$pathFile = $diretorio . $arFiles[$a];
                if (in_array($pathFile, $arquivos) == false)
                {
                    $oArquivo = new arquivo($pathFile);
                    $conteudo = strip_tags($this->HTMLDecode($oArquivo->Conteudo));
                    $bLinha = (strpos(strtoupper($conteudo), strtoupper($dadobusca)));
                    if ($bLinha)
                    {
                        $arArquivo = array('NomeBase' => str_replace("." . $oArquivo->Extensao, "", $oArquivo->Nome),
										   'Extensao' => $oArquivo->Extensao, 
										   'Arquivo' => $oArquivo->Caminho, 
										   'Nome' => $oArquivo->Nome, 
										   'Procura' => $procura, 
										   'Texto' => str_replace($dadobusca, "<b>" . $dadobusca . "</b>", substr($conteudo, ((($bLinha - $quantidade) < 0) ? 0 : ($bLinha - $quantidade)), ($quantidade * 2))));

                        array_push($arRet, $arArquivo);
                        array_push($arquivos, $pathFile);
                    }
                }
            }
        }

        //loop
        if ($loop)
        {
            $arDir = $oDiretorio->getDiretorios();
            $qtdDir = count($arDir);
            for ($d = 0; $d < $qtdDir; $d++)
            {
                $subDiretorio = $diretorio . $arDir[$d] . "/";
                if (in_array($subDiretorio, $arquivos) == false)
                {
                	$arProcuraDir = $this->Procurar($procura, $subDiretorio, $arquivos, $loop, $quantidade);
                	if(count($arProcuraDir) > 0)
                	{
                    	array_push($arRet, $arProcuraDir[0]);
                    }
                }
            }
        }

        return $arRet;
    }

    /**
     * Função que cria paginação
     * 
     * @param string $pg
     * @param int $totalregistro
     * @param int $portela
     * @param string $parametro
     * @param bool $total
     * @param bool $listapaginas
     * @param bool $primeira
     * @param bool $anterior
     * @param bool $proxima
     * @param bool $ultima
     * @access public
     * @return void
     */
    function Paginar($key, $totalregistro, $portela, $parametro = "", $total = true, $listapaginas = true, $primeira = true, $anterior = true, $proxima = true, $ultima = true)
    {
        $paginas = ceil($totalregistro / $portela);
        $selecionda = (isset($_GET[$key])) ? intval($_GET[$key]) : 0;
        $selecionda = ($selecionda > $paginas) ? 0 : $selecionda;

        $link = $_SERVER["PHP_SELF"];

        $sret = "";
        $sret .= '<table class="pagination">';
        $sret .= '<tr>';
        // $sret .= '<td>'.$selecionda.'</td>';

        if ($total)
        {
            $sret .= "<td class='total'>Total: ( " . $totalregistro . " )</td>";
        }

        $sret .= '<td align="right">';

        if ($paginas > 1)
        {
            if ($selecionda > 0)
            {
                if ($primeira)
                {
                    $sret .= '<a class="primeira" href="' . $link . '?' . $parametro . '">&laquo; &laquo; primeira</a>';
                }
                if ($anterior)
                {
                    $sret .= '<a class="anterior" href="' . $link . '?' . $key . '=' . ($selecionda - 1) . '&' . $parametro . '">&laquo; anterior</a>';
                }
            }
            else
            {
                if ($primeira)
                {
                    $sret .= '<span class="primeira">&laquo; &laquo; primeira</span>';
                }
                if ($anterior)
                {
                    $sret .= '<span class="anterior">&laquo; anterior</span>';
                }
            }

            if ($listapaginas)
            {
                if ($selecionda > 3)
                {
                    $sret .= '<a class="number" href="' . $link . '?' . $key . '=' . ($selecionda - 4) . '&' . $parametro . '">...</a>';
                }

                for ($d = ($selecionda > 3) ? ($selecionda - 3) : 0; $d < $selecionda; $d++)
                {
                    $sret .= '<a class="number" href="' . $link . '?' . $key . '=' . $d . '&' . $parametro . '">' . ($d + 1) . '</a>';
                }

                $iconta = 1;
                for ($o = $selecionda; $o < $paginas; $o++)
                {
                    if ($selecionda == $o)
                    {
                        $sret .= '<span class="number current">' . ($o + 1) . '</span>';
                    }
                    else
                    {
                        if ($iconta > 3)
                        {
                            $sret .= '<a class="number" href="' . $link . '?' . $key . '=' . $o . '&' . $parametro . '">...</a>';
                            break;
                        }
                        else
                        {
                            $sret .= '<a class="number" href="' . $link . '?' . $key . '=' . $o . '&' . $parametro . '">' . ($o + 1) . '</a>';
                            $iconta += 1;
                        }
                    }
                }
            }

            if (($selecionda + 1) < $paginas)
            {
                if ($proxima)
                {
                    $sret .= '<a class="proxima" href="' . $link . '?' . $key . '=' . ($selecionda + 1) . '&' . $parametro . '">pr&oacute;xima &raquo;</a>';
                }

                if ($ultima)
                {
                    $sret .= '<a class="ultima" href="' . $link . '?' . $key . '=' . ($paginas - 1) . '&' . $parametro . '">&uacute;ltima &raquo; &raquo;</a>';
                }
            }
            else
            {
                if ($proxima)
                {
                    $sret .= '<span class="proxima">próxima &raquo;</span>';
                }

                if ($ultima)
                {
                    $sret .= '<span class="ultima">última &raquo; &raquo;</span>';
                }
            }
        }

        $sret .= '</td></tr></table>';

        return $sret;
    }
    /**
     * Função que cria paginação
     * 
     * @param string $pg
     * @param int $totalregistro
     * @param int $portela
     * @param string $parametro
     * @param bool $total
     * @param bool $listapaginas
     * @param bool $primeira
     * @param bool $anterior
     * @param bool $proxima
     * @param bool $ultima
     * @access public
     * @return void
     */
    function PaginarEspecial($key, $totalregistro, $portela, $parametro = "", $request = "", $total = true, $listapaginas = true, $primeira = true, $anterior = true, $proxima = true, $ultima = true)
    {

        $paginas = ceil($totalregistro / $portela);
        $selecionda = ($key) ? intval($key) : 0;
        $selecionda = ($selecionda > $paginas) ? 0 : $selecionda;
        $url = explode("/", $_SERVER['REQUEST_URI']);
        
        $link = $request.'?pagina=';

        $sret = "";
        $sret .= '<table class="pagination">';
        $sret .= '<tr>';

        if ($total)
        {
            $sret .= "<td class='total'>Total: ( " . $totalregistro . " )</td>";
        }

        $sret .= '<td align="right">';

        if ($paginas > 1)
        {
            if ($selecionda > 0)
            {
                if ($primeira)
                {
                    $sret .= '<a class="primeira" href="' . $link .  '">&laquo; &laquo; primeira</a>';
                }
                if ($anterior)
                {
                    $sret .= '<a class="anterior" href="' .  $link .   ($selecionda - 1). '">&laquo; anterior</a>';
                }
            }
            else
            {
                if ($primeira)
                {
                    $sret .= '<span class="primeira">&laquo; &laquo; primeira</span>';
                }
                if ($anterior)
                {
                    $sret .= '<span class="anterior">&laquo; anterior</span>';
                }
            }

            if ($listapaginas)
            {
                if ($selecionda > 3)
                {
                    $sret .= '<a class="number" href="' . $link .  ($selecionda - 4) . '">...</a>';
                }

                for ($d = ($selecionda > 3) ? ($selecionda - 3) : 0; $d < $selecionda; $d++)
                {
                    $sret .= '<a class="number" href="' . $link .  $d .  '">' . ($d + 1) . '</a>';
                }

                $iconta = 1;
                for ($o = $selecionda; $o < $paginas; $o++)
                {
                    if ($selecionda == $o)
                    {
                      $sret .= '<span class="number current">' . ($o + 1) . '</span>';
                    }
                    else
                    {
                        if ($iconta > 3)
                        {
                            $sret .= '<a class="number" href="' . $link . $key . '=' . $o . '&' . $parametro . '">...</a>';
                            break;
                        }
                        else
                        {
                            $sret .= '<a class="number" href="' . $link .   $o . '">' . ($o + 1) . '</a>';
                            $iconta += 1;
                        }
                    }
                }
            }

            if (($selecionda + 1) < $paginas)
            {
                if ($proxima)
                {
                   $sret .= '<a class="proxima" href="' . $link .   ($selecionda + 1) . '">pr&oacute;xima &raquo;</a>';
                }

                if ($ultima)
                {
  		           $sret .= '<a class="ultima" href="' . $link .   ($paginas - 1) . '">&uacute;ltima &raquo; &raquo;</a>';
                }
            }
            else
            {
                if ($proxima)
                {
 	               $sret .= '<span class="proxima">pr&oacute;xima &raquo;</span>';
                }

                if ($ultima)
                {
					$sret .= '<span class="ultima">&uacute;ltima &raquo; &raquo;</span>';
                }
            }
        }

        $sret .= '</td></tr></table>';

        return $sret;
    }

    /**
     * Função que cria paginação
     * 
     * @param string $pg
     * @param int $totalregistro
     * @param int $portela
     * @param string $parametro
     * @param bool $total
     * @param bool $listapaginas
     * @param bool $primeira
     * @param bool $anterior
     * @param bool $proxima
     * @param bool $ultima
     * @access public
     * @return void
     */

    function PaginarFiltro($key, $totalregistro, $portela, $parametro = "",$pagina, $total = true, $listapaginas = true, $primeira = true, $anterior = true, $proxima = true, $ultima = true)
    {
        
        $paginas = ceil($totalregistro / $portela);

        // $selecionda = (isset($_GET[$key])) ? intval($_GET[$key]) : 0;
        $selecionda = ($pagina) ? intval($pagina) : 0;

        $selecionda = ($selecionda > $paginas) ? 0 : $selecionda;

        
        // $paginas = ceil($totalregistro / $portela);
        // $selecionda = (isset($_GET[$key])) ? intval($_GET[$key]) : 0;
        // $selecionda = ($selecionda > $paginas) ? 0 : $selecionda;
        // $link = $_SERVER["PHP_SELF"];

        $sret = "";
        $sret .= '<table class="pagination">';
        $sret .= '<tr>';
        // $sret .= '<td>'.$pagina.'</td>';

        // $sret .= '<td>'.$key.' | '.$totalregistro.' | '.$portela.' | '.$parametro.'</td>';


        if ($total)
        {
            $sret .= "<td class='total'>Total: ( " . $totalregistro . " )</td>";
        }

        $sret .= '<td align="right">';

        if ($paginas > 1)
        {
            if ($selecionda > 0)
            {
                if ($primeira)
                {
                    $sret .= '<a class="primeira"   onclick="getCandidatos()"  >&laquo; &laquo; primeira</a>';
                }
                if ($anterior)
                {
                    $sret .= '<a class="anterior"  onclick="getCandidatos('.($selecionda - 1).')"   >&laquo; anterior</a>';
                }
            }
            else
            {
                if ($primeira)
                {
                    $sret .= '<span class="primeira">&laquo; &laquo; primeira</span>';
                }
                if ($anterior)
                {
                    $sret .= '<span class="anterior">&laquo; anterior</span>';
                }
            }

            if ($listapaginas)
            {
                if ($selecionda > 3)
                {
                    $sret .= '<a class="number" onclick="getCandidatos('.($selecionda - 4).')" >...</a>';
                }

                for ($d = ($selecionda > 3) ? ($selecionda - 3) : 0; $d < $selecionda; $d++)
                {
                    $sret .= '<a class="number"   onclick="getCandidatos('.$d.')"  >' . ($d + 1) . '</a>';
                }

                $iconta = 1;
                for ($o = $selecionda; $o < $paginas; $o++)
                {
                    if ($selecionda == $o)
                    {
                        $sret .= '<span class="number current">' . ($o + 1) . '</span>';
                    }
                    else
                    {
                        if ($iconta > 3)
                        {
                            $sret .= '<a class="number" onclick="getCandidatos('.$o.')" >...</a>';
                            break;
                        }
                        else
                        {
                            $sret .= '<a class="number" onclick="getCandidatos('.$o.')" >' . ($o + 1) . '</a>';
                            $iconta += 1;
                        }
                    }
                }
            }

            if (($selecionda + 1) < $paginas)
            {
                if ($proxima)
                {
                    $sret .= '<a class="proxima" onclick="getCandidatos('.($selecionda + 1).')" >pr&oacute;xima &raquo;</a>';
                }

                if ($ultima)
                {
                    $sret .= '<a class="ultima" onclick="getCandidatos('.($paginas - 1).')" >&uacute;ltima &raquo; &raquo;</a>';
                }
            }
            else
            {
                if ($proxima)
                {
                    $sret .= '<span class="proxima">próxima &raquo;</span>';
                }

                if ($ultima)
                {
                    $sret .= '<span class="ultima">última &raquo; &raquo;</span>';
                }
            }
        }

        $sret .= '</td></tr></table>';

        return $sret;
    }



    /**
     * Função que seta a mensagem
     * 
     * @param string $tipo
     * @param string $mensagem
     * @param string $titulo
     * @access public
     * @return void
     */
    function SetMensagem($tipo, $mensagem = "", $titulo = "")
    {
        $_SESSION["BoxMensagem"] = ((!$_SESSION["BoxMensagem"]) ? array() : $_SESSION["BoxMensagem"]);
        $_SESSION["BoxMensagem"][] = array("Titulo" => $titulo, "Mensagem" => $mensagem, "Tipo" => $tipo);
    }

    /**
     * Função que cria a mensagem
     * 
     * @access public
     * @return bool
     */
    function GetMensagem()
    {
        if (!is_array($_SESSION["BoxMensagem"]))
        {
            return false;
        }
		
		foreach($_SESSION["BoxMensagem"] as $c => $v)
		{
	        $titulo = $v["Titulo"];
	        $msg = $v["Mensagem"];
	        $tipo = $v["Tipo"];
	
	        $mensagem = array();
	
	        // erro
	        $mensagem["Erro"] = array();
	        $mensagem["Erro"]["Titulo"] = "Erro!";
	        $mensagem["Erro"]["Class"] = "notification error png_bg";
	        $mensagem["Erro"]["Mensagem"] = "Ocorreu um erro durante esse processo!";
	
	        // Remover
	        $mensagem["Remover"] = array();
	        $mensagem["Remover"]["Titulo"] = "Confirmado!";
	        $mensagem["Remover"]["Class"] = "notification error png_bg";
	        $mensagem["Remover"]["Mensagem"] = "O <b>Registro</b> foi removido com sucesso!";
	
	        // Editar
	        $mensagem["Editar"] = array();
	        $mensagem["Editar"]["Titulo"] = "Sucesso!";
	        $mensagem["Editar"]["Class"] = "notification success png_bg";
	        $mensagem["Editar"]["Mensagem"] = "<b>Registro</b> editado com sucesso!";
	
	        // Cadastrar
	        $mensagem["Cadastrar"] = array();
	        $mensagem["Cadastrar"]["Titulo"] = "Sucesso!";
	        $mensagem["Cadastrar"]["Class"] = "notification success png_bg";
	        $mensagem["Cadastrar"]["Mensagem"] = "<b>Registro</b> gravado com sucesso!";
	
	        // erro
	        $mensagem["Arquivo"] = array();
	        $mensagem["Arquivo"]["Titulo"] = "Ocorreu um erro durante esse processo! Arquivo inválido!";
	        $mensagem["Arquivo"]["Class"] = "notification attention png_bg";
	        $mensagem["Arquivo"]["Mensagem"] = "";
	
	        // erro
	        $mensagem["Imagem"] = array();
	        $mensagem["Imagem"]["Titulo"] = "Ocorreu um erro durante esse processo! Imagem inválida!";
	        $mensagem["Imagem"]["Class"] = "notification attention png_bg";
	        $mensagem["Imagem"]["Mensagem"] = "";
	
	        if (!$titulo)
	        {
	            $titulo = $mensagem[$tipo]["Titulo"];
	        }
	
	        if (!$msg)
	        {
	            $msg = $mensagem[$tipo]["Mensagem"];
	        }
	
	        #echo '<div class="Mensagem">';
	        echo '<div class="' . $mensagem[$tipo]["Class"] . '">';
	        echo '<div><h4>' . $titulo . '</h4>' . $msg . '</div>';
	        echo '</div>';
        }

        session_unregister("BoxMensagem");

        return true;
    }

    /**
     * Função que pega valores da QueryString
     * 
     * @param array $dif
     * @access public
     * @return string
     */
    function GetQueryString($dif = array())
    {
        $sret = "";
        foreach ($_GET as $chave => $valor)
        {
            if (!in_array($chave, $dif))
            {
                $sret .= $chave . '=' . $valor . "&";
            }
        }
        return $sret;
    }
    
    /**
     * Função que retorna a extensão do arquivo
     * 
     * @param string $Name
     * @access public
     * @return string
     */
    function GetExtensao($Name)
    {
    	return strtolower(end(explode(".", $Name)));
    }
    
    /**
     * Função que retorna um nome de arquivo válido
     * 
     * @param string $local
     * @param string $ext
     * @param string $name
     * @param bool $SaveName
     * @access public
     * @return array
     */
    function ArquivoDisponivel($local, $ext, $name = null, $SaveName = false)
    {
        global $_DIR;
        global $_DIRFILES;

		//endereço
        $path = $_DIRFILES . "/" . $local . "/";

        //cria diretório caso não exista
        $oDiretorio = new diretorio($path);
        $oDiretorio->Criar();

        //verifica arquivo
        $x = false;
        $conta = 0;
        while($x == false)
        {
        	if($SaveName)
        	{
        		if($conta > 0)
        		{
        			$s_ext = $this->GetExtensao($name);
        			$arquivo = $path . str_replace("." . $s_ext, "", $name) . "(" . $conta . ")." . $s_ext;
        		}
        		else
        		{
        			$arquivo = $path . $name;
        		}
        	}
        	else
        	{
        		$name = $this->GerarNome(20);
        		$arquivo = $path . $name . "." . $ext;
        	}
        	
        	$x = !@is_file($arquivo);
        	$conta++;
        }
        
        return array('CaminhoCompleto' => $arquivo,
					 'Caminho' => str_replace($_DIR, "", $arquivo));
    }
    
    
    /**
     * Função que gera chave para formulário
     * 
     * @param string $name
     * @access public
     * @return string
     */
    function GerarChaveForm($name = "")
    {
    	$chave = date('H:i:s').$this->GerarNome(20);
    	$_SESSION["FormChave" . $name] = $chave;
		$_SESSION["time"] = date('H:i:s');
		return '<input type="hidden" id="hidFormChave' . $name . '" name="hidFormChave' . $name . '" value="' . $chave . '" />';
    }
    
    /**
     * Função que verifica chave do formulário
     * 
     * @param methos $Method
     * @param string $name
     * @access public
     * @return bool
     */
    function VerificaChaveForm($Method, $name = ""){
    	if(isset($Method["hidFormChave" . $name])){
			if(isset($_SESSION["FormChave" . $name])){
				if($Method && $Method["hidFormChave" . $name] == $_SESSION["FormChave" . $name]){
					unset($_SESSION["FormChave" . $name]);
					return true;
				}
			}
    	}    	
		return false;
    }
    
    /**
     * Função que força o download
     * 
     * @param string $filename
     * @param string $name
     * @param string $url
     * @access public
     * @return bool
     */
    function ForceDownload($filename, $name, $url = null)
    {
    	if (!file_exists($filename))
		{
			if($url)
			{
				header("Location: " . $url);
			}
			else
			{
				die("Arquivo n&atilde;o encontrado!");
			}
			exit();
		}
		
		$name = ((!$name) ? basename($filename) : $name);		
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
		switch ($file_extension)
		{
			case "pdf": $ctype="application/pdf"; break;
			case "exe": $ctype="application/octet-stream"; break;
			case "zip": $ctype="application/zip"; break;
			case "doc": $ctype="application/msword"; break;
			case "xls": $ctype="application/vnd.ms-excel"; break;
			case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
			case "gif": $ctype="image/gif"; break;
			case "png": $ctype="image/png"; break;
			case "jpe": case "jpeg":
			case "jpg": $ctype="image/jpg"; break;
			default: $ctype="application/force-download";
		}
		@chmod($filename, 0777);
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: $ctype");
		header("Content-Disposition: attachment; filename=\"". $name ."\";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".@filesize($filename));
		@readfile("$filename") or die("Arquivo não encontrado!");
    }
    
    /**
     * Função que busca a url nos parâmetros
     * 
     * @access public
     * @return string
     */
    function GetURL()
    {
		if(!$_SESSION["SiteURL"])
		{
			include_once(dirname(__file__) . "/database/DTO/tparametro.php");
	    	$oParametro = new tparametro();
	    	$_SESSION["SiteURL"] = $oParametro->getParametro("SiteURL");
		}
		return $_SESSION["SiteURL"];
    }
    
    
    /**
     * Função que prepara para url
     * 
     * @param string $Texto
     * @access public
     * @return string
     */
    function PrepareToURL($Texto, $Separador = "+")
    {
    	return strtolower(preg_replace(array("/ /", "/([^a-z+0-9-]+)/i"), array($Separador, ""), trim($this->RemoverAcento($Texto))));
    }
    
    /**
     * Função que gera uma url amigável
     * 
     * @param string $Referencia
     * @param string $Titulo
     * @param string $Local
     * @param string $Extensao
     * @param string $Separador
     * @access public
     * @return string
     */
    function URLAmigavel($Referencia = null, $Titulo = null, $Local, $Extensao = "htm", $Separador = "/")
	{
		$URL = $this->GetURL();
		$Titulo = (($Titulo) ? $this->PrepareToURL($Titulo) . "." . $Extensao : "");
		$Referencia = (($Referencia) ? $Referencia . $Separador : "");
		
		//local
		$Param = "";
		if(is_array($Local))
		{
			foreach($Local as $c => $v)
			{
				$Param .= $this->PrepareToURL($v) . $Separador;
			}
		}
		else
		{
			$Param = $this->PrepareToURL($Local) . $Separador;
		}
		
		return $URL . $Param . $Referencia . $Titulo;
	}

	function localizarIP($ip,$key,$format){
		//API KEY: 1ff5537a3170dbf8c68b907e3af10148c394133850f108bcea3935c29bafad9f
		//raw, xml, json
		$d = file_get_contents("http://api.ipinfodb.com/v3/ip-city/?format=".$format."&key=".$key."&ip=".$ip);
		if (!$d){
			$backup = file_get_contents("http://api.ipinfodb.com/v3/ip-city/?format=".$format."&key=".$key."&".$ip);
			$answer = new SimpleXMLElement($backup);
			if (!$backup) return false; // Failed to open connection
		}else{
			$answer = new SimpleXMLElement($d);
		}
		return $answer;
	}
	
	function montaData($data, $msg='', $mescompleto=false){
		if($data!='0000-00-00 00:00:00'){
			$oUtil = new util();
			$data_array['dia'] = date('d',$oUtil->DataMostrar($data));
			if($mescompleto){
				$data_array['mes'] = strtolower($oUtil->mes[date('n',$oUtil->DataMostrar($data))]);
			}else{
				$data_array['mes'] = strtolower($oUtil->mesabrev[date('n',$oUtil->DataMostrar($data))]);
			}
			$data_array['ano'] = date('Y',$oUtil->DataMostrar($data));
			$data = $data_array['dia'].' de '.$data_array['mes'].' de '.$data_array['ano'];
		}else{
			$data = $msg;
		}
		return $data;
	}

	//Funcao Idade
	function idade($aniver){
		list($dia, $mes, $ano) = explode("/", $aniver);
	
		$hoje = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
		$idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25); 
		return $idade;
	}

	function gerarUrl($string){
		$caracteresPerigosos = array ("&#039;","&quot;"," ","Ã","ã","Õ","õ","á","Á","é","É","í","Í","ó","Ó","ú","Ú","ç","Ç","à","À","è","È","ì","Ì","ò","Ò","ù","Ù","ä","Ä","ë","Ë","ï","Ï","ö","Ö","ü","Ü","Â","Ê","Î","Ô","Û","â","ê","î","ô","û","!","?",",",'"',"'","\"","\\","/","|","´","+",":",".","|","$", "º", "ª", "(", ")","=","%","&amp;","*","@");
		$caracteresLimpos    = array ("","","-","a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u","","","","","","" ,"" ,"","","","","","","","", "", "", "", "","-","por-cento","e","","");

		$string = trim(htmlspecialchars_decode(utf8_encode($string)));
		$string = str_replace($caracteresPerigosos,$caracteresLimpos,$string);
		$string = strtolower($string);
		return $string;
    }

    function correctImageOrientation($filename) {
        if (function_exists('exif_read_data')) {
            $exif = exif_read_data($filename);
            if($exif && isset($exif['Orientation'])) {
            $orientation = $exif['Orientation'];
            if($orientation != 1){
                $img = imagecreatefromjpeg($filename);
                $deg = 0;
                switch ($orientation) {
                case 3:
                    $deg = 180;
                    break;
                case 6:
                    $deg = 270;
                    break;
                case 8:
                    $deg = 90;
                    break;
                }
                if ($deg) {
                $img = imagerotate($img, $deg, 0);
                }
                // then rewrite the rotated image back to the disk as $filename 
                imagejpeg($img, $filename, 95);
            } // if there is some rotation necessary
            } // if have the exif orientation info
        } // if function exists
    }
    //
    function formatCPF_CNPJ($cnpj_cpf){
        if (strlen(preg_replace("/\D/", '', $cnpj_cpf)) === 11) {
            $response = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
        } else {
            $response = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
        }
        return $response;
    }
    
    function validaCPF($cpf) {
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        if (strlen($cpf) != 11) {
            return false;
        }
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;    
    }
}
?>