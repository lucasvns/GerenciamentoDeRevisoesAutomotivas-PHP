<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo');

include_once("barrier.php");
include_once(SERVER_PATH."/alfa/tools/url.php");
include_once(SERVER_PATH."/alfa/tools/master.php");
include_once(SERVER_PATH."/alfa/database/DTO/tpermission_title.php");
include_once(SERVER_PATH."/alfa/database/DTO/tpermission.php");
include_once(SERVER_PATH."/alfa/database/DTO/tadmin.php");
include_once(SERVER_PATH."/alfa/database/DTO/tparameter.php");
require_once(SERVER_PATH."/alfa/database/DTO/tuser.php");
require_once(SERVER_PATH."/alfa/database/DTO/taddress.php");
require_once(SERVER_PATH."/alfa/database/DTO/taddress_district.php");
require_once(SERVER_PATH."/alfa/database/DTO/taddress_city.php");
require_once(SERVER_PATH."/alfa/database/DTO/taddress_state.php");

$oParametro = new tparameter();

$pathAdmin = $oParametro->getParametro('admin-url');
$path = $oParametro->getParametro('admin-url');
$sitetitle = $oParametro->getParametro('site-title');

$agendamento = false;

$oUtil = new util();
$oParameter = new tparameter();
$oUsuario = new tadmin();
$admin_id = $oUsuario->GetSession();

$master_page = new MasterPages();
$master_page->inicio(dirname(__FILE__) . "/master.php");
$master_page->addParametro("admin_id", $admin_id);
$master_page->abrir("page_content");


?>
<noscript> <!-- Show a notification if the user has disabled javascript -->
<div class="notification error png_bg">
<div>
Javascript está desativado ou não é suportado pelo seu navegador. Por favor <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> seu navegador ou <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">abilite</a> Javascript para navegar pela interface adequadamente.
</div>
</div>
</noscript>
<br class="clear"/>


<script src="<?=$path?>assets/lib/highcharts/js/highcharts.js"></script>
<script src="<?=$path?>assets/lib/highcharts/js/modules/exporting.js"></script>
    

</div>
<?php
$master_page->fechar("page_content");
$master_page->fim();
?>