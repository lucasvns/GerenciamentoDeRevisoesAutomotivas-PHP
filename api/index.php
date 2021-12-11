<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Content-Type: application/json; charset=utf-8');


include_once("../admin/alfa/tools/util.php");
include_once("../admin/alfa/tools/cep.php");
include_once("../admin/alfa/tools/validacao.php");
include_once("../admin/alfa/database/DTO/tparameter.php");
include_once("../admin/alfa/tools/uploads/imgupload.class.php");
include_once("../admin/alfa/tools/phpmailer/PHPMailerAutoload.php");
//address
include_once("../admin/alfa/database/DTO/taddress.php");
include_once("../admin/alfa/database/DTO/taddress_district.php");
include_once("../admin/alfa/database/DTO/taddress_state.php");
include_once("../admin/alfa/database/DTO/taddress_city.php");
//admin
include_once("../admin/alfa/database/DTO/tadmin.php");
//user
include_once("../admin/alfa/database/DTO/tclientes.php");
include_once("../admin/alfa/database/DTO/trevisao.php");
include_once("../admin/alfa/database/DTO/tveiculos.php");


class Wex{

var $ukey;
var $json = array();
var $day_week = array(
	'',
	'Domingo',
	'Segunda-feira',
	'Terça-feira',
	'Quarta-feira',
	'Quinta-feira',
	'Sexta-feira',
	'Sábado'
);
var $day_period = array(
	'',
	'Manhã',
	'Tarde',
	'Noite'
);
var $os_type = array(
	'',
	'Coleta',
	'Entrega'
);

function __construct() {
   $this->ukey = md5('eder+igor+wex=gg');
}

function getVeiculo($post_array){
	if(isset($post_array['cliente_id']) && $post_array['cliente_id'] != ""){
		$oVeiculos = new tveiculos();
		$oVeiculos->SQL_WHERE = 'cliente_id = '.$post_array['cliente_id'];
		$oVeiculos->LoadSQL();
		if($oVeiculos->RowsCount){
			$veiculos = array();
			for ($i=0; $i < $oVeiculos->RowsCount; $i++) {
				array_push($veiculos, array(
					'id'=>$oVeiculos->id,
					'modelo'=>$oVeiculos->modelo
				));
				$oVeiculos->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "veiculos";
			$this->json['veiculos'] 	= $veiculos;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Veiculo não encontrado";
		}
	}elseif(isset($post_array['cliente']) && $post_array['cliente'] != ""){

		$oVeiculos = new tveiculos();
		$oVeiculos->SQL_WHERE = 'cliente_id = '.$post_array['cliente'];
		$oVeiculos->LoadSQL();
		if($oVeiculos->RowsCount){

			$veiculos = array();
			for ($i=0; $i < $oVeiculos->RowsCount; $i++) {
				array_push($veiculos, array(
					'id'=>$oVeiculos->id,
					'cliente_id'=>$oVeiculos->cliente_id,
					'valor'=>$oVeiculos->valor,
					'ano_fabricacao'=>$oVeiculos->ano_fabricacao,
					'modelo'=>$oVeiculos->modelo,
					'numero_placa'=>$oVeiculos->numero_placa
				));
				$oVeiculos->MoveNext();
			}

			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "veiculos";
			$this->json['veiculos'] 	= $veiculos;

		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Veiculo não encontrado";
		}
	}


}

function setVeiculo($post_array){
	if(isset($post_array['cliente_id']) && $post_array['cliente_id']!=''){

		$oVeiculos = new tveiculos();
		$oVeiculos->cliente_id		= $post_array['cliente_id'];
		$oVeiculos->valor 			= $post_array['valor'];	
		$oVeiculos->ano_fabricacao	= $post_array['ano_fabricacao'];
		$oVeiculos->numero_placa	= $post_array['numero_placa'];
		$oVeiculos->modelo 			= $post_array['modelo'];

		$oVeiculos->AddNew();
		$oVeiculos->Save();

		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Veiculo Cadastrado";
	
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
	
}


function removeVeiculo($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$oVeiculos = new tveiculos();
		$oVeiculos->LoadByPrimaryKey($post_array['id']);
		if($oVeiculos->RowsCount){
			$oVeiculos->MarkAsDelete();
			$oVeiculos->Save();
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Veiculo removido";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Veiculo encontrado";
		}
	}
}


}

//
$oRegister = new Wex();
$_fn = isset($_GET['fn'])?$_GET['fn']:'';

$request = $_POST;

switch($_fn){ 
	case 'getVeiculo':
		$oRegister->getVeiculo($request);
		break;
	case 'removeVeiculo':
		$oRegister->removeVeiculo($request);
		break;
	case 'setVeiculo':
		$oRegister->setVeiculo($request);
		break;
	default:
		echo 'error';
		break;
}


//Retorna a requisicao
if(sizeof($oRegister->json)>0){
	echo indent(json_encode($oRegister->json));
}

function getMsg($json){
	echo indent(json_encode($json));
	die();	
}

function indent($json) {

	$result      = '';
	$pos         = 0;
	$strLen      = strlen($json);
	$indentStr   = '  ';
	$newLine     = "\n";
	$prevChar    = '';
	$outOfQuotes = true;

	for ($i=0; $i<=$strLen; $i++) {
		$char = substr($json, $i, 1);
		if ($char == '"' && $prevChar != '\\') {
			$outOfQuotes = !$outOfQuotes;
		} else if(($char == '}' || $char == ']') && $outOfQuotes) {
			$result .= $newLine;
			$pos --;
			for ($j=0; $j<$pos; $j++) {
				$result .= $indentStr;
			}
		}
		$result .= $char;
		if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
			$result .= $newLine;
			if ($char == '{' || $char == '[') {
				$pos ++;
			}

			for ($j = 0; $j < $pos; $j++) {
				$result .= $indentStr;
			}
		}

		$prevChar = $char;
	}

