<?php
session_start();
require_once '../../dompdf/autoload.inc.php';
include '../../config.php';
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\FontMetrics;

$options = new Options();
$options->set('isPhpEnabled', true);
$options->set('isRemoteEnabled', true);
$options->setChroot(['../../assets']);  
$pdf = new Dompdf($options);
    ob_start();
    if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['app_belt_no'])){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $belt_no = $_POST['app_belt_no'];
        $total =0;
        $grand_total = 0;
        // $no_of_examiners =0;
        $sql = $db_12_gce->prepare('SELECT CONCAT(ex.first_name," ",ex.last_name) AS full_name,mr.checker AS paper_rate,SUM(a.script_no)
         AS script_no, mr.checker * SUM(a.script_no) AS amount_claimed,ex.account_no AS account_no,
                                ex.bank AS bank,ex.branch AS branch,(SELECT COUNT(*) FROM examiner WHERE marking_centre =:marking_centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND belt_no =:belt_no AND role IN ("EXAMINER","TEAM LEADER")) AS no_of_examiners
                                FROM  examiner ex INNER JOIN marking_rates mr ON (ex.subject_code = mr.subject_code)
                                INNER JOIN apportionment a ON (mr.subject_code = a.subject)
                                WHERE ex.subject_code = a.subject
                                AND ex.paper_no = a.paper
                                AND ex.paper_no = mr.paper_no
                                AND a.paper = mr.paper_no
                                AND ex.marking_centre = a.marking_centre
                                AND ex.belt_no = a.belt_no
                                AND ex.attendance = "1"
                                AND ex.role = "CHECKER"
                                AND a.subject =:subject_code
                                AND a.paper =:paper_no
                                AND a.belt_no =:belt_no
                                AND a.marking_centre =:marking_centre_code
                                GROUP BY ex.first_name,mr.checker,ex.last_name,ex.nrc,ex.account_no,ex.bank,ex.branch');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':belt_no'=>$belt_no,
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
            
        ));
        $row = $sql->rowCount();
        $sql->bindColumn('full_name',$full_name);
        $sql->bindColumn('amount_claimed',$amount_claimed);
        $sql->bindColumn('account_no',$account_no);
        $sql->bindColumn('bank',$bank);
        $sql->bindColumn('branch',$branch);
        $sql->bindColumn('no_of_examiners',$no_of_examiners);
        $sql->bindColumn('paper_rate',$paper_rate);
        $sql->bindColumn('script_no',$script_no);
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
                <p style="text-align: center;">CHECKERS CLAIM SCHEDULE</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w80" style="margin-top: 5px;">
        <th>
            Subject Code: <?php echo $subject_code; ?>
        </th>
        <th>
            Paper Rate: <?php echo $paper_rate; ?>
        </th>
        <th>
            Marking Center : <?php echo $_SESSION['marking_centre']; ?>
        </th>
        <tr>
            <th>
                Paper Code : <?php echo $paper_no; ?>
            </th>
            <th>
                Belt No.: <?php echo $belt_no; ?>
            </th>
        </tr>
    </table>

    <table class="bodered w100">
        <thead>
            <th>
                FULL NAME
            </th>
            <th>
                AMOUNT CLAIMED
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
            $claim = $amount_claimed / $no_of_examiners;
            do{
            ?>
            <tr>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $claim; ?></td>
                <td><?php echo $account_no; ?></td>
                <td><?php echo $bank; ?></td>
                <td><?php echo $branch; ?></td>
                <td></td>
            </tr>
            <?php
            // $total += $script_no;
            $grand_total += $amount_claimed;
            $no_of_examiners += $no_of_examiners;
            }while ($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>

    </table>

    <table class="foot w80">
        <tbody>
            <tr>
                <td>DATE GANERATED: <?php echo date('d-m-Y H:m:s'); ?></td>
                <td>GENERATED BY: <?php echo $_SESSION['username']; ?></td>
            <tr >
            
            <th>Total Number of Scripts In Belt: <?php echo $script_no; ?></th> 
            
            </tr>
            <tr>
                <th>Total Number of Examiners : <?php echo $row; ?></th> 
            </tr>
            <tr>
                <th>Grand Total : K<?php echo $claim * $row;; ?></th>
            </tr>
        </tbody>
    </table>
    <table class="w100 pt-10" >
        <tbody>
        <tr >
            <th >Verified By Team Leader:...........................................................</th>
            <th>Recommended By Centre Coordinator:....................................................</th>
        </tr>
        <tr class="pt-10">
            <th >Confirmed By Chief Examiner:.............................................................</th>
            <th>Approved By Director EAD:......................................................................</th>
           
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
$pdf->stream('Centers_in_belt', Array('Attachment'=>0));

}

?>