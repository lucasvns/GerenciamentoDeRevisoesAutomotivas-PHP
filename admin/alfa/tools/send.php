<?php
class Email{

//Dados Contato
var $contato_nome;
var $contato_email;
var $contato_fone;
var $contato_msg;
//Dados Site
var $email_site;
var $email_destinatario;
var $email_assunto;
var $comcopia;
var $comcopiaoculta;
var $retorno;

//Envia o e-mail
function sendMail(){
	if(eregi('tempsite.ws$|locaweb.com.br$|hospedagemdesites.ws$|websiteseguro.com$', $_SERVER['HTTP_HOST'])){
		$emailsender = $this->email_site;
	}else{
		$emailsender = "contato@" . $_SERVER['HTTP_HOST'];
	}
	if(PATH_SEPARATOR == ";") $quebra_linha = "\r\n";
	else $quebra_linha = "\n";
	
	$mensagemHTML = '
	<h1>Contato</h1>
	<table width="100%" border="1" cellspacing="1">
		<tr>
			<td colspan="3" style="padding:10px"><strong>Data:</strong> '.date('d/m/Y H:i:s').'</td>
		</tr>
		<tr>
			<td style="padding:10px"><strong>Nome:</strong> '.$this->contato_nome.'</td>
			<td style="padding:10px"><strong>E-mail:</strong> '.$this->contato_email.'</td>
			<td style="padding:10px"><strong>Telefone:</strong> '.$this->contato_fone.'</td>
		</tr>
		<tr>
			<td colspan="3" style="padding:10px"><strong>Mensagem:</strong> '.(html_entity_decode($this->contato_msg)).'</td>
		</tr>
	</table>
	';
	$headers = "MIME-Version: 1.1" .$quebra_linha;
	$headers .= "Content-type: text/html; charset=iso-8859-1" .$quebra_linha;
	$headers .= "From: ". $emailsender . $quebra_linha;
	$headers .= "Cc: " . $this->comcopia . $quebra_linha;
	$headers .= "Bcc: " . $this->comcopiaoculta . $quebra_linha;
	$headers .= "Reply-To: " . $emailsender . $quebra_linha;
	if(mail($this->email_destinatario, $this->email_assunto, $mensagemHTML, $headers ,"-r".$emailsender)){
		$this->retorno = array("status"=>1,"msg"=>"Mensagem enviada com sucesso!");
	}else{
		$headers .= "Return-Path: " . $emailsender . $quebra_linha;
		if(!mail($this->email_destinatario, $this->email_assunto, $mensagemHTML, $headers )){
			$this->retorno = array("status"=>0,"msg"=>"Falha no envio, tente novamente");
		}
	}
}//sendMail()

}//class Email