<?php
session_start();
require_once '../../dompdf/autoload.inc.php';
include '../../config.php';
include '../../functions.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;

$options = new Options();
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$options->setChroot(['../../assets']);  
$pdf = new Dompdf($options);
    ob_start();
       
        $total =0;
        $grand_total = 0;
        $no_of_examiners =0;
        // $claim =0;
        // $examiners = array();
        $sql = $db_9->prepare(' 
        WITH brail_transcriber AS (
            SELECT tsn.no_of_scripts AS no_of_scripts, COUNT(DISTINCT(t.nrc)) AS no_of_examiners, t.marking_centre AS marking_centre_code, mr.transcriber AS transcriber_rate
                  FROM transcriber t INNER JOIN transcriber_script_no tsn ON (t.marking_centre = tsn.marking_centre)
                  CROSS JOIN marking_rates mr
                  WHERE t.marking_centre =:marking_centre_code
                  GROUP BY tsn.no_of_scripts,t.marking_centre,mr.transcriber
        )
        
        SELECT t.nrc AS nrc, CONCAT(t.first_name," ",t.last_name) AS full_name,t.title AS title,t.account_no AS account_no,t.tpin,
            b.name AS bank,br.name AS branch,bt.no_of_scripts AS no_of_scripts, bt.transcriber_rate AS transcriber_rate,
          bt.no_of_scripts * bt.transcriber_rate / bt.no_of_examiners AS gross_pay,
          (bt.no_of_scripts * bt.transcriber_rate / bt.no_of_examiners) * (15/100) AS 15_wht,
          (bt.no_of_scripts * bt.transcriber_rate / bt.no_of_examiners) - ((bt.no_of_scripts * bt.transcriber_rate / bt.no_of_examiners) * (15/100)) AS net_pay
            FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
            INNER JOIN transcriber t ON (b.id = t.bank)
            INNER JOIN transcriber_script_no tsn ON (t.marking_centre = tsn.marking_centre)
            INNER JOIN brail_transcriber bt ON (t.marking_centre = bt.marking_centre_code)
            WHERE t.branch = br.id
            AND t.marking_centre =:marking_centre_code
                               ');
        
        $sql->execute(array(
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
            
        ));
        $sql->bindColumn('nrc',$nrc);
        $sql->bindColumn('tpin',$tpin);
        $sql->bindColumn('full_name',$full_name);
        $sql->bindColumn('transcriber_rate',$transcriber_rate);
        $sql->bindColumn('gross_pay',$gross_pay);
        $sql->bindColumn('15_wht',$wht);
        $sql->bindColumn('net_pay',$net_pay);
        $sql->bindColumn('account_no',$account_no);
        $sql->bindColumn('bank',$bank);
        $sql->bindColumn('branch',$branch);
        $sql->bindColumn('title',$title);
        $sql->bindColumn('no_of_scripts',$no_of_scripts);
        $row = $sql->rowCount();
        $sql->fetch(PDO::FETCH_BOUND);
?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>CLAIM REPORT</title>
    </head>
    <body>
        <style>
            table.center {
    margin-left: auto; 
    margin-right: auto;
  }

table.bodered, 
table.bodered th,
table.bodered td{
    border: 1px solid black; 
    border-collapse: collapse;
}

.w80{
    width: 80%;
}
.w100{
    width: 100%;
}
.w25{
    width: 25%;
}
.p-5{
padding: 5px;
}
.pt-10{
    padding-top: 10px;
}

table.foot{
    bottom: 0;
}
table.data th,
table.data td{
 padding:1px 3px;
}


th {
    text-align: inherit;
}
p{
    margin: 7px;
}
        </style>
    <table class="center" style="width: 500px;margin-bottom:3px;">
        <tr >
            <td>
                <img src="../../assets/img/eczlogo_tr_sm.jpg" style="width:60%">
            </td>
            <td>
               <p  style="text-align: center;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                <p style="text-align: center;"><?php echo $_SESSION['session_name']; ?></p>
                <p style="text-align: center;">BRAILLE TRANSCRIBER CLAIM SCHEDULE</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w80" style="margin-top: 5px;">
        <th>
        </th>
        <th>
            <!-- Paper Rate: <?php // echo $paper_rate; ?> -->
        </th>
        <th>
            Marking Centre : <?php echo $_SESSION['marking_centre']; ?>
        </th>
        <tr>
            <th>
            </th>
            <th>
            </th>
            <th>
                Rate: <?php echo $transcriber_rate; ?>
            </th>
        </tr>
    </table>

    <table class="bodered w100">
        <thead>
            <th>
                NRC
            </th>
            <th>
                TPIN
            </th>
            <th>
                FULL NAME
            </th>
            
            <th>
                GROSS
            </th>
            <th>
                TAX (15%)
            </th>
            <th>
                NET
            </th>
            <th>
                ACCOUNT NO
            </th>
            <th>
                BANK
            </th>
            <th>
                BRANCH
            </th>
            <th>
                SIGNATURE
            </th>
        </thead>
        <tbody >
            <?php
            // $claim = $amount_claimed / $row;
            do{
                
            ?>
            <tr>
                <td><?php echo $nrc; ?></td>
                <td><?php echo $tpin ?></td>
                <td><?php echo $title," ",$full_name; ?></td>
                <td><?php echo number_format((float)$gross_pay,2,'.',''); ?></td>
                <td><?php echo number_format((float)$wht,2,'.',''); ?></td>
                <td><?php echo number_format((float)$net_pay,2,'.',''); ?></td>
                <td><?php echo $account_no; ?></td>
                <td><?php echo $bank; ?></td>
                <td><?php echo $branch; ?></td>
                <td></td>
            </tr>
            <?php
            // $total += $script_no;
            $grand_total += $net_pay;
            // $no_of_examiners = $no_of_examiners++;
            $no_of_examiners++;
            
            }while ($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>

    </table>

    <table class="foot w80">
        <tbody>
            <tr>
                <!-- <td>DATE GANERATED: <?php//  echo date('d-m-Y H:m:s'); ?></td> -->
                <td>GENERATED BY: <?php echo $_SESSION['username']; ?></td>
            <tr >
            
            <th>Total Number of Scripts: <?php echo $no_of_scripts; ?></th> 
            
            </tr>
            <tr>
                <th>Total Number of Examiners : <?php echo $no_of_examiners; ?></th> 
            </tr>
            <tr>
                <th>Grand Total (net) : K<?php echo number_format((float)$grand_total,2,'.',''); ?></th>
            </tr>
        </tbody>
    </table>
    <table class="w100 pt-10" >
        <tbody>
        < >
        <th >Confirmed By Chief Examiner:.............................................................</th>
            <th>Approved By Director EAD:......................................................................</th>
           
         </tr>
        <tr class="pt-10">
      </tr>
        </tbody>
        
    </table>
 
    </body>
</html>

<?php
$html = ob_get_clean();
$pdf->loadHtml($html);
$pdf->setPaper('A4', 'landscape');
$pdf->render();
$canvas = $pdf->getCanvas();
$fontMetrics = new FontMetrics($canvas, $options);

$w =$canvas->get_width();
$h = $canvas->get_height();

$font = $fontMetrics->getFont('times');

$text = "Page {PAGE_NUM} of {PAGE_COUNT}";
$date_generated = 'Date generated: '.date("d/m/Y h:m:s a");

$textHeight = $fontMetrics->getFontHeight($text, 20);
$textWidth = $fontMetrics->getTextWidth($font, $text, 5);

$x = $w - $textWidth;
$y = $h - $textHeight;


$canvas->page_text($x, $y, $text, $font, 10);
$canvas->page_text(500, $y, $date_generated, $font, 10);
$pdf->stream('transcribers', Array('Attachment'=>0));



?>