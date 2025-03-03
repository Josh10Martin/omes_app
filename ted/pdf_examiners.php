<?php     

include '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Canvas;

$options = new Options();
$options->set('isHtml5ParserEnabled',true);
$options->set('isRemoteEnabled', true);
$options->set('isPhpEnabled', true);
$options->setChroot(['../assets']);


// instantiate and use the dompdf class

$dompdf = new Dompdf($options);

ob_start();
// require('reports/examiners_report.php');
require('report.php');
$html=ob_get_contents();
ob_clean();


//$dompdf->loadHtml('hello world');
$dompdf->loadHtml($html); 

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'portrait');


// Render the HTML as PDF
$dompdf->render();

// $pages = $dompdf->getCanvas()->get_page_count();
// for ($i =1 ;$i<= $pages;$i++){
//     $dompdf->getCanvas()->page_text(500,820,"Page $i of $pages",null,10,array(0,0,0));
// }

// Output the generated PDF to Browser
$dompdf->stream("new pdf",array('Attachment'=>0));

?>
