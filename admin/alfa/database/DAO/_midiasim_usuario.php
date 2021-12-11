<?php
require_once (dirname(dirname(__file__)) . "/MYSQL/mysql.php");
class _midiasim_usuario extends mysql{
    var $TableName = "midiasim_usuario";
    var $PrimaryKey = "id";
    var $Campos = array('usuario_id','nome_completo','data_nascimento','estado_civil','sexo','cpf','rg','nacionalidade','naturalidade','telefone','celular','operadora','email','senha','necessidade_especial','tipo_necessidade_especial','resumo','status','processo_seletivo','curriculo','data_criacao','data_modificacao',);
    function __construct(){
        parent::__construct();
    }
}