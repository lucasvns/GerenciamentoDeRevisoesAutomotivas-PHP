<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

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


function getEmpresa($post_array){
	if(isset($post_array['id'])){
		$oEmp = new tempresa();
		$oEmp->SQL_WHERE = "emp_cnpj LIKE '%".$post_array['id']."%' OR emp_nome LIKE '%".$post_array['id']."%'";
		$oEmp->LoadSQL();
		if($oEmp->RowsCount){
			$_emp = array(
				'id'=>$oEmp->id,
				'emp_nome'=>$oEmp->emp_nome,
				'emp_cnpj'=>$oEmp->emp_cnpj,
				'emp_cont'=>$oEmp->emp_cont,
				'emp_contcpf'=>$oEmp->emp_contcpf,
				'emp_email'=>$oEmp->emp_email,
				'address_street'=>$oEmp->address_street,
				'address_district'=>$oEmp->address_district,
				'address_city'=>$oEmp->address_city,
				'address_state'=>$oEmp->address_state,
				'address_number'=>$oEmp->address_number,
				'address_reference'=>$oEmp->address_reference,
				'address_code'=>$oEmp->address_code,
				'emp_razs'=>$oEmp->emp_razs,
				'emp_contnasc'=>$oEmp->emp_contnasc,
				'emp_emailf'=>$oEmp->emp_emailf,
				'emp_estgcep'=>$oEmp->emp_estgcep,
				'emp_estgrua'=>$oEmp->emp_estgrua,
				'emp_estgbairro'=>$oEmp->emp_estgbairro,
				'emp_estgcidad'=>$oEmp->emp_estgcidad,
				'emp_estguf'=>$oEmp->emp_estguf,
				'emp_estgnum'=>$oEmp->emp_estgnum,
				'emp_estgcomple'=>$oEmp->emp_estgcomple,
				'emp_tell'=>$oEmp->emp_tell

			);
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Empresa";
			$this->json['user'] 	= $_emp;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Empresa inexistente";
		}
	}else{
		$_emp = array();
		$oEmp = new tempresa();
		$oEmp->SQL_ORDER = ' emp_nome ASC ';
		$oEmp->LoadSQL();
		if($oEmp->RowsCount){
			for ($i=0; $i < $oEmp->RowsCount; $i++) {
				array_push($_emp, array(
					'id'=>$oEmp->id,
					'emp_nome'=>$oEmp->emp_nome,
					'emp_cnpj'=>$oEmp->emp_cnpj,
					'emp_cont'=>$oEmp->emp_cont,
					'emp_contcpf'=>$oEmp->emp_contcpf,
					'emp_email'=>$oEmp->emp_email,
					'address_street'=>$oEmp->address_street,
					'address_district'=>$oEmp->address_district,
					'address_city'=>$oEmp->address_city,
					'address_state'=>$oEmp->address_state,
					'address_number'=>$oEmp->address_number,
					'address_reference'=>$oEmp->address_reference,
					'address_code'=>$oEmp->address_code,
					'emp_razs'=>$oEmp->emp_razs,
					'emp_contnasc'=>$oEmp->emp_contnasc,
					'emp_emailf'=>$oEmp->emp_emailf,
					'emp_estgcep'=>$oEmp->emp_estgcep,
					'emp_estgrua'=>$oEmp->emp_estgrua,
					'emp_estgbairro'=>$oEmp->emp_estgbairro,
					'emp_estgcidad'=>$oEmp->emp_estgcidad,
					'emp_estguf'=>$oEmp->emp_estguf,
					'emp_estgnum'=>$oEmp->emp_estgnum,
					'emp_estgcomple'=>$oEmp->emp_estgcomple,
					'emp_tell'=>$oEmp->emp_tell
				));
				$oEmp->MoveNext();
			}
		}
		$this->json = $_emp;
	}
}

