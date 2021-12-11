<?php

/**
 * Essa � a classe utilizada para validar formul�rios
 

 * @access public
 */
class validacao
{
    /**
     * Vari�vel recebe o nome da sess�o das mensagens de erro
     *  
     * @access private 
     * @var string
     */
    var $nomeSessao = "validacao";

    /**
     * Vari�vel recebe os campos
     *  
     * @access private 
     * @var array
     */
    var $campos = array();

    /**
     * Vari�vel recebe as mensagens de erro
     *  
     * @access public 
     * @var array
     */
    var $mensagens = array();

    /**
     * Vari�vel recebe as mensagens de erro padr�o
     *  
     * @access private 
     * @var array
     */
    var $mensagensPadrao = array('obrigatorio' => 'Campo obrigat�rio.',
								 'email' => 'Digite um e-mail v�lido.',
								 'data' => 'Digite uma data v�lida.',
								 'hora' => 'Digite uma hora v�lida.',
								 'cpf' => 'Digite um CPF v�lido.',
								 'cnpj' => 'Digite um CNPJ v�lido.',
								 'numero' => 'Digite um n�mero v�lido.',
								 'url' => 'Digite uma URL v�lida.',
								 'cep' => 'Digite um CEP v�lido.',
								 'telefone' => 'Digite um telefone v�lido.',
								 'expressao' => 'Campo inv�lido.',
								 'comparar' => 'Campo inv�lido.',
								 'funcao' => 'Campo inv�lido',
								 'minlength' => 'Digite um valor com no m�nimo %s caracteres.',
								 'maxlength' => 'Digite um valor com no m�ximo %s caracteres.',
								 'minvalor' => 'Digite um valor maior ou igual a %s.',
								 'maxvalor' => 'Digite um valor menor ou igual a %s.',
								 'entrelength' => 'Digite um valor entre %s e %s caracteres.',
								 'entrevalor' => 'Digite um valor entre %s e %s.',
								 'dataigual' => 'Digite um data igual %s.',
								 'datamaior' => 'Digite uma data maior que %s.',
								 'datamenor' => 'Digite uma data menor que %s.',
								 'datamaiorigual' => 'Digite uma data maior ou igual que %s.',
								 'datamenorigual' => 'Digite uma data menor ou igual que %s.');

    /**
     * Fun��o que inicia essa classe
     * 
     * @param string $nome
     * @access public 
     * @return void
     */
    function __construct($nome = "")
    {
        @session_start();
        $this->nomeSessao .= $nome;
        $this->mensagens = $this->BuscarMensagem();
    }