	return $result;
}

function rad($x) {
	return $x * M_PI / 180;
}

function getDistance($lat1,$lng1,$lat2,$lng2) {
	$R = 6378137;
	$dLat = rad($lat2 - $lat1);
	$dLong = rad($lng2- $lng1);
	$a = sin($dLat / 2) * sin($dLat / 2) + cos(rad($lat1)) * cos(rad($lat2)) * sin($dLong / 2) * sin($dLong / 2);
	$c = 2 * atan2 (sqrt($a), sqrt(1 - $a));
	$d = $R * $c;
	return $d;
};

function reArrayFiles(&$file_post) {

	$file_ary = array();
	$file_count = count($file_post['name']);
	$file_keys = array_keys($file_post);

	for ($i=0; $i<$file_count; $i++) {
		foreach ($file_keys as $key) {
			$file_ary[$i][$key] = $file_post[$key][$i];
		}
	}

	return $file_ary;
}


function sendMail($emails_destino = array(), $assunto, $msg){

$mail = new PHPMailer();
$mail->CharSet = "UTF-8";
$mail->IsSMTP();
$mail->Host = "smtp.zoho.com";
$mail->SMTPAuth = true;
$mail->Username = 'no-reply@wexdigital.com.br';
$mail->Password = 'S45@fs54sSf';
$mail->SMTPDebug = false;
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';

$mail->From = "no-reply@wexdigital.com.br";
$mail->Sender = "no-reply@wexdigital.com.br";
$mail->FromName = "App Dr Odonto";

//adiciona os emails
foreach($emails_destino as $key=>$value){
	$mail->AddAddress($value);
}

$mail->IsHTML(true);
$mail->Subject  = $assunto;
$mail->Body = $msg;
$mail->AltBody = '';

$mail->Send();
$mail->ClearAllRecipients();
$mail->ClearAttachments();

}


function validaCPF($cpf = null) {
 
	// Verifica se um número foi informado
	if(empty($cpf)) {
		return false;
	}
 
	// Elimina possivel mascara
	$cpf = preg_replace('[^0-9]', '', $cpf);
	$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);
	 
	// Verifica se o numero de digitos informados é igual a 11 
	if (strlen($cpf) != 11) {
		return false;
	}
	// Verifica se nenhuma das sequências invalidas abaixo 
	// foi digitada. Caso afirmativo, retorna falso
	else if ($cpf == '00000000000' || 
		$cpf == '11111111111' || 
		$cpf == '22222222222' || 
		$cpf == '33333333333' || 
		$cpf == '44444444444' || 
		$cpf == '55555555555' || 
		$cpf == '66666666666' || 
		$cpf == '77777777777' || 
		$cpf == '88888888888' || 
		$cpf == '99999999999') {
		return false;
	 // Calcula os digitos verificadores para verificar se o
	 // CPF é válido
	 } else {   
		 
		for ($t = 9; $t < 11; $t++) {
			 
			for ($d = 0, $c = 0; $c < $t; $c++) {
				$d += $cpf{$c} * (($t + 1) - $c);
			}
			$d = ((10 * $d) % 11) % 10;
			if ($cpf{$c} != $d) {
				return false;
			}
		}
 
		return true;
	}
}


function mask($val, $mask)
{
 $maskared = '';
 $k = 0;
 for($i = 0; $i<=strlen($mask)-1; $i++)
 {
 if($mask[$i] == '#')
 {
 if(isset($val[$k]))
 $maskared .= $val[$k++];
 }
 else
 {
 if(isset($mask[$i]))
 $maskared .= $mask[$i];
 }
 }
 return $maskared;
}



