<?php
// Passando os dados obtidos pelo formulário para as variáveis abaixo
$nomeremetente     = trim($_POST['name']);
$emailremetente    = trim($_POST['email']);
$emaildestinatario = 'contato@rm07.com.br';
$assunto           = 'Mensagem de Contato de: '.$emailremetente;
$mensagem          = $_POST['message'];


if(!isset($mensagem)) die("N&atilde;o recebi nenhum par&acitc;metro. Por favor volte ao formulario.html antes");
$emailsender = "contato@" . $_SERVER[HTTP_HOST];

/* Verifica qual é o sistema operacional do servidor para ajustar o cabeçalho de forma correta. Não alterar */
if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");

/* Montando a mensagem a ser enviada no corpo do e-mail. */
$mensagemHTML = '<P>Email recebido do formulário de Contato: '.date('d/m/Y H:i').'</P>
<h3>Nome:</h3>
<p>'.$nomeremetente.'</p>

<h3>Email:</h3>
<p>'.$emailremetente.'</p>

<h3>Mensagem:</h3>
<p>'.$mensagem.'</p>
<hr>';

/* Montando o cabeçalho da mensagem */
$headers = "MIME-Version: 1.1".$quebra_linha;
$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
// Perceba que a linha acima contém "text/html", sem essa linha, a mensagem não chegará formatada.
$headers .= "From: ".$emailsender.$quebra_linha;
$headers .= "Return-Path: " . $emailsender . $quebra_linha;
// Esses dois "if's" abaixo são porque o Postfix obriga que se um cabeçalho for especificado, deverá haver um valor.
// Se não houver um valor, o item não deverá ser especificado.
if(strlen($comcopia) > 0) $headers .= "Cc: ".$comcopia.$quebra_linha;
if(strlen($comcopiaoculta) > 0) $headers .= "Bcc: ".$comcopiaoculta.$quebra_linha;
$headers .= "Reply-To: ".$emailremetente.$quebra_linha;
// Note que o e-mail do remetente será usado no campo Reply-To (Responder Para)

/* Enviando a mensagem */
if(mail($emaildestinatario, $assunto, $mensagemHTML, $headers, "-r". $emailsender)){
	echo "success";
}else{
	echo "failed";
}
?>
