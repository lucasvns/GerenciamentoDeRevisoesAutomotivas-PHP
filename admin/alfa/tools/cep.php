<?php

require_once (dirname(__file__) . "/util.php");

/**
 * Essa é a classe utilizada para pesquisar cep
 * @author ClickNow <suporte@clicknow.com.br>
 * @copyright Copyright (c) 2008, ClickNow
 * @access public
 */
class cep extends util
{
    /**
     * Variável recebe o tipo de logradouro
     *  
     * @access public 
     * @var bool
     */
    var $address_street_type = "";

    /**
     * Variável recebe o logradouro
     *  
     * @access public 
     * @var bool
     */
    var $address_street = "";

    /**
     * Variável recebe o bairro
     *  
     * @access public 
     * @var bool
     */
    var $address_district = "";

    /**
     * Variável recebe o cidade
     *  
     * @access public 
     * @var bool
     */
    var $address_city = "";

    /**
     * Variável recebe o estado
     *  
     * @access public 
     * @var bool
     */
    var $address_state = "";

    /**
     * Variável recebe o resultado
     *  
     * @access public 
     * @var bool
     */
    var $result = "";

    /**
     * Função que inicia essa classe
     * 
     * @param string $CEP
     * @access public 
     * @return void
     */
    function cep($CEP)
    {
        $resultado = $this->LoadURL('http://republicavirtual.com.br/web_cep.php?cep=' . urlencode(str_replace("-", "", $CEP)) . '&formato=jsonp');
        $resultado= json_decode($resultado, TRUE);
        if ($resultado['resultado']){
            $this->address_street_type = $resultado['tipo_logradouro'];
            $this->address_street = ($resultado['logradouro']);
            $this->address_district = ($resultado['bairro']);
            $this->address_city = $resultado['cidade'];
            $this->address_state = $resultado['uf'];
            $this->status = true;
        }else{
            $this->status = false;
        }
    }
    
    /**
     * Função que retorna conteúdo da página
     * 
     * @param string $url
     * @param array $options
     * @access public
     * @return string
     */
    function LoadURL($url, $options = array('method' => 'get', 'return_info' => false))
    {
        $url_parts = parse_url($url);
        $info = array(
            'http_code' => 200);
        $response = '';

        $send_header = array('Accept' => 'text/*', 'User-Agent' => 'BinGet/1.00.A (http://www.bin-co.com/php/scripts/load/)');

        if (function_exists("curl_init") and (!(isset($options['use']) and $options['use'] == 'fsocketopen')))
        {
            if (isset($options['method']) and $options['method'] == 'post')
            {
                $page = $url_parts['scheme'] . '://' . $url_parts['host'] . $url_parts['path'];
            }
            else
            {
                $page = $url;
            }

            $ch = curl_init($url_parts['host']);

            curl_setopt($ch, CURLOPT_URL, $page);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
            curl_setopt($ch, CURLOPT_HEADER, true); 
            curl_setopt($ch, CURLOPT_NOBODY, false);
            if (isset($options['method']) and $options['method'] == 'post' and $url_parts['query'])
            {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $url_parts['query']);
            }
            curl_setopt($ch, CURLOPT_USERAGENT, $send_header['User-Agent']);
            $custom_headers = array("Accept: " . $send_header['Accept']);
            if (isset($options['modified_since']))
                array_push($custom_headers, "If-Modified-Since: " . gmdate('D, d M Y H:i:s \G\M\T', strtotime($options['modified_since'])));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);
            curl_setopt($ch, CURLOPT_COOKIEJAR, "cookie.txt");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            if (isset($url_parts['user']) and isset($url_parts['pass']))
            {
                $custom_headers = array("Authorization: Basic " . base64_encode($url_parts['user'] . ':' . $url_parts['pass']));

                curl_setopt($ch, CURLOPT_HTTPHEADER, $custom_headers);
            }

            $response = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);
        }
        else
        {
            if (isset($url_parts['query']))
            {
                if (isset($options['method']) and $options['method'] == 'post')
                    $page = $url_parts['path'];
                else
                    $page = $url_parts['path'] . '?' . $url_parts['query'];
            }
            else
            {
                $page = $url_parts['path'];
            }

            $fp = fsockopen($url_parts['host'], 80, $errno, $errstr, 30);
            if ($fp)
            {
                $out = '';
                if (isset($options['method']) and $options['method'] == 'post' and isset($url_parts['query']))
                {
                    $out .= "POST $page HTTP/1.1\r\n";
                }
                else
                {
                    $out .= "GET $page HTTP/1.0\r\n";
                }
                $out .= "Host: $url_parts[host]\r\n";
                $out .= "Accept: $send_header[Accept]\r\n";
                $out .= "User-Agent: {$send_header['User-Agent']}\r\n";
                if (isset($options['modified_since']))
                    $out .= "If-Modified-Since: " . gmdate('D, d M Y H:i:s \G\M\T', strtotime($options['modified_since'])) . "\r\n";

                $out .= "Connection: Close\r\n";

                if (isset($url_parts['user']) and isset($url_parts['pass']))
                {
                    $out .= "Authorization: Basic " . base64_encode($url_parts['user'] . ':' . $url_parts['pass']) . "\r\n";
                }

                if (isset($options['method']) and $options['method'] == 'post' and $url_parts['query'])
                {
                    $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
                    $out .= 'Content-Length: ' . strlen($url_parts['query']) . "\r\n";
                    $out .= "\r\n" . $url_parts['query'];
                }
                $out .= "\r\n";

                fwrite($fp, $out);
                while (!feof($fp))
                {
                    $response .= fgets($fp, 128);
                }
                fclose($fp);
            }
        }

        $headers = array();

        if ($info['http_code'] == 404)
        {
            $body = "";
            $headers['Status'] = 404;
        }
        else
        {
            $separator_position = strpos($response, "\r\n\r\n");
            $header_text = substr($response, 0, $separator_position);
            $body = substr($response, $separator_position + 4);

            foreach (explode("\n", $header_text) as $line)
            {
                $parts = explode(": ", $line);
                if (count($parts) == 2)
                    $headers[$parts[0]] = chop($parts[1]);
            }
        }

        if ($options['return_info'])
            return array('headers' => $headers, 'body' => $body, 'info' => $info);
        return $body;
    }
}
?>