function setCandidatoExp($post_array){
	if(isset($post_array['cand_id']) && $post_array['cand_id']!=''){


		$Ocandevag = new tcand_exp();

		if($post_array['edit'] != ""){
			$Ocandevag->SQL_WHERE = 'id = '.$post_array['edit'];
			$Ocandevag->LoadSQL();
			$verifi = 1;
		}else{
			$Ocandevag->SQL_WHERE = 'cand_id = "'.$post_array['cand_id'].'"'.'AND cand_cargo = "'.$post_array['cand_cargo'].'"';
			$Ocandevag->LoadSQL();
			$verifi = 0;
		}
		
		if($Ocandevag->RowsCount == $verifi){
			
			$Ocandevag->cand_id		= $post_array['cand_id'];
			$Ocandevag->cand_emp 	= $post_array['cand_emp'];	
			$Ocandevag->cand_nsuper	= $post_array['cand_nsuper'];
			$Ocandevag->cand_cargo	= $post_array['cand_cargo'];
			$Ocandevag->cand_emapt 	= $post_array['cand_emapt'];
			$Ocandevag->cand_dent 	= $post_array['cand_dent'];	
			$Ocandevag->cand_dsai 	= $post_array['cand_dsai'];	
			$Ocandevag->cand_att 	= $post_array['cand_att'];	

			if($post_array['edit'] == ""){
				$Ocandevag->AddNew();
			}

			$Ocandevag->Save();

			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Experiência Cadastrada";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Experiência já Cadastrada";
		}
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
	
}

function getCandidatoExp($post_array){
	//update
	if(isset($post_array['cand_id']) && $post_array['cand_id']!=''){
		$oCand = new tcand_exp();
		$oCand->SQL_WHERE = ' cand_id = '.$post_array['cand_id'];
		$oCand->LoadSQL();
		if($oCand->RowsCount){
			//
			$cand = array();
			for ($i=0; $i < $oCand->RowsCount ; $i++) { 
				//district
				$oCande = new tcand_exp();
				$oCande->LoadByPrimaryKey($oCand->cand_id);
				
				$full_address = 'oi';
				array_push(
					$cand, 
					array(
						'id'=>$oCand->id,
                        'cand_id'=>$oCand->cand_id,
                        'cand_emp'=>$oCand->cand_emp,
                        'cand_nsuper'=>$oCand->cand_nsuper,
                        'cand_cargo'=>$oCand->cand_cargo,
                        'cand_emapt'=>$oCand->cand_emapt,
                        'cand_dent'=>$oCand->cand_dent,
                        'cand_dsai'=>$oCand->cand_dsai,
						'cand_att'=>$oCand->cand_att,
						'full_address'=>$full_address,
					)
				);
				//
				$oCand->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Candidato";
			$this->json['cand'] 		= $cand;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Endereço não encontrado";
		}
	}
}


function removeCandidatoExp($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$Ocande = new tcand_exp();
		$Ocande->LoadByPrimaryKey($post_array['id']);
		if($Ocande->RowsCount){
			$Ocande->MarkAsDelete();
			$Ocande->Save();
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Experiencia  removida";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Experiencia encontrada";
		}
	}
}
function setUserAddress($post_array){
	//update
	if(isset($post_array['tuser_id']) && $post_array['tuser_id']!='' && isset($post_array['id']) && $post_array['id']!=''){
		$oAddress = new taddress();
		$oAddress->LoadByPrimaryKey($post_array['id']);
		if($oAddress->RowsCount){
			//
			$oAddress->Save();
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Disponibilidade atualizada";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Disponibilidade não encontrada";
		}
	}
	//create
	elseif(isset($post_array['tuser_id']) && $post_array['tuser_id']!=''){
		//`id`, `tuser_id`, `taddress_district_id`, `code`, `street`, `number`, `reference`, `latitude`, `longitude`
		//state
		$oAddressState = new taddress_state();
		$oAddressState->SQL_WHERE = ' abrev = "'.$post_array['state'].'" ';
		$oAddressState->LoadSQL();
		if($oAddressState->RowsCount==0){
			$oAddressState = new taddress_state();
			$oAddressState->abrev = $post_array['state'];
			$oAddressState->name = $post_array['state'];
			$oAddressState->AddNew();
			$oAddressState->Save();
		}
		//city
		$oAddressCity = new taddress_city();
		$oAddressCity->SQL_WHERE = ' name = "'.$post_array['city'].'" ';
		$oAddressCity->LoadSQL();
		if($oAddressCity->RowsCount==0){
			$oAddressCity = new taddress_city();
			$oAddressCity->name = $post_array['city'];
			$oAddressCity->taddress_state_id = $oAddressState->id;
			$oAddressCity->AddNew();
			$oAddressCity->Save();
		}
		//district
		$oAddressDistrict = new taddress_district();
		$oAddressDistrict->SQL_WHERE = ' name = "'.$post_array['district'].'" ';
		$oAddressDistrict->LoadSQL();
		if($oAddressDistrict->RowsCount==0){
			$oAddressDistrict = new taddress_district();
			$oAddressDistrict->name = $post_array['district'];
			$oAddressDistrict->taddress_city_id = $oAddressCity->id;
			$oAddressDistrict->AddNew();
			$oAddressDistrict->Save();
		}

		$oAddress = new taddress();
		$oAddress->tuser_id = $post_array['tuser_id'];
		$oAddress->code = $post_array['code'];
		$oAddress->street = $post_array['street'];
		$oAddress->number = $post_array['number'];
		$oAddress->reference = $post_array['reference'];
		$oAddress->taddress_district_id = $oAddressDistrict->id;
		$oAddress->AddNew();
		$oAddress->Save();
		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Endereço criado";
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}
function getUserAddress($post_array){
	//update
	if(isset($post_array['tuser_id']) && $post_array['tuser_id']!=''){
		$oAddress = new taddress();
		$oAddress->SQL_WHERE = ' tuser_id = '.$post_array['tuser_id'];
		$oAddress->LoadSQL();
		if($oAddress->RowsCount){
			$address = array();
			for ($i=0; $i < $oAddress->RowsCount ; $i++) { 
				//district
				$oAddressDistrict = new taddress_district();
				$oAddressDistrict->LoadByPrimaryKey($oAddress->taddress_district_id);
				//city
				$oAddressCity = new taddress_city();
				$oAddressCity->LoadByPrimaryKey($oAddressDistrict->taddress_city_id);
				//state
				$oAddressState = new taddress_state();
				$oAddressState->LoadByPrimaryKey($oAddressCity->taddress_state_id);
				$reference = ($oAddress->reference!='')?$oAddress->reference.', ':'';
				$full_address = 
				$oAddress->street.', '.
				$oAddress->number.', '.
				$reference.
				$oAddressDistrict->name.', '.
				$oAddressCity->name.'-'.
				$oAddressState->abrev;
				array_push(
					$address, 
					array(
						'id'=>$oAddress->id,
						'code'=>$oAddress->code,
						'street'=>$oAddress->street,
						'number'=>$oAddress->number,
						'reference'=>$oAddress->reference,
						'district'=>$oAddressDistrict->name,
						'city'=>$oAddressCity->name,
						'state'=>$oAddressState->abrev,
						'full_address'=>$full_address,
					)
				);
				$oAddress->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Endereço";
			$this->json['address'] = $address;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Endereço não encontrado";
		}
	}
}
function removeUserAddress($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$oAddress = new taddress();
		$oAddress->LoadByPrimaryKey($post_array['id']);
		if($oAddress->RowsCount){
			$oAddress->MarkAsDelete();
			$oAddress->Save();
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Endereço removida";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Endereço não encontrada";
		}
	}
}

function array_insert(&$array, $index, $value){
	return $array = array_merge(array_splice($array, max(0, $index - 1)), array($value), $array);
}


function setEmpresaAddress($post_array){
	//update
	if(isset($post_array['tempresa_id']) && $post_array['tempresa_id']!='' && isset($post_array['id']) && $post_array['id']!=''){
		$oAddress = new taddress();
		$oAddress->LoadByPrimaryKey($post_array['id']);
		if($oAddress->RowsCount){
			//
			$oAddress->Save();
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Disponibilidade atualizada";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Disponibilidade não encontrada";
		}
	}
	//create
	elseif(isset($post_array['tempresa_id']) && $post_array['tempresa_id']!=''){
		//`id`, `tempresa_id`, `taddress_district_id`, `code`, `street`, `number`, `reference`, `latitude`, `longitude`
		//state
		$oAddressState = new taddress_state();
		$oAddressState->SQL_WHERE = ' abrev = "'.$post_array['state'].'" ';
		$oAddressState->LoadSQL();
		if($oAddressState->RowsCount==0){
			$oAddressState = new taddress_state();
			$oAddressState->abrev = $post_array['state'];
			$oAddressState->name = $post_array['state'];
			$oAddressState->AddNew();
			$oAddressState->Save();
		}
		//city
		$oAddressCity = new taddress_city();
		$oAddressCity->SQL_WHERE = ' name = "'.$post_array['city'].'" ';
		$oAddressCity->LoadSQL();
		if($oAddressCity->RowsCount==0){
			$oAddressCity = new taddress_city();
			$oAddressCity->name = $post_array['city'];
			$oAddressCity->taddress_state_id = $oAddressState->id;
			$oAddressCity->AddNew();
			$oAddressCity->Save();
		}
		//district
		$oAddressDistrict = new taddress_district();
		$oAddressDistrict->SQL_WHERE = ' name = "'.$post_array['district'].'" ';
		$oAddressDistrict->LoadSQL();
		if($oAddressDistrict->RowsCount==0){
			$oAddressDistrict = new taddress_district();
			$oAddressDistrict->name = $post_array['district'];
			$oAddressDistrict->taddress_city_id = $oAddressCity->id;
			$oAddressDistrict->AddNew();
			$oAddressDistrict->Save();
		}

		$oAddress = new taddress();
		$oAddress->tempresa_id = $post_array['tempresa_id'];
		$oAddress->code = $post_array['code'];
		$oAddress->street = $post_array['street'];
		$oAddress->number = $post_array['number'];
		$oAddress->reference = $post_array['reference'];
		$oAddress->taddress_district_id = $oAddressDistrict->id;
		$oAddress->AddNew();
		$oAddress->Save();
		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Endereço criado";
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}
function getEmpresaAddress($post_array){
	//update
	if(isset($post_array['tempresa_id']) && $post_array['tempresa_id']!=''){
		$oAddress = new taddress();
		$oAddress->SQL_WHERE = ' tempresa_id = '.$post_array['tempresa_id'];
		$oAddress->LoadSQL();
		if($oAddress->RowsCount){
			$address = array();
			for ($i=0; $i < $oAddress->RowsCount ; $i++) { 
				//district
				$oAddressDistrict = new taddress_district();
				$oAddressDistrict->LoadByPrimaryKey($oAddress->taddress_district_id);
				//city
				$oAddressCity = new taddress_city();
				$oAddressCity->LoadByPrimaryKey($oAddressDistrict->taddress_city_id);
				//state
				$oAddressState = new taddress_state();
				$oAddressState->LoadByPrimaryKey($oAddressCity->taddress_state_id);
				$reference = ($oAddress->reference!='')?$oAddress->reference.', ':'';
				$full_address = 
				$oAddress->street.', '.
				$oAddress->number.', '.
				$reference.
				$oAddressDistrict->name.', '.
				$oAddressCity->name.'-'.
				$oAddressState->abrev;
				array_push(
					$address, 
					array(
						'id'=>$oAddress->id,
						'code'=>$oAddress->code,
						'street'=>$oAddress->street,
						'number'=>$oAddress->number,
						'reference'=>$oAddress->reference,
						'district'=>$oAddressDistrict->name,
						'city'=>$oAddressCity->name,
						'state'=>$oAddressState->abrev,
						'full_address'=>$full_address,
					)
				);
				$oAddress->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Endereço";
			$this->json['address'] = $address;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Endereço não encontrado";
		}
	}
}
function removeEmpresaAddress($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$oAddress = new taddress();
		$oAddress->LoadByPrimaryKey($post_array['id']);
		if($oAddress->RowsCount){
			$oAddress->MarkAsDelete();
			$oAddress->Save();
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Endereço removida";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Endereço não encontrada";
		}
	}
}
function getCidade($post_array){
	if(isset($post_array['cid_nome'])){
		$oCid = new tcidades();
		$oCid->LoadByPrimaryKey($post_array['cid_nome']);
		if($oCid->RowsCount){
			$_cid = array(
				'id'=>$oCid->id,
				'cid_nome'=>$oCid->cid_nome,
				'cid_estado'=>$oCid->cid_estado
			);
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Cidade";
			$this->json['user'] 	= $_cid;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Cidade inexistente";
		}
	}else{
		$_cid = array();
		$oCid = new tcidades();
		$oCid->SQL_ORDER = ' cid_nome ASC ';
		$oCid->LoadSQL();
		if($oCid->RowsCount){
			for ($i=0; $i < $oCid->RowsCount; $i++) {
				array_push($_cid, array(
					'id'=>$oCid->id,
					'cid_nome'=>$oCid->cid_nome,
					'cid_estado'=>$oCid->cid_estado
				));
				$oCid->MoveNext();
			}
		}
		$this->json = $_cid;
	}
}

function getInstitu($post_array){
	if(isset($post_array['inst_cnpj'])){
		$oInsti = new tinstituicao();
		$oInsti->LoadByPrimaryKey($post_array['inst_cnpj']);
		if($oInsti->RowsCount){
			$_insti = array(
				'id'=>$oInsti->id,
				'inst_nome'=>$oInsti->inst_nome,
				'inst_cnpj'=>$oInsti->inst_cnpj,
				'inst_cont'=>$oInsti->inst_cont,
				'inst_email'=>$oInsti->inst_email,
				'inst_tell'=>$oInsti->inst_tell,
				'address_code'=>$oInsti->address_code,
				'address_street'=>$oInsti->address_street,
				'address_number'=>$oInsti->address_number,
				'address_reference'=>$oInsti->address_reference,
				'address_district'=>$oInsti->address_district,
				'address_city'=>$oInsti->address_city,
				'address_state'=>$oInsti->address_state,
				'address_country'=>$oInsti->address_country
			);
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Instituicao";
			$this->json['user'] 	= $_insti;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Instiuicao inexistente";
		}
	}else{
		$_insti = array();
		$oInsti = new tinstituicao();
		$oInsti->SQL_ORDER = ' inst_cnpj ASC ';
		$oInsti->LoadSQL();
		if($oInsti->RowsCount){
			for ($i=0; $i < $oInsti->RowsCount; $i++) {
				array_push($_insti, array(
					'id'=>$oInsti->id,
					'inst_nome'=>$oInsti->inst_nome,
					'inst_cnpj'=>$oInsti->inst_cnpj,
					'inst_cont'=>$oInsti->inst_cont,
					'inst_email'=>$oInsti->inst_email,
					'inst_tell'=>$oInsti->inst_tell,
					'address_code'=>$oInsti->address_code,
					'address_street'=>$oInsti->address_street,
					'address_number'=>$oInsti->address_number,
					'address_reference'=>$oInsti->address_reference,
					'address_district'=>$oInsti->address_district,
					'address_city'=>$oInsti->address_city,
					'address_state'=>$oInsti->address_state,
					'address_country'=>$oInsti->address_country
				));
				$oInsti->MoveNext();
			}
		}
		$this->json = $_insti;
	}
}
function getCurso($post_array){
	if(isset($post_array['cur_nome'])){
		$oCurs = new tcurso();
		$oCurs->LoadByPrimaryKey($post_array['cur_nome']);
		if($oCurs->RowsCount){
			$_curs = array(
				'id'=>$oCurs->id,
				'cur_nome'=>$oCurs->cur_nome
			);
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Curso";
			$this->json['user'] 	= $_curs;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Curso inexistente";
		}
	}else{
		$_curs = array();
		$oCurs = new tcurso();
		$oCurs->SQL_ORDER = ' cur_nome ASC ';
		$oCurs->LoadSQL();
		if($oCurs->RowsCount){
			for ($i=0; $i < $oCurs->RowsCount; $i++) {
				array_push($_curs, array(
					'id'=>$oCurs->id,
					'cur_nivel'=>$oCurs->cur_nivel,
					'cur_dura'=>$oCurs->cur_dura,
					'cur_nome'=>$oCurs->cur_nome
				));
				$oCurs->MoveNext();
			}
		}
		$this->json = $_curs;
	}
}
function setAcademicas($post_array){

	if(isset($post_array['cand_id']) && $post_array['cand_id']!=''){


		$oCandAcademi = new tacademicas();

		if($post_array['edit'] != ""){
			$oCandAcademi->SQL_WHERE = 'id = '.$post_array['edit'];
			$oCandAcademi->LoadSQL();
		}
		

		
		$oCandAcademi->cand_id = $post_array['cand_id'];
		$oCandAcademi->cand_cidestu = $post_array['cand_cidestu'];		
		$oCandAcademi->cand_nvlesc = $post_array['cand_nvlesc'];			
		$oCandAcademi->cand_insti	= $post_array['cand_insti']; 			
		$oCandAcademi->cand_instio	 = $post_array['cand_instio'];			
		$oCandAcademi->cand_regestu = $post_array['cand_regestu'];			
		$oCandAcademi->cand_cursoestu = $post_array['cand_cursoestu'];		
		$oCandAcademi->cand_cursoestuo= $post_array['cand_cursoestuo']; 		
		$oCandAcademi->cand_anoinse = $post_array['cand_anoinse'];		
		$oCandAcademi->cand_periodo = $post_array['cand_periodo'];			
		$oCandAcademi->cand_anocur = $post_array['cand_anocur'];	
		$oCandAcademi->cand_semes = $post_array['cand_semes'];	

		$oCandAcademi->padrao = $post_array['padrao'];

		$oCandAcademi->cand_mesentrada = $post_array['cand_mesentrada'];	
		$oCandAcademi->cand_conclusem = $post_array['cand_conclusem'];	
		$oCandAcademi->cand_concluano = $post_array['cand_concluano'];			
		$oCandAcademi->cand_cursextra = $post_array['cand_cursextra'];	

		
		$oAcad = new tacademicas();
		$oAcad->SQL_WHERE = 'cand_id = '.$post_array['cand_id'].' AND padrao = "padrao" ';
		$oAcad->LoadSQL();
		if($oAcad->RowsCount){
			if($post_array['padrao'] != ""){
				for ($i=0; $i < $oAcad->RowsCount ; $i++) { 
					$oAcad->padrao = "";
					$oAcad->Save();	
					$oAcad->MoveNext();
				}
			}
		}else{
			$oCandAcademi->padrao ="padrao";		
		}
		
		  	
        if($post_array['edit'] == ""){
			$oCandAcademi->AddNew();
		}
		
		$oCandAcademi->Save();
		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Experiencia Academica Cadastrada";
	// }else{
	// 	$this->json['status'] 	= 400;
	// 	$this->json['msg'] 		= "Experiencia Academica já Cadastrada";
	// }
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}

	
}

function getAcademicas($post_array){
	//update
	if(isset($post_array['cand_id']) && $post_array['cand_id']!=''){
		$oAcad = new tacademicas();
		$oAcad->SQL_WHERE = ' cand_id = '.$post_array['cand_id'];
		$oAcad->LoadSQL();
		if($oAcad->RowsCount){
			$Acad = array();
			for ($i=0; $i < $oAcad->RowsCount ; $i++) {

			
				if($oAcad->cand_cidestu != ""){
					$oCidades = new tcidades();
					$oCidades->LoadByPrimaryKey($oAcad->cand_cidestu);
					$cidade = $oCidades->cid_nome;
				}else{
					$cidade = "";
				}


				if($oAcad->cand_insti != ""){
					$oInstituicao = new tinstituicao();
					$oInstituicao->LoadByPrimaryKey($oAcad->cand_insti);
					$nome_inst = $oInstituicao->inst_nome;
				}else{
					$nome_inst = "";
				}

				$nome_curso = "";
				$nome_curso_outro = "" ;


			
				$oCandidato = new tcandidato();
				$oCandidato->LoadByPrimaryKey($post_array['cand_id']);
			

				if($oAcad->cand_cursoestu != ""){
					$oCurso = new tcurso();
					$oCurso->LoadByPrimaryKey($oAcad->cand_cursoestu);
					$nome_curso = $oCurso->cur_nome;
					$duracao_curso = $oCurso->cur_dura;
					
				}else{
					$nome_curso_outro = $oAcad->cand_cursoestuo;
				}
				

				if($oAcad->cand_insti != "" || $oAcad->cand_insti != "-1"){
					$instituicao = $oInstituicao->inst_nome;
				}else{
					$instituicao = $oAcad->cand_instio;
				}

				$ano = explode('-',$oCandidato->date_created);
	
				$data = date('Y');
						
				$date = $data - $ano[0];

				$ano_atual = $oAcad->cand_anoinse[0] + $date;

				$escolaridade = $oAcad->cand_nvlesc;


				if($escolaridade == "medio"){
					$nome_curso = "Ensino Médio";
					$ano_atual = $ano_atual."º Ano";
				}
			
				if($escolaridade == "medio" && $ano_atual > 3){
					$ano_atual = "Possivelmente Formado";
				}



				if($escolaridade != "medio"){

					$mes_atual = (int) date('m');
			
				
					$semestre_conclusão = $oAcad->cand_conclusem[0];
			
			
					if($oAcad->cand_concluano < $data ){

						$ano_atual = "Possivelmente Formado"; 
				
					}elseif($data == $oAcad->cand_concluano) {
						
						if($mes_atual ==  $semestre_conclusão){
							$ano_atual = "Possivelmente Formado"; 
						}else{

							$ano_candidato = $oAcad->cand_concluano  - $data;

			
							if($mes_atual >= 1  && $mes_atual <= 6 ){
							
								$semestres_faltantes = ($ano_candidato * 2) + 1;
				
								$ano = explode('-',$oCandidato->date_created);
				
								$ano_inserido = $oAcad->cand_anoinse[0] * 2;
				
								$total =  ($oAcad->cand_concluano - $ano[0]) * 2;  
							
								$date = $ano_inserido + $total ;
				
								$ano_atual = $date - $semestres_faltantes."º Semestre";
				
				
							}
				
							if($mes_atual >= 7  && $mes_atual <= 12 ){
									
								$semestres_faltantes = ($ano_candidato * 2);
				
								$ano = explode('-',$oCandidato->date_created);
				
								$ano_inserido = $oAcad->cand_anoinse[0] * 2;
				
								$total =  ($oAcad->cand_concluano - $ano[0]) * 2;  
							
								$date = $ano_inserido + $total ;
				
								$ano_atual = $date - $semestres_faltantes."º Semestre";
				
							}
			
						}
			
						
					}else{
			
						$ano_candidato = $oAcad->cand_concluano  - $data;
						
						if($mes_atual >= 1  && $mes_atual <= 6 ){
							
							$semestres_faltantes = ($ano_candidato * 2) + 1;
			
							$ano = explode('-',$oCandidato->date_created);
			
							$ano_inserido = $oAcad->cand_anoinse[0] * 2;
			
							$total =  ($oAcad->cand_concluano - $ano[0]) * 2;  
						
							$date = $ano_inserido + $total ;
			
							$ano_atual = $date - $semestres_faltantes."º Semestre";
			
			
						}
			
						if($mes_atual >= 7  && $mes_atual <= 12 ){
								
							$semestres_faltantes = ($ano_candidato * 2);
			
							$ano = explode('-',$oCandidato->date_created);
			
							$ano_inserido = $oAcad->cand_anoinse[0] * 2;
			
							$total =  ($oAcad->cand_concluano - $ano[0]) * 2;  
						
							$date = $ano_inserido + $total ;
			
							$ano_atual = $date - $semestres_faltantes."º Semestre";
			
						}
						
					}
					
				}






				
				$informacoes_escolares = 
				'<b>Cidade: </b>'.$cidade.'<br>'.
				'<b>Região: </b>'.$oAcad->cand_regestu.'<br>'.
				'<b>Período: </b>'.$oAcad->cand_periodo.'<br>'.
				'<b>Nivel: </b> Ensino '.$oAcad->cand_nvlesc.'<br>'.
				'<b>Previsão de Conclusão: </b>'.$oAcad->cand_conclusem.' de '.$oAcad->cand_concluano.'<br>'.
				'<b>Ano Atual: </b>'.$ano_atual;

				array_push(
					$Acad, 
					array(
                        'id'=>$oAcad->id,
						'cand_id'=>$oAcad->cand_id,
						'informacoes_escolares'=>$informacoes_escolares,
						'cand_cidestu'=>$oAcad->cand_cidestu,
						'cand_insti'=>$nome_inst,
						'cand_cursoestuo'=>$nome_curso_outro,
                        'cand_cursoestu'=>$nome_curso,
					)
				);
				$oAcad->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Endereço";
			$this->json['Acad'] = $Acad;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Endereço não encontrado";
		}
	}
}




function editCandidatoExp($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$oAcad = new tcand_exp();
		$oAcad->SQL_WHERE = ' id = '.$post_array['id'];
		$oAcad->LoadSQL();
		if($oAcad->RowsCount){
			$edita = array();
			for ($i=0; $i < $oAcad->RowsCount ; $i++) { 
				
				array_push(
					$edita, 
					array(
                        'id'=>$oAcad->id,
						'cand_emp'=>$oAcad->cand_emp,
						'cand_nsuper'=>$oAcad->cand_nsuper,
						'cand_cargo'=>$oAcad->cand_cargo,
						'cand_emapt'=>$oAcad->cand_emapt,
						'cand_instio'=>$oAcad->cand_instio,
						'cand_dent'=>$oAcad->cand_dent,
						'cand_dsai'=>$oAcad->cand_dsai,
						'cand_att'=>$oAcad->cand_att,
						'edit_exp'=>$oAcad->edit_exp,
				
					)
				);
				$oAcad->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "não encontrada";
			$this->json['edita']	= $edita;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Endereço não encontrado";
		}
	}
}

function editAcademicas($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$oAcad = new tacademicas();
		$oAcad->SQL_WHERE = ' id = '.$post_array['id'];
		$oAcad->LoadSQL();
		if($oAcad->RowsCount){
			$edita = array();
			for ($i=0; $i < $oAcad->RowsCount ; $i++) { 



				if($oAcad->cand_cidestu != ""){
					$oCidades = new tcidades();
					$oCidades->LoadByPrimaryKey($oAcad->cand_cidestu);
					$cidade = $oCidades->cid_nome;
				}else{
					$cidade = "";
				}


				if($oAcad->cand_insti != ""){
					$oInstituicao = new tinstituicao();
					$oInstituicao->LoadByPrimaryKey($oAcad->cand_insti);
					$nome_inst = $oInstituicao->inst_nome;
				}else{
					$nome_inst = "";
				}


				if($oAcad->cand_cursoestu != ""){
					$oCurso = new tcurso();
					$oCurso->LoadByPrimaryKey($oAcad->cand_cursoestu);
					$nome_curso = $oCurso->cur_nome;
				}else{
					$nome_curso = "";
				}
				
				
				array_push(
					$edita, 
					array(
                        'id'=>$oAcad->id,
						'cand_id'=>$oAcad->cand_id,
						'cand_cidestu'=>$cidade,
						'cand_nvlesc'=>$oAcad->cand_nvlesc,
						'cand_insti'=>$nome_inst,
						'cand_instio'=>$oAcad->cand_instio,
						'cand_anocur'=>$oAcad->cand_anocur,
						'cand_regestu'=>$oAcad->cand_regestu,
						'cand_cursoestu'=>$nome_curso,
						'cand_cursoestuo'=>$oAcad->cand_cursoestuo,
						'cand_anoinse'=>$oAcad->cand_anoinse,
						'cand_periodo'=>$oAcad->cand_periodo,
						'cand_semes'=>$oAcad->cand_semes,
						'cand_concluano'=>$oAcad->cand_concluano,
						'padrao'=>$oAcad->padrao,
						'cand_conclusem'=>$oAcad->cand_conclusem,
						'cand_mesentrada'=>$oAcad->cand_mesentrada,
						'cand_cursextra'=>$oAcad->cand_cursextra,
						'cand_cidestu_id'=>$oAcad->cand_cidestu,
						'cand_cursoestu_id'=>$oAcad->cand_cursoestu,
						'cand_insti_id'=>$oAcad->cand_insti
					)
				);
				$oAcad->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "não encontrada";
			$this->json['edita']	= $edita;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Endereço não encontrado";
		}
	}
}

function removeAcademicas($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$oAcad = new tacademicas();
		$oAcad->LoadByPrimaryKey($post_array['id']);
		if($oAcad->RowsCount){
			$oAcad->MarkAsDelete();
			$oAcad->Save();
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Experiencia  removida";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Experiencia encontrada";
		}
	}
}


function getCandidato($post_array){
	if(isset($post_array['cand_nome'])){
		$ocandt = new tcandidato();
		$ocandt->LoadByPrimaryKey($post_array['cand_nome']);
		if($ocandt->RowsCount){
			$_ocandt = array(
				'id'=>$ocandt->id,
				'cand_nome'=>$ocandt->cand_nome,
				'cand_nasc'=>$ocandt->cand_nasc,
                'cand_rg'=>$ocandt->cand_rg,
                'cand_cpf'=>$ocandt->cand_cpf,
                'cand_telefone'=>$ocandt->cand_telefone,
                'cand_celular'=>$ocandt->cand_celular,
                'cand_email'=>$ocandt->cand_email,
                'cand_rua'=>$ocandt->cand_rua,
                'cand_bairro'=>$ocandt->cand_bairro,
                'cand_cidade'=>$ocandt->cand_cidade,
				'cand_uf'=>$ocandt->cand_uf,
				'cand_nvlesc'=>$ocandt->cand_nvlesc,
                'cand_num'=>$ocandt->cand_num
			);
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Candidato";
			$this->json['user'] 	= $_ocandt;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Candidato inexistente";
		}
	}else{
		$_ocandt = array();
		$ocandt = new tcandidato();
		$ocandt->SQL_ORDER = ' cand_nome ASC ';
		$ocandt->LoadSQL();
		if($ocandt->RowsCount){
			for ($i=0; $i < $ocandt->RowsCount; $i++) {
				array_push($_ocandt, array(
					'id'=>$ocandt->id,
					'cand_nome'=>$ocandt->cand_nome,
					'cand_nasc'=>$ocandt->cand_nasc,
                    'cand_rg'=>$ocandt->cand_rg,
                    'cand_cpf'=>$ocandt->cand_cpf,
                    'cand_telefone'=>$ocandt->cand_telefone,
                    'cand_celular'=>$ocandt->cand_celular,
                    'cand_email'=>$ocandt->cand_email,
                    'cand_rua'=>$ocandt->cand_rua,
                    'cand_bairro'=>$ocandt->cand_bairro,
                    'cand_cidade'=>$ocandt->cand_cidade,
                    'cand_uf'=>$ocandt->cand_uf,
                    'cand_num'=>$ocandt->cand_num
				));
				$ocandt->MoveNext();
			}
		}
		$this->json = $_ocandt;
	}
}
function setCandidatoVaga($post_array){
	if(isset($post_array['vag_id']) && $post_array['vag_id']!=''){

		$Ocandevag = new tcand_vaga();
		$Ocandevag->SQL_WHERE = 'vag_id = "'.$post_array['vag_id'].'"'.'AND cand_id = "'.$post_array['cand_id'].'"';
		$Ocandevag->LoadSQL();
	
		
		$Ocandevag2 = new tvagas();
		$Ocandevag2->LoadByPrimaryKey($post_array['vag_id']);

		//sub_situacao 

		$empresaid = $Ocandevag2->emp_cnpj_id;
		
		$oEmpresa= new tempresa();
		$oEmpresa->LoadByPrimaryKey($empresaid);

		$empresaadress = $oEmpresa->emp_estgcidad;
		
		$oCancity= new tcandidato();
		$oCancity->LoadByPrimaryKey($post_array['cand_id']);
		
		$cidade = $oCancity->cand_cidade;

		if($Ocandevag->RowsCount == 0){
		
			$Ocandevag->cand_id = $post_array['cand_id'];
			$Ocandevag->vag_id = $post_array['vag_id'];
			$Ocandevag->qualificado = $post_array['qualificado'];
			

			$Ocandevag->AddNew();
			$Ocandevag->Save();
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Candidato Adicionado";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Candidato já se Candidatou a Vaga";
		}
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}

function updateSituacao($post_array){
	if(isset($post_array['id']) && $post_array['id']!=''){

		$Ocandevagup = new tcand_vaga();
		$Ocandevagup->SQL_WHERE = 'id = '.$post_array['id'];
		$Ocandevagup->LoadSQL();
		if($post_array['situacao'] == "SemInt"){
			if($Ocandevagup->RowsCount){
				$Ocandevagup->MarkAsDelete();
				$Ocandevagup->Save();
			}
		}else{
			$Ocandevagup->situacao = $post_array['situacao'];
			$Ocandevagup->situacao_retorno = $post_array['situacao'];
			$Ocandevagup->Save();

		}

		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Situação Alterada";
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}

function updateRetorno($post_array){
	if(isset($post_array['id']) && $post_array['id']!=''){

		$Ocandevagup = new tcand_vaga();
		$Ocandevagup->SQL_WHERE = 'id = '.$post_array['id'];
		$Ocandevagup->LoadSQL();

		$Ocandevagup->retorno = $post_array['retorno'];
		$Ocandevagup->Save();

		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Retorno Alterado";
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}

function updateAprovado($post_array){
	if(isset($post_array['id']) && $post_array['id']!=''){
		$Ocande = new tcand_vaga();
		$Ocande->SQL_WHERE = 'id = '.$post_array['id'];
		$Ocande->LoadSQL();

		$oCandidto= new tcandidato();
		$oCandidto->SQL_WHERE = 'id = '.$Ocande->cand_id;
		$oCandidto->LoadSQL();

		if($post_array['situacao_final'] != ""){
			$Ocande->situacao_final = $post_array['situacao_final'];	
		}

		if($post_array['sub_situacao'] != ""){
			$oCandidto->cand_obs = $post_array['obs'] ;
			$Ocande->sub_situacao = $post_array['sub_situacao']; 

			if($post_array['sub_situacao'] == "Aprovado"){
				$Ocande->situacao = "Selecionado";
			}
			
			$oCandidto->Save();
		}
		
		$Ocande->Save();
		

		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Situação Alterada";
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}


function updateDataHorario($post_array){
	if(isset($post_array['id']) && $post_array['id']!=''){
		$Ocande = new tcand_vaga();
		$Ocande->SQL_WHERE = 'id = '.$post_array['id'];
		$Ocande->LoadSQL();
		
		if($post_array['condicao'] == "1"){
			if($post_array['data'] != ""){
				$Ocande->dia_entre = $post_array['data'];
			}
			if($post_array['horario'] != ""){
				$Ocande->hora_entre = $post_array['horario'];
			}
			if($post_array['resp'] != ""){
				$Ocande->resp = $post_array['resp'];
			}	
		}

		
		if($post_array['condicao'] == "2"){
			if($post_array['data'] != ""){
				$Ocande->dia_entre_emp = $post_array['data'];
			}
			if($post_array['horario'] != ""){
				$Ocande->hora_entre_emp = $post_array['horario'];
			}
			if($post_array['resp_emp'] != ""){
				$Ocande->resp_emp = $post_array['resp_emp'];
			}
		}
		$Ocande->Save();

		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Horário e Data Alterados Alterada";
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}

function getCandidatoVaga($post_array){
	//update
	if(isset($post_array['vag_id']) && $post_array['vag_id']!=''){
		$oCandevag = new tcand_vaga();
		if(isset($post_array['situacao']) && $post_array['situacao'] != ""){
			if ($post_array['situacao'] == 1){
				$sit = "Processo";
			}
			if ($post_array['situacao'] == 2){
				$sit = "Selecionado";
			}
			$oCandevag->SQL_WHERE = 'vag_id = "'.$post_array['vag_id'].'"'.'AND situacao = "'.$sit.'"';
		}else{
			$oCandevag->SQL_WHERE = 'vag_id = "'.$post_array['vag_id'].'"'.'AND qualificado = "'.$post_array['qualificado'].'"';
		}
		$oCandevag->LoadSQL(); 
		if($oCandevag->RowsCount){
			//
			$candvag = array();
		
			for ($i=0; $i < $oCandevag->RowsCount ; $i++) { 

				$oCande = new tcandidato();
				$oCande->LoadByPrimaryKey($oCandevag->cand_id);

				$situacao = $oCandevag->situacao;				

				$numero = "";
				if($oCande->cand_telefone != ""){
					$numero = $oCande->cand_telefone;
				}
				if($oCande->cand_celular != ""){
					$numero = $oCande->cand_celular;
				}

				$hora_entre = $oCandevag->hora_entre;
				if($hora_entre == ""){
					$hora_entre = "SELECIONE";
				}	

				$dia_entre = $oCandevag->dia_entre;

				
				if($dia_entre == ""){
					$dia_entre = "SELECIONE";
				}	


				if($oCandevag->situacao_final == ""){
					$situacao_final = "Aguardando";
				}
				if($oCandevag->situacao_final == "NAprovado"){
					$situacao_final = "Não Aprovado";
				}
				if($oCandevag->situacao_final == "NAcompareceu"){
					$situacao_final = "Não Compareceu";
				}
				if($oCandevag->situacao_final == "Aprovado"){
					$situacao_final = $oCandevag->situacao_final;
				}

				 

				if($oCandevag->sub_situacao ==""){
					$sub_situacao = "Aguardando";
				}
				if($oCandevag->sub_situacao =="NAprovado"){
					$sub_situacao = "Não Aprovado";
				}
				if($oCandevag->sub_situacao =="Aprovado"){
					$sub_situacao = $oCandevag->sub_situacao;
				}

				if($situacao == ""){
					$situacao = "Selecione";
				}
				
				if($situacao == "SemInt" ){
					$situacao = "Sem Interesse";
					$sub_situacao = "Aguardando";
				}
				if($situacao == "Cvnao" ){
					$situacao = "Cv não selecionado";
					$situacao_final = "Aguardando";
				}
				
				$celular = preg_replace("/[^0-9]/","",$oCande->cand_celular); 
				
				$hora_entre_emp = $oCandevag->hora_entre_emp;
				if($hora_entre_emp == ""){
					$hora_entre_emp = "SELECIONE";
				}	

				$dia_entre_emp = $oCandevag->dia_entre_emp;
				if($dia_entre_emp == ""){
					$dia_entre_emp = "SELECIONE";
				}	

				$resp = $oCandevag->resp;
				if($resp == ""){
					$resp = "SELECIONE";
				}	

				$resp_emp = $oCandevag->resp_emp;
				if($resp_emp == ""){
					$resp_emp = "SELECIONE";
				}	

				if($oCande->cand_obs == ""){
					$candobs = "";
				}else{
					$candobs =$oCande->cand_obs;
				}


				$oUtil = new util();

				

				if($oCandevag->situacao != "Cvnao"){
					if($oCandevag->situacao != "SemInt" ){
						if($oCandevag->situacao_final != "NAprovado" ){						
							array_push(
								$candvag, 
								array(   
									'id_token'=>$oUtil->Criptografar($oCandevag->cand_id),
									'id'=>$oCandevag->id,
									'vagaid'=>$oCandevag->vag_id,
									'dia_entre_emp'=>$dia_entre_emp,
									'hora_entre_emp'=>$hora_entre_emp,
									'dia_entre'=>$dia_entre,
									'resp'=>$resp,
									'resp_emp'=>$resp_emp,
									'hora_entre'=>$hora_entre,
									'cand_id'=>$oCandevag->cand_id,
									'vag_id'=>$oCandevag->vag_id,
									'qualificado'=>$oCandevag->qualificado,
									'sub_situacao'=>$sub_situacao,
									'situacao_final'=>$situacao_final,
									'situacao'=>$situacao,
									'cand_nome'=>$oCande->cand_nome,
									'candobs'=>$candobs,
									'cand_email'=>$oCande->cand_email,
									'cand_cpf'=>$oCande->cand_cpf,
									'cand_sexo'=>$oCande->cand_sexo,
									'cand_rg'=>$oCande->cand_rg,
									'cand_nacional'=>$oCande->cand_nacional,
									'cand_natu'=>$oCande->cand_natu,
									'cand_telefone'=>$oCande->cand_telefone,
									'cand_celular'=>$oCande->cand_celular,
									'celular'=>$celular,
									'cand_especial'=>$oCande->cand_especial,
									'cand_tipoespecial'=>$oCande->cand_tipoespecial,
									'cand_resumo'=>$oCande->cand_resumo,
									'cand_cep'=>$oCande->cand_cep,
									'cand_rua'=>$oCande->cand_rua,
									'cand_bairro'=>$oCande->cand_bairro,
									'cand_cidade'=>$oCande->cand_cidade,
									'cand_uf'=>$oCande->cand_uf,
									'cand_comple'=>$oCande->cand_comple,
									'cand_num'=>$oCande->cand_num,
									'cand_nasc'=>$oCande->cand_nasc,
									'numero'=>$numero,

								)
							);
					}
				}
			}
				//
				$oCandevag->MoveNext();
			// }
		}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Candidato";
			$this->json['candvag'] 		= $candvag;
		
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Candidato não encontrado";
		}
	}
}

function getCandidatoVaga2($post_array){
	//update
	if(isset($post_array['cand_id']) && $post_array['cand_id']!=''){
		$oCandevag = new tcand_vaga();
		$oCandevag->SQL_WHERE = 'cand_id = '.$post_array['cand_id'];
		$oCandevag->LoadSQL();
		if($oCandevag->RowsCount){
			//
			$candvag2 = array();
			for ($i=0; $i < $oCandevag->RowsCount ; $i++) { 
				//district
				$oCande = new tcandidato();
				$oCande->LoadByPrimaryKey($oCandevag->cand_id);
				
				$full_info = 
				'Nome: '.$oCande->cand_nome.' - '.
				'Email: '.$oCande->cand_email.' - '.
				'CPF: '.$oCande->cand_cpf;
				array_push(
					$candvag2, 
					array(
						'id'=>$oCandevag->id,
                        'cand_id'=>$oCandevag->cand_id,
                        'vag_id'=>$oCandevag->vag_id,
						'full_info'=>$full_info,
						'cand_nome'=>$oCande->cand_nome,
						'cand_email'=>$oCande->cand_email,
						'cand_cpf'=>$oCande->cand_cpf,
						'cand_sexo'=>$oCande->cand_sexo,
						'cand_rg'=>$oCande->cand_rg,
						'cand_nacional'=>$oCande->cand_nacional,
						'cand_natu'=>$oCande->cand_natu,
						'cand_telefone'=>$oCande->cand_telefone,
						'cand_celular'=>$oCande->cand_celular,
						'cand_especial'=>$oCande->cand_especial,
						'cand_tipoespecial'=>$oCande->cand_tipoespecial,
						'cand_resumo'=>$oCande->cand_resumo,
						'cand_cep'=>$oCande->cand_cep,
						'cand_rua'=>$oCande->cand_rua,
						'cand_bairro'=>$oCande->cand_bairro,
						'cand_cidade'=>$oCande->cand_cidade,
						'cand_uf'=>$oCande->cand_uf,
						'cand_comple'=>$oCande->cand_comple,
						'cand_num'=>$oCande->cand_num,
						'cand_nasc'=>$oCande->cand_nasc,

					)
				);
				//
				$oCandevag->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Candidato";
			$this->json['candvag'] 		= $candvag2;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Candidato não encontrado";
		}
	}
}

function removeCandidatoVaga($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$Ocandevag = new tcand_vaga();
		$Ocandevag->LoadByPrimaryKey($post_array['id']);
		if($Ocandevag->RowsCount){
			$Ocandevag->MarkAsDelete();
			$Ocandevag->Save();
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Candidato  removido";
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Candidato encontrado";
		}
	}
}

function getEmpresaVaga($post_array){
	if(isset($post_array['id']) && $post_array['id']!=''){
		$oVga = new tvagas();
		$oVga->SQL_WHERE = 'id = '.$post_array['id'];
		$oVga->LoadSQL();
			if($oVga->RowsCount){
			$vga = array();
			for ($i=0; $i < $oVga->RowsCount ; $i++) { 
                $ovAGS = new tcurso();
                $ovAGS->LoadByPrimaryKey($oVga->vag_curso_id);
                $full_info = 
				$ovAGS->cur_nome;
				$medio='';
				$tecnico= ''; 
				$superior = ''; 
				$vaga_tip=(explode(',',$oVga->vag_nivel));
           			 foreach($vaga_tip as $value) {
               			 if($value=='medio'){
							$medio ='medio' ;
						}
						if($value=='tecnico'){
							$tecnico ='tecnico';
						}
						if($value=='superior'){
							$superior ='superior' ;
						}
					}


					$vaga_bene=(explode(',',$oVga->vag_benefi));

           			 foreach($vaga_bene as $value2) {

               			$oBeneficio_Name = new tbeneficio();
						$oBeneficio_Name->SQL_WHERE = 'id = '.$value2;
						$oBeneficio_Name->LoadSQL();

						$beneficio .= $oBeneficio_Name->bnf_nome.',';
						
					}


					$Segunda = ''; 
					$Terça = ''; 
					$Quarta = ''; 
					$Quinta = ''; 
					$Sexta = ''; 
					$Sabado = ''; 
					$Domingo = ''; 
					$vaga_dias=(explode(',',$oVga->vag_dias));
           			 foreach($vaga_dias as $value3) {
               			 if($value3=='Segunda-feira'){
							$Segunda ='Segunda-feira' ;
						}
						if($value3=='Terça-feira'){
							$Terça ='Terça-feira';
						}
						if($value3=='Quarta-feira'){
							$Quarta ='Quarta-feira' ;
						}
						if($value3=='Quinta-feira'){
							$Quinta ='Quinta-feira' ;
						}
						if($value3=='Sexta-feira'){
							$Sexta ='Sexta-feira' ;
						}
						if($value3=='Sabado'){
							$Sabado ='Sabado' ;
						}
						if($value3=='Domingo'){
							$Domingo ='Domingo' ;
						}
					}
	
				array_push(
					$vga, 
					array(

						'id'=>$oVga->id,
                        'vag_sexo'=>$oVga->vag_sexo,
                        'emp_cnpj_id'=>$oVga->emp_cnpj_id,
                        'vag_quant'=>$oVga->vag_quant,
                        'vag_hini'=>$oVga->vag_hini,
                        'vag_hfin'=>$oVga->vag_hfin,
                        'vag_inti'=>$oVga->vag_inti,
                        'vag_intf'=>$oVga->vag_intf,
                        'vag_dias'=>$oVga->vag_dias,
                        'vag_auxm'=>$oVga->vag_auxm,
                        'vag_auxt'=>$oVga->vag_auxt,
                        'vag_auxs'=>$oVga->vag_auxs,
                        'vag_benefi'=>$oVga->vag_benefi,
                        'vag_nivel'=>$oVga->vag_nivel,
						'vag_res'=>$oVga->vag_res,
                        'vag_desc'=>$oVga->vag_desc,
                        'vag_infoadc'=>$oVga->vag_infoadc,
                        'vag_supnome'=>$oVga->vag_supnome,
                        'vag_curso_id'=>$oVga->vag_curso_id,
						'full_info'=>$full_info,
						'medio'=>$medio,
						'beneficio'=>$beneficio,
						'superior'=>$superior,
						'tecnico'=>$tecnico,
						'Segunda'=>$Segunda,
						'Terça'=>$Terça,
						'Quarta'=>$Quarta,
						'Quinta'=>$Quinta,
						'Sexta'=>$Sexta,
						'Sabado'=>$Sabado,
						'Domingo'=>$Domingo,
					
					)
				);
				//
				$oVga->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Candidato";
			$this->json['vga'] 		= $vga;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Candidato não encontrado";
		}
	}
}

function getVaga($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$oVaga = new tvagas();
		$oVaga->SQL_WHERE = 'id = '.$post_array['id'];
		$oVaga->LoadSQL();
		if($oVaga->RowsCount){
			//
			$vag2 = array();
			for ($i=0; $i < $oVaga->RowsCount ; $i++) { 
				//district
				$oEmpresa = new tempresa();
				$oEmpresa->LoadByPrimaryKey($oVaga->emp_cnpj_id);

				$situacao = $oVaga->vag_situacao;

				if($situacao == ""){
					$situacao = "Selecione";
				}	
				
				array_push(
					$vag2, 
					array(
						'id'=>$oVaga->id,
						'situacao'=>$situacao,
                        'emp_nome'=>$oEmpresa->emp_nome,
					)
				);
				//
				$oVaga->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Vaga";
			$this->json['vag2'] 		= $vag2;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Vaga não encontrado";
		}
	}
}

function getVagasExistentes($post_array){
	//update
	if(isset($post_array['id_emp']) && $post_array['id_emp']!=''){
		$oVaga = new tvagas();
		$oVaga->SQL_WHERE = 'emp_cnpj_id = '.$post_array['id_emp'];
		$oVaga->LoadSQL();
		if($oVaga->RowsCount){
			$vagas = array();
			for ($i=0; $i < $oVaga->RowsCount ; $i++) { 
				//distric

				$oEmpresaVga = new tempresa();
				$oEmpresaVga->SQL_WHERE = 'id = '.$oVaga->emp_cnpj_id;
				$oEmpresaVga->LoadSQL();

				if($oVaga->vag_curso_id != ""){ 

					$oCursovga = new tcurso();
					$oCursovga->SQL_WHERE = 'id = '.$oVaga->vag_curso_id;
					$oCursovga->LoadSQL();
					$NomeCurso = $oCursovga->cur_nome;
				}else{
					$NomeCurso = "Ensino Médio";
				}

				$vaga_desc = 
				'Nome da Empresa: '.$oEmpresaVga->emp_nome.'<br>'.
				'CNPJ: '.$oEmpresaVga->emp_cnpj.'<br>'.
				'Curso: '.$NomeCurso;

				array_push(
					$vagas, 
					array(
						'vaga_desc'=>$vaga_desc,
						'id'=>$oVaga->id,
					)
				);
				//
				$oVaga->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Vaga";
			$this->json['vagas'] 		= $vagas;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Vaga não encontrado";
		}
	}
}



function getTipoVaga($post_array){
	//update
	if(isset($post_array['id']) && $post_array['id']!=''){
		$oVagaTipo = new tvaga_tipo();
		$oVagaTipo->SQL_WHERE = 'id = '.$post_array['id'];
		$oVagaTipo->LoadSQL();
		if($oVagaTipo->RowsCount){
			$tipovaga = array();
			for ($i=0; $i < $oVagaTipo->RowsCount ; $i++) { 
				//distric

				array_push(
					$tipovaga, 
					array(
						'vag_desc'=>$oVagaTipo->descricao,
						'vag_res'=>$oVagaTipo->resumo_atividades,
					)
				);
				//
				$oVagaTipo->MoveNext();
			}
			$this->json['status'] 	= 200;
			$this->json['msg'] 		= "Tipo vaga";
			$this->json['tipovaga'] = $tipovaga;
		}else{
			$this->json['status'] 	= 400;
			$this->json['msg'] 		= "Tipo de vaga não encontrado";
		}
	}
}


function updateVaga($post_array){
	if(isset($post_array['id']) && $post_array['id']!=''){

		$oVagaS = new tvagas();
		$oVagaS->SQL_WHERE = 'id = '.$post_array['id'];
		$oVagaS->LoadSQL();

		$oVagaS->vag_situacao = $post_array['situacao'];
		$oVagaS->Save();

		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Situação Alterada";
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}

function adicionarCurso($post_array){
	if(isset($post_array['cur_nome']) && $post_array['cur_nome']!=''){

		$oCursoAdd = new tcurso();

		$oCursoAdd->cur_nivel = $post_array['cur_nivel'];
		$oCursoAdd->cur_dura = $post_array['cur_dura'];
		$oCursoAdd->cur_nome = $post_array['cur_nome'];
		$oCursoAdd->date_create = date('Y-m-d H:i:s');

		$oCursoAdd->AddNew();
		$oCursoAdd->Save();
		

		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Curso Cadastrado ";
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}

function adicionarTipoVaga($post_array){
	if(isset($post_array['id']) && $post_array['id']!=''){

		$oVagaTipo = new tvaga_tipo();

		$oVagaTipo->empresa_id = $post_array['id'];
		$oVagaTipo->titulo = $post_array['titulo'];
		$oVagaTipo->descricao = $post_array['descricao'];
		$oVagaTipo->resumo_atividades = $post_array['resumo_atividades'];
		$oVagaTipo->date_created = date('Y-m-d H:i:s');

		$oVagaTipo->AddNew();
		$oVagaTipo->Save();
		

		$this->json['status'] 	= 200;
		$this->json['msg'] 		= "Tipo Cadastrado ";
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Dados inválidos";
	}
}


function getCandidatos($post_array){
	
	$oUtil = new util();

	$query2 = "";
	// $query = " 1=1";

	// if(isset($post_array['data_nasc'])  && $post_array['data_nasc']!=''){
	// 	$query = "1 = 1";
	// 	$nascimento =date('Y')-$post_array['data_nasc'] ;
	// 	$query2 .=' AND tcandidato.cand_nome != "" ';
	// 	$query2 .=' AND tcandidato.cand_nasc >= "'.$nascimento.'-01-01" ';
	// 	$query2 .=' AND tcandidato.cand_nasc <= "'.$nascimento.'-12-31"';
	// }else{
		$query = 'tcandidato.cand_nome != "" AND tcandidato.cand_nasc <= "'.date('Y-m-d').'" ';
	// }


	


	if(isset($post_array['cand_sexo']) && $post_array['cand_sexo']!=''){
		$query .= ' AND tcandidato.cand_sexo LIKE "'.$post_array['cand_sexo'].'" ';
	}
	if(isset($post_array['cand_especial']) && $post_array['cand_especial']!=''){
		$query .= ' AND tcandidato.cand_especial LIKE "%'.$post_array['cand_especial'].'%" ';
	}
	if(isset($post_array['cand_prosele']) && $post_array['cand_prosele']!=''){
		$query .= ' AND tcandidato.cand_prosele LIKE "%'.$post_array['cand_prosele'].'%" ';
	}
	if(isset($post_array['cand_conheinfo']) && $post_array['cand_conheinfo']!=''){
		$query .= ' AND tcandidato.cand_conheinfo LIKE "%'.$post_array['cand_conheinfo'].'%" ';
	}
	if(isset($post_array['cand_status']) && $post_array['cand_status']!=''){
		$query .= ' AND tcandidato.cand_status LIKE "%'.$post_array['cand_status'].'%" ';
	}

	if(isset($post_array['data_nasc']) && $post_array['data_nasc']!=''){

			$nascimento =date('Y')-$post_array['data_nasc'] ;
			
			$query .= ' AND tcandidato.cand_nasc >=  "'.$nascimento.'-01-01" ';

			$nascimento_limite = $nascimento.'-'.date('m-d');

			$query .= ' AND tcandidato.cand_nasc <=  "'.$nascimento_limite.'" ';

	}




	$query2 = $query;
	
	if(isset($post_array['cand_cidade']) && $post_array['cand_cidade']!=''){
		$query .= ' AND tcandidato.cand_cidade LIKE "%'.$post_array['cand_cidade'].'%" ';
		$query2 .= ' AND tcandidato.cand_cidade LIKE "%'.($post_array['cand_cidade']).'%" ';
	}
	if(isset($post_array['cand_bairro']) && $post_array['cand_bairro']!=''){
		$query .= ' AND tcandidato.cand_bairro LIKE "%'.$post_array['cand_bairro'].'%" ';
		$query2 .= ' AND tcandidato.cand_bairro LIKE "%'.($post_array['cand_bairro']).'%" ';
	}
	if(isset($post_array['cand_nome']) && $post_array['cand_nome']!=''){
		$query .= ' AND tcandidato.cand_nome LIKE "%'.$post_array['cand_nome'].'%" ';

		$comAcentos = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú');

		$semAcentos = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', '0', 'U', 'U', 'U');

		$name = $post_array['cand_nome'];

		$search_text =  strtolower(str_replace($comAcentos, $semAcentos, $name));

		$query2 .= ' AND (tcandidato.cand_nome LIKE "%'.$post_array['cand_nome'].'%" OR search_text LIKE "%'.$search_text.'%") ';

	}

	if(isset($post_array['cand_insti'])  && $post_array['cand_insti']!=''){
		$query2 .= ' AND tacademicas.cand_insti = '.$post_array['cand_insti'].' ';
	}

	if(isset($post_array['cand_cursoestu']) && $post_array['cand_cursoestu']!=''){
		$query2 .= ' AND tacademicas.cand_cursoestu = '.$post_array['cand_cursoestu'].'';
	}

	if(isset($post_array['cand_periodo'])  && $post_array['cand_periodo']!=''){
		$query2 .= ' AND tacademicas.cand_periodo LIKE "%'.$post_array['cand_periodo'].'%" ';
		
	}

	if(isset($post_array['cand_nvlesc'])  && $post_array['cand_nvlesc']!=''){
		$query2 .= ' AND tacademicas.cand_nvlesc LIKE "%'.$post_array['cand_nvlesc'].'%" ';
	}

	
	$total = 0 ;
	$oTotal = new tcandidato();
	if($query2!=''){
		$oTotal->LoadByQuery('SELECT count(*) AS soma FROM tcandidato INNER JOIN tacademicas ON tacademicas.cand_id = tcandidato.id WHERE ' .$query2.'');
		
	}else{
		$oTotal->LoadSQL();
		echo 'entrou';
	}
	if($oTotal->RowsCount){
		$total = $oTotal->soma;
	}else{
		$total = 0 ;
	}
	// echo $query2;
	// die();



	// if(isset($post_array['cand_anoinse']) && $post_array['cand_anoinse']!=""){
		
	// 	$oCandidatoAge = new tcandidato();
	// 	$oCandidatoAge->LoadByQuery('SELECT *,tcandidato.id "idcand" FROM tcandidato INNER JOIN tacademicas ON tacademicas.cand_id = tcandidato.id WHERE '.$query2);
	// 	if($oCandidatoAge->RowsCount){
	// 		$total = 0;
	// 		for($l=0;$l<$oCandidatoAge->RowsCount;$l++){

	// 			$oAcad = new tacademicas();
	// 			$oAcad->SQL_WHERE = ' cand_id = '.$oCandidatoAge->idcand;
	// 			$oAcad->LoadSQL();

	// 			$ano = explode('-',$oCandidatoAge->date_created);
	
	// 			$data = date('Y');
				
	// 			$date = $data - $ano[0];
				
	// 			$ano_atual = $oAcad->cand_anoinse[0] + $date;

	// 			if($ano_atual == $post_array['cand_anoinse']){
	// 				$total++;
	// 			}

	// 		$oCandidatoAge->MoveNext(); }

	// 	}


	// }
	
	// $total = 0 ;
	// $oTotal = new tcandidato();
	// if($query2!=''){

	// 	$oTotal->LoadByQuery('SELECT count(*) AS soma FROM tcandidato INNER JOIN tacademicas ON tacademicas.cand_id = tcandidato.id WHERE ' .$query2.'');
	
	// }else{

	// 	$oTotal->LoadByQuery('SELECT count(*) AS soma FROM tcandidato INNER JOIN tacademicas ON tacademicas.cand_id = tcandidato.id');    
	
	// }

	/*$oTeste = new tcandidato();
	$oTeste->SQL_WHERE = $query;
	$oTeste->LoadSQL();
	if($oTeste->RowsCount){
		for($i=0;$i<$oTeste->RowsCount;$i++){

			$oTeste2 = new tacademicas();
			$oTeste2->SQL_WHERE = 'cand_id = '.$oTeste->id .' '.$query2;
			$oTeste2->LoadSQL();
			if($oTeste2->RowsCount){
				$total++;
			}

			$oTeste->MoveNext();

		}
	}*/
	// echo $oTotal->GenerateSQL;
	// echo '<pre>';
	// print_r($oTotal);
	// echo '</pre>';
	// if($oTotal->RowsCount){
	// 	$total = $oTotal->soma;
	// }
	// echo $total;
	// die();

	// $oRegister2 = new tcandidato();
	// $oRegister2->SQL_WHERE = $query;
	// $oRegister2->SQL_FN = "Count";
	// $total = $oRegister2->LoadSQL();


	$portela = 100;
	$search = "";
	$pg = isset($post_array['pg']) ? intval($post_array['pg']) : 0;
	$pg = ($pg >= ceil($total / $portela)) ? 0 : $pg;
	$parametro = "palavra=" . $search;
	$pagina = $pg;

	$paginacao = $oUtil->PaginarFiltro("pg", $total, $portela, $parametro,$pagina);



	// SELECT * FROM tcandidato WHERE tcandidato.cand_nome != "" AND tcandidato.cand_nasc <= "2021-01-11"  ORDER BY  id ASC  Limit 0 , 100
	$candidatos = array();


	$oCandidato = new tcandidato();
	// $oCandidato->SQL_WHERE = $query;
	// $oCandidato->SQL_ORDER = ' id ASC ';
	// $oCandidato->SQL_INICIO = ($pg * $portela);
	// $oCandidato->SQL_TOTAL = $portela;
	// $oCandidato->LoadSQL();
	$oCandidato->LoadByQuery('SELECT *,tcandidato.id "idcand" FROM tcandidato INNER JOIN tacademicas ON tacademicas.cand_id = tcandidato.id WHERE ' .$query2.' Limit '.($pg * $portela).' , '.$portela.'');
	
	
	if($oCandidato->RowsCount){
		for($i=0;$i<$oCandidato->RowsCount;$i++){
			$ok = true;

			if(isset($post_array['cand_insti'])  && $post_array['cand_insti']!=''){
				$oAcademicas = new tacademicas();
				$oAcademicas->SQL_WHERE = 'cand_insti = '.$post_array['cand_insti'].' AND cand_id ='.$oCandidato->idcand;
				$oAcademicas->LoadSQL();
				if($oAcademicas->RowsCount == 0){
					$ok = false;
					// echo '1,';
				}
			}
			

			if(isset($post_array['cand_cursoestu']) && $post_array['cand_cursoestu']!=''){
				$oAcademicas2 = new tacademicas();
				$oAcademicas2->SQL_WHERE = 'cand_cursoestu = '.$post_array['cand_cursoestu'].' AND cand_id ='.$oCandidato->idcand;
				$oAcademicas2->LoadSQL();
				if($oAcademicas2->RowsCount == 0){
					$ok = false;
					// echo '2,';

				}
			}

			if(isset($post_array['cand_periodo'])  && $post_array['cand_periodo']!=''){
				$oAcademicas3 = new tacademicas();
				$oAcademicas3->SQL_WHERE ='cand_id ='.$oCandidato->idcand.' AND cand_periodo LIKE "%'.$post_array['cand_periodo'].'%" ';
				$oAcademicas3->LoadSQL();
				if($oAcademicas3->RowsCount == 0){
					$ok = false;
					// echo '3,';
				}
			}

			if(isset($post_array['cand_nvlesc'])  && $post_array['cand_nvlesc']!=''){
				$oAcademicas4 = new tacademicas();
				$oAcademicas4->SQL_WHERE ='cand_id ='.$oCandidato->idcand.' AND cand_nvlesc LIKE "%'.$post_array['cand_nvlesc'].'%" ';
				$oAcademicas4->LoadSQL();
				if($oAcademicas4->RowsCount == 0){
					$ok = false;
					// echo '4,';
				}
			}

			$escolaridade = '';
			$instituicao = '';
			$oAcad = new tacademicas();
			$oAcad->SQL_WHERE = ' cand_id = '.$oCandidato->idcand;
			$oAcad->LoadSQL();
			if($oAcad->RowsCount){
				$escolaridade = $oAcad->cand_nvlesc;
			
				if($oAcad->cand_insti != "" && $oAcad->cand_insti != "-1"){
					$oInstituicao = new tinstituicao();
					$oInstituicao->SQL_WHERE = 'id = '.$oAcad->cand_insti;
					$oInstituicao->LoadSQL();
					$instituicao = $oInstituicao->inst_nome;
				}else{
					$instituicao = $oAcad->cand_instio;
				}

				if($oAcad->cand_cursoestu != "" && $oAcad->cand_cursoestu != "-1"){
					$oCurso = new tcurso();
					$oCurso->SQL_WHERE = 'id = '.$oAcad->cand_cursoestu;
					$oCurso->LoadSQL();
					$curso = $oCurso->cur_nome;
					$duracao_curso = $oCurso->cur_dura;
				}else{
					$curso = $oAcad->cand_cursoestuo;
					$duracao_curso = 100;

					if($oAcad->cand_cursoestuo == "" || $oAcad->cand_cursoestuo == NULL){
						$curso = " ";
					}

				}
				
			}

			if(!$instituicao){
				$instituicao = "";
			}

			$age = ""; 
			$idade_post = "";
			$from = "";
			$to = "";

			$from = new DateTime($oCandidato->cand_nasc);
			$to   = new DateTime();
			$age = $from->diff($to)->y;

	

			if(isset($post_array['data_nasc']) && $post_array['data_nasc']!=''){
				$idade_post = (int)$post_array['data_nasc'];
				if($age != $idade_post ){
					$ok = false;
				}
			}
			
			$ano = explode('-',$oCandidato->date_created);
	
			$data = date('Y');
		
			$date = $data - $ano[0];
			
			$ano_atual = $oAcad->cand_anoinse[0] + $date;


			if(isset($post_array['cand_anoinse']) && $post_array['cand_anoinse']!=""){
					if($ano_atual != $post_array['cand_anoinse']){
						$ok = false;
					}
			}

			if($escolaridade == "medio"){
				$curso = "Ensino Médio";
				$ano_atual = $ano_atual."º Ano";
			}
		
			if($escolaridade == "medio" && $ano_atual > 3){
				$ano_atual = "Possivelmente Formado";
			}


			if($escolaridade != "medio"){

				$mes_atual = (int) date('m');
		
			
				$semestre_conclusão = $oAcad->cand_conclusem[0];

				if($oAcad->cand_concluano < $data ){

					$ano_atual = "Possivelmente Formado"; 

				}elseif($data == $oAcad->cand_concluano) {
					
					if($mes_atual ==  $semestre_conclusão){
						$ano_atual = "Possivelmente Formado"; 
					}else{
						$ano_candidato = $oAcad->cand_concluano  - $data;
		
						if($mes_atual >= 1  && $mes_atual <= 6 ){
						
							$semestres_faltantes = ($ano_candidato * 2) + 1;
			
							$ano = explode('-',$oCandidato->date_created);
			
							$ano_inserido = $oAcad->cand_anoinse[0] * 2;
			
							$total =  ($oAcad->cand_concluano - $ano[0]) * 2;  
						
							$date = $ano_inserido + $total ;
			
							$ano_atual = $date - $semestres_faltantes."º Semestre";
			
			
						}
			
						if($mes_atual >= 7  && $mes_atual <= 12 ){
								
							$semestres_faltantes = ($ano_candidato * 2);
			
							$ano = explode('-',$oCandidato->date_created);
			
							$ano_inserido = $oAcad->cand_anoinse[0] * 2;
			
							$total =  ($oAcad->cand_concluano - $ano[0]) * 2;  
						
							$date = $ano_inserido + $total ;
			
							$ano_atual = $date - $semestres_faltantes."º Semestre";
			
						}
		
					}
		
					
				}else{
		
					$ano_candidato = $oAcad->cand_concluano  - $data;
					
					if($mes_atual >= 1  && $mes_atual <= 6 ){
						
						$semestres_faltantes = ($ano_candidato * 2) + 1;
		
						$ano = explode('-',$oCandidato->date_created);
		
						$ano_inserido = $oAcad->cand_anoinse[0] * 2;
		
						$total =  ($oAcad->cand_concluano - $ano[0]) * 2;  
					
						$date = $ano_inserido + $total ;
		
						$ano_atual = $date - $semestres_faltantes."º Semestre";
		
		
					}
		
					if($mes_atual >= 7  && $mes_atual <= 12 ){
							
						$semestres_faltantes = ($ano_candidato * 2);
		
						$ano = explode('-',$oCandidato->date_created);
		
						$ano_inserido = $oAcad->cand_anoinse[0] * 2;
		
						$total =  ($oAcad->cand_concluano - $ano[0]) * 2;  
					
						$date = $ano_inserido + $total ;
		
						$ano_atual = $date - $semestres_faltantes."º Semestre";
		
					}
					
				}
			
			}













			if($oAcad->cand_periodo == "" || $oAcad->cand_periodo == NULL){
				$oAcad->cand_periodo = "";
			}

			if(isset($post_array['cand_escolaridade']) && $post_array['cand_escolaridade']!='' && $escolaridade == $post_array['cand_escolaridade']){
				$ok = false;
			}

			if($oCandidato->cand_status == "1"){
				$status = "Disponível";
			}else{
				$status = "Indisponível";
			}


			if($ok){

				array_push($candidatos, array(
					'id_token'=>$oUtil->Criptografar($oCandidato->idcand),
					'id'=>$oCandidato->idcand,
					'cand_nome'=>$oCandidato->cand_nome,
					'cand_nasc'=>$age,
					'cand_sexo'=>$oCandidato->cand_sexo,
					'cand_natu'=>$oCandidato->cand_natu,
					'cand_especial'=>$oCandidato->cand_especial,
					'cand_prosele'=>$oCandidato->cand_prosele,
					'cand_bairro'=>$oCandidato->cand_bairro,
					'cand_cidade'=>$oCandidato->cand_cidade,
					'cand_status'=>$status,
					'cand_periodo'=>$oAcad->cand_periodo,
					'escolaridade'=>$escolaridade,
					'instituicao'=>$instituicao,
					'cand_anoinse'=>$ano_atual,
					'curso'=>$curso,
					'paginacao'=>$paginacao,
				));
			}
			$oCandidato->MoveNext();
		}
		
	

		$this->json['status'] = 200;
		$this->json['msg'] = "Candidatos localizados";
		$this->json['sql'] = $oCandidato->GenerateSQL;
		$this->json['candidato'] = $candidatos;
	}else{
		$this->json['status'] 	= 400;
		$this->json['msg'] 		= "Nenhum candidato localizado";
	}
}

function getVeiculo($post_array){
	echo 'entrei';
	if(isset($post_array['cliente_id']) && $post_array['cliente_id'] != ""){
		$oVeiculos = new tveiculos();
		$oVeiculos->SQL_WHERE = 'cliente_id = '.$post_array['cliente_id'];
		$oVeiculos->LoadSQL();
		if($oVeiculos->RowsCount){
			$veiculos = array();
			for ($i=0; $i < $oVeiculos->RowsCount; $i++) {
				array_push($instituicao, array(
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
	}
}


}

//
$oRegister = new Wex();
$_fn = isset($_GET['fn'])?$_GET['fn']:'';
//$_fn = strtolower($_fn);

$request = $_POST;
/*if($_POST){
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata, TRUE);
}*/   

switch($_fn){ 
	case'getTipoVaga':
		$oRegister->getTipoVaga($request);
		break;
	case'adicionarTipoVaga':
		$oRegister->adicionarTipoVaga($request);
		break;
	case'adicionarCurso':
		$oRegister->adicionarCurso($request);
		break;
	case 'updateSituacao':
		$oRegister->updateSituacao($request);
		break;
	case 'editCandidatoExp':
		$oRegister->editCandidatoExp($request);
		break;
	case 'editAcademicas':
		$oRegister->editAcademicas($request);
		break;
	case 'getVagasExistentes':
		$oRegister->getVagasExistentes($request);
		break;
	case 'updateVaga':
		$oRegister->updateVaga($request);
		break;
	case 'updateRetorno':
		$oRegister->updateRetorno($request);
		break;
	case 'getVaga':
		$oRegister->getVaga($request);
		break;
	case 'updateAprovado':
		$oRegister->updateAprovado($request);
		break;
	case 'updateDataHorario':
		$oRegister->updateDataHorario($request);
		break;
	case 'setCandidatoVaga':
		$oRegister->setCandidatoVaga($request);
		break;
	case 'getCandidatoVaga2':
		$oRegister->getCandidatoVaga2($request);
		break;
	case 'getEmpresaVaga':
		$oRegister->getEmpresaVaga($request);
		break;
	case 'getCandidatoVaga':
		$oRegister->getCandidatoVaga($request);
		break;
	case 'getCandidatos':
		$oRegister->getCandidatos($request);
		break;
	case 'removeCandidatoVaga':
		$oRegister->removeCandidatoVaga($request);
		break;
	case 'setAcademicas':
		$oRegister->setAcademicas($request);
		break;
	case 'getAcademicas':
		$oRegister->getAcademicas($request);
		break;
	case 'removeAcademicas':
		$oRegister->removeAcademicas($request);
		break;
	case 'getCandidato':
		$oRegister->getCandidato($request);
		break;
	case 'getEmpresa':
		$oRegister->getEmpresa($request);
		break;
	case 'getCidade':
		$oRegister->getCidade($request);
		break;
	case 'getInstitu':
		$oRegister->getInstitu($request);
		break;
	case 'getCurso':
		$oRegister->getCurso($request);
		break;
	case 'setUserAddress':
		$oRegister->setUserAddress($request);
		break;
	case 'getUserAddress':
		$oRegister->getUserAddress($request);
		break;
	case 'removeUserAddress':
		$oRegister->removeUserAddress($request);
		break;
	case 'setEmpresaAddress':
		$oRegister->setEmpresaAddress($request);
		break;
	case 'getEmpresaAddress':
		$oRegister->getEmpresaAddress($request);
		break;
	case 'removeEmpresaAddress':
		$oRegister->removeEmpresaAddress($request);
		break;
	case 'setCandidatoExp':
		$oRegister->setCandidatoExp($request);
		break;	
	case 'getCandidatoExp':
		$oRegister->getCandidatoExp($request);
		break;
	case 'removeCandidatoExp':
		$oRegister->removeCandidatoExp($request);
		break;

	case 'getVeiculo':
		$oRegister->getVeiculo($request);
		break;
		
	default:
		echo 'error';
		break;
}


//////////////////////////////////////////////////////////////////////////////
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