    /**
     * Fun��o que adiciona os campos para valida��o
     * 
     * @param string $nome
     * @param string $valor
     * @param bool $obrigatorio
     * @param string $tipo
     * @param string $msg
     * @param string $extra
     * @access public 
     * @return void
     */
    function Adicionar($nome, $valor, $obrigatorio = false, $tipo = null, $msg = null, $extra = null)
    {
        array_push($this->campos, array('nome' => $nome, 
										'valor' => $valor, 
										'obrigatorio' => $obrigatorio, 
										'tipo' => $tipo, 
										'msg' => $msg, 
										'extra' => $extra));
		
		//valida
		$b = true;
        if ($obrigatorio == true)
        {
            $b = $this->ValidarObrigatorio($valor);
        }
        if ($b && $valor != "")
        {
            switch ($tipo)
            {
                case "email": $b = $this->ValidarEmail($valor); break;
                case "data": $b = $this->ValidarData($valor); break;
                case "hora": $b = $this->ValidarHora($valor); break;
                case "cpf": $b = $this->ValidarCPF($valor); break;
                case "cnpj": $b = $this->ValidarCNPJ($valor); break;
                case "numero": $b = $this->ValidarNumero($valor); break;
                case "url": $b = $this->ValidarURL($valor); break;
                case "cep": $b = $this->ValidarCEP($valor); break;
                case "telefone": $b = $this->ValidarTelefone($valor); break;
                case "expressao": $b = $this->ValidarExpressao($extra, $valor); break;
                case "comparar": $b = $this->ValidarComparacao($valor, $extra); break;
                case "funcao": if(function_exists($extra)){ $b = $extra($valor); } break;
                case "minlength"; $b = $this->ValidarMinLength($valor, $extra); break;
                case "maxlength"; $b = $this->ValidarMaxLength($valor, $extra); break;
                case "minvalor"; $b = $this->ValidarMinValor($valor, $extra); break;
                case "maxvalor"; $b = $this->ValidarMaxValor($valor, $extra); break;
                case "entrelength"; $b = $this->ValidarEntreLength($valor, $extra); break;
                case "entrevalor"; $b = $this->ValidarEntreValor($valor, $extra); break;
                case "dataigual"; $b = $this->ValidarDataIgual($valor, $extra); break;
                case "datamaior"; $b = $this->ValidarDataMaior($valor, $extra); break;
                case "datamenor"; $b = $this->ValidarDataMenor($valor, $extra); break;
                case "datamaiorigual"; $b = $this->ValidarDataMaiorIgual($valor, $extra); break;
                case "datamenorigual"; $b = $this->ValidarDataMenorIgual($valor, $extra); break;
            }
        }
        else
        {
            $msg = (($msg != null) ? $msg : $this->mensagensPadrao["obrigatorio"]);
        }
        
        //formata mensagem
        if (!$b)
        {
        	$msg = (($msg != null) ? $msg : $this->mensagensPadrao[$tipo]);
        	switch($tipo)
	    	{
	    		case "minlength": $msg = sprintf($msg, $extra); break;
	            case "maxlength": $msg = sprintf($msg, $extra); break;
	            case "minvalor": $msg = sprintf($msg, $extra); break;
	            case "maxvalor": $msg = sprintf($msg, $extra); break;
	            case "entrelength": $msg = sprintf($msg, $extra[0], $extra[1]); break;
	            case "entrevalor": $msg = sprintf($msg, $extra[0], $extra[1]); break;
	            case "dataigual": $msg = sprintf($msg, $extra); break;
	            case "datamaior": $msg = sprintf($msg, $extra); break;
	            case "datamenor": $msg = sprintf($msg, $extra); break;
	            case "datamaiorigual": $msg = sprintf($msg, $extra); break;
	            case "datamenorigual": $msg = sprintf($msg, $extra); break;
	    	}
	    	$this->mensagens[$nome] = $msg;
        }
    }

    /**
     * Fun��o que executa valida��o
     * 
     * @access public 
     * @return bool
     */
    function Validar()
    {
        return (count($this->mensagens) < 1);
    }
    
    /**
     * Fun��o que adiciona uma mensagem extra de erro
     * 
     * @param string $Nome
     * @param string $Mensagem
     * @access public
     * @return void
     */
    function AddMensagemExtra($Nome, $Mensagem)
    {
    	$this->mensagens[$Nome] = $Mensagem;
    }
    
    /**
     * Fun��o que monta a mensagem de retorno
     * 
     * @param string $titulo
     * @access public
     * @return string
     */
    function MontaMensagem($titulo = "Mensagem")
    {
    	if(count($this->mensagens) > 0)
    	{
    		$m = '
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<h4>Por favor, verifique a(s) mensagen(s) abaixo:</h4>
				<ul>
					<li>' . implode("</li><li>", $this->mensagens) . '</li>
				</ul>
			</div>
			';
				    
			return $m;
    	}
    }


    /**
     * Fun��o que busca as mensagens de erro
     * 
     * @param string $nome
     * @access public
     * @return array
     */
    function BuscarMensagem($nome = null)
    {
        if(!isset($_SESSION[$this->nomeSessao])){
            $_SESSION[$this->nomeSessao] = array();
        }
        if(!isset($_SESSION[$this->nomeSessao]["mensagem"])){
            $_SESSION[$this->nomeSessao]["mensagem"] = array();
        }
        if ($nome != null)
        {
            return $_SESSION[$this->nomeSessao]["mensagem"][$nome];
        }
        else
        {
            return $_SESSION[$this->nomeSessao]["mensagem"];
        }
    }

    /**
     * Fun��o que busca os valores dos campos
     * 
     * @param string $nome
     * @access public
     * @return array
     */
    function BuscarValor($nome = null)
    {
        if ($nome != null)
        {
            return $_SESSION[$this->nomeSessao]["valor"][$nome];
        }
        else
        {
            return $_SESSION[$this->nomeSessao]["valor"];
        }
    }

