<?php


$html = '
<h1><img src="http://drodonto.com.br/logo.png" alt=""></h1>

';


//==============================================================
//==============================================================
//==============================================================

include("../mpdf.php");
$mpdf=new mPDF('c'); 

$mpdf->WriteHTML($html);
$mpdf->Output();
exit;

//==============================================================
//==============================================================
//==============================================================


?>