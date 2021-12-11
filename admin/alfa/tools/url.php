<?php
/**
 * Essa é a classe utilizada para criar vídeos do url
 * @access public
 */
class url
{
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
    function __construct()
    {
    }

    /**
     * Função que acerta url do url
     * 
     * @access private
     * @return void
     */
    function gerarUrl($string)
    {

		$caracteresPerigosos = array ("&#039;","&quot;"," ","Ã","ã","Õ","õ","á","Á","é","É","í","Í","ó","Ó","ú","Ú","ç","Ç","à","À","è","È","ì","Ì","ò","Ò","ù","Ù","ä","Ä","ë","Ë","ï","Ï","ö","Ö","ü","Ü","Â","Ê","Î","Ô","Û","â","ê","î","ô","û","!","?",",",'"',"'","\"","\\","/","|","´","+",":",".","|","$", "º", "ª", "(", ")","=","%","&amp;","*","@");
		$caracteresLimpos    = array ("","","-","a","a","o","o","a","a","e","e","i","i","o","o","u","u","c","c","a","a","e","e","i","i","o","o","u","u","a","a","e","e","i","i","o","o","u","u","A","E","I","O","U","a","e","i","o","u","","","","","","" ,"" ,"","","","","","","","", "", "", "", "","-","por-cento","e","","arroba");

		$this->URL = trim(htmlspecialchars_decode(utf8_encode($string)));
		$this->URL = str_replace($caracteresPerigosos,$caracteresLimpos,$this->URL);
		$this->URL = strtolower($this->URL);
		return $this->URL;
    }
    
    public static function slugify($text){
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
      $text = preg_replace('~[^-\w]+~', '', $text);
      $text = trim($text, '-');
      $text = preg_replace('~-+~', '-', $text);
      $text = strtolower($text);
      if (empty($text)) {
        return 'n-a';
      }
      return $text;
    }

}
?>