    /**
     * Fun��o que armazena mensagens de erro e valores dos campos em sess�o
     * 
     * @access public
     * @return void
     */
    function Armazenar()
    {
        $this->Remover();

        foreach ($this->mensagens as $c => $v)
        {
            $_SESSION[$this->nomeSessao]["mensagem"][$c] = $v;
        }

        foreach ($this->campos as $c => $v)
        {
            $_SESSION[$this->nomeSessao]["valor"][$v["nome"]] = $v["valor"];
        }
    }

    /**
     * Fun��o que remove a sess�o
     * 
     * @access public
     * @return void
     */
    function Remover()
    {
        session_unregister($this->nomeSessao);
    }

    /**
     * Methodo de valida��o(obrigat�rio)
     * 
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarObrigatorio($v)
    {
        return (trim($v) != "");
    }

    /**
     * Methodo de valida��o(e-mail)
     * 
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarEmail($v)
    {
        return $this->ValidarExpressao("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,4}$/i", $v);
    }

    /**
     * Methodo de valida��o(data)
     * 
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarData($v)
    {
        $data = explode("/", $v);
        $d = $data[0];
        $m = $data[1];
        $y = $data[2];
        return @checkdate($m, $d, $y);
    }
    
    /**
     * Methodo de valida��o(hora)
     * 
     * @access public
     * @param string $v
     * @return bool
     */
    function ValidarHora($v)
    {
        return $this->ValidarExpressao("/^([0-1][0-9]|[2][0-3]):[0-5][0-9]$/", $v);
    }

    /**
     * Methodo de valida��o(cpf)
     * 
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarCPF($v)
    {
        $cpf = str_pad(preg_replace('[^0-9]', '', $v), 11, '0', STR_PAD_LEFT);

        if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' ||
            $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
        {
            return false;
        }
        else
        {
            for ($t = 9; $t < 11; $t++)
            {
                for ($d = 0, $c = 0; $c < $t; $c++)
                {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cpf{$c} != $d)
                {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Methodo de valida��o(cnpj)
     * 
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarCNPJ($v)
    {
        $cnpj = str_pad(preg_replace('[^0-9]', '', $v), 14, '0', STR_PAD_LEFT);

        if (strlen($cnpj) != 14 || $cnpj == '00000000000000' || $cpf == '11111111111111' || $cpf == '22222222222222' || $cpf == '33333333333333' || $cpf == '44444444444444' || $cpf == '55555555555555' ||
            $cpf == '66666666666666' || $cpf == '77777777777777' || $cpf == '88888888888888' || $cpf == '99999999999999')
        {
            return false;
        }
        else
        {
            for ($t = 12; $t < 14; $t++)
            {
                for ($d = 0, $p = $t - 7, $c = 0; $c < $t; $c++)
                {
                    $d += $cnpj{$c} * $p;
                    $p = ($p < 3) ? 9 : --$p;
                }

                $d = ((10 * $d) % 11) % 10;

                if ($cnpj{$c} != $d)
                {
                    return false;
                }
            }

            return true;
        }
    }

    /**
     * Methodo de valida��o(n�mero)
     * 
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarNumero($v)
    {
        return is_numeric($v);
    }

    /**
     * Methodo de valida��o(url)
     * 
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarURL($v)
    {
        return $this->ValidarExpressao('|^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $v);
    }
    
    /**
     * Methodo de valida��o(cep)
     * 
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarCEP($v)
    {
        return $this->ValidarExpressao('/[0-9]{5}\-[0-9]{3}/', $v);
    }
    
    /**
     * Methodo de valida��o(telefone)
     * 
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarTelefone($v)
    {
        return $this->ValidarExpressao('/^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$/', $v);
    }
    
    /**
     * Methodo de valida��o(express�o)
     * 
     * @param string $expressao
     * @param string $v
     * @access public
     * @return bool
     */
    function ValidarExpressao($expressao, $v)
    {
    	return preg_match($expressao, $v);
    }
    
    /**
     * Methodo de valida��o(compara��o)
     * 
     * @param string $v1
     * @param string $v2
     * @access public
     * @return bool
     */
    function ValidarComparacao($v1, $v2)
    {
    	return ($v1 == $v2);
    }
    
	/**
    * Methodo de valida��o(quantidade de caracteres menor que)
    * 
    * @param string $v1
    * @param int $v2
    * @access public
    * @return bool
    */ 
    function ValidarMinLength($v1, $v2)
	{
		return (strlen($v1) >= $v2);
	}
	
	/**
    * Methodo de valida��o(quantidade de caracteres maior que)
    * 
    * @param string $v1
    * @param int $v2
    * @access public
    * @return bool
    */ 
	function ValidarMaxLength($v1, $v2)
	{
		return (strlen($v1) <= $v2);
	}
	
	/**
    * Methodo de valida��o(valor menor que)
    * 
    * @param string $v1
    * @param string $v2
    * @access public
    * @return bool
    */ 
	function ValidarMinValor($v1, $v2)
	{
		return ($v1 >= $v2);
	}
	
	/**
    * Methodo de valida��o(valor maior que)
    * 
    * @param string $v1
    * @param string $v2
    * @access public
    * @return bool
    */ 
	function ValidarMaxValor($v1, $v2)
	{
		return ($v1 <= $v2);
	}
	
	/**
    * Methodo de valida��o(entre quantidade de caracteres)
    * 
    * @param string $v1
    * @param array $v2
    * @access public
    * @return bool
    */ 
	function ValidarEntreLength($v1, $v2)
	{
		return (strlen($v1) >= $v2[0] && strlen($v1) <= $v2[1]);
	}
	
	/**
    * Methodo de valida��o(entre valores)
    * 
    * @param string $v1
    * @param array $v2
    * @access public
    * @return bool
    */ 
	function ValidarEntreValor($v1, $v2)
	{
		return ($v1 >= $v2[0] && $v1 <= $v2[1]);
	}
	
	/**
    * Methodo de valida��o(datas iguais)
    * 
    * @param string $v1
    * @param array $v2
    * @access public
    * @return bool
    */ 
	function ValidarDataIgual($v1, $v2)
	{
		if(!$this->ValidarData($v1) || !$this->ValidarData($v2))
		{
			return false;
		}
		
		$data1 = explode("/", $v1);
		$data2 = explode("/", $v2);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) == mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
	
	/**
    * Methodo de valida��o(data maior)
    * 
    * @param string $v1
    * @param array $v2
    * @access public
    * @return bool
    */ 
	function  ValidarDataMaior($v1, $v2)
	{
		if(!$this->ValidarData($v1) || !$this->ValidarData($v2))
		{
			return false;
		}
		
		$data1 = explode("/", $v1);
		$data2 = explode("/", $v2);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) > mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
	
	/**
    * Methodo de valida��o(data menor)
    * 
    * @param string $v1
    * @param array $v2
    * @access public
    * @return bool
    */ 
	function  ValidarDataMenor($v1, $v2)
	{
		if(!$this->ValidarData($v1) || !$this->ValidarData($v2))
		{
			return false;
		}
		
		$data1 = explode("/", $v1);
		$data2 = explode("/", $v2);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) < mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
	
	/**
    * Methodo de valida��o(data maior ou igual)
    * 
    * @param string $v1
    * @param array $v2
    * @access public
    * @return bool
    */ 
	function  ValidarDataMaiorIgual($v1, $v2)
	{
		if(!$this->ValidarData($v1) || !$this->ValidarData($v2))
		{
			return false;
		}
		
		$data1 = explode("/", $v1);
		$data2 = explode("/", $v2);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) >= mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
	
	/**
    * Methodo de valida��o(data menor ou igual)
    * 
    * @param string $v1
    * @param array $v2
    * @access public
    * @return bool
    */ 
	function  ValidarDataMenorIgual($v1, $v2)
	{
		if(!$this->ValidarData($v1) || !$this->ValidarData($v2))
		{
			return false;
		}
		
		$data1 = explode("/", $v1);
		$data2 = explode("/", $v2);
		return (mktime(0, 0, 0, $data1[1], $data1[0], $data1[2]) <= mktime(0, 0, 0, $data2[1], $data2[0], $data2[2]));
	}
}

?>