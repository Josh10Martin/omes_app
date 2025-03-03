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
    if(isset($_POST['course_group']) && isset($_POST['attendance']) && isset($_POST['belt_no'])){
        $course_group = $_POST['course_group'];
        $attendance = $_POST['attendance'];
        $belt_no = $_POST['belt_no'];

        $i =0;
        if($belt_no == 'all'){
        $sql = $db_ted->prepare('SELECT ex.nrc AS nrc, CONCAT(ex.first_name," ",ex.last_name) AS full_name,ex.attendance AS attendance,
        cg.group_code AS group_code, cg.group_name AS group_name,ex.role AS role,co.course_code AS course_code, co.course_name AS course_name,
                                ex.account_no AS account_no,ex.bank AS bank,ex.branch AS branch
                                FROM  examiner ex INNER JOIN course co ON (ex.course_code = co.course_code)
                                INNER JOIN course_group cg ON (co.group_id = cg.group_code)
                                WHERE cg.group_code =:group_code
                                AND ex.attendance =:attendance
                                AND ex.session =:session
                                AND ex.marking_centre =:marking_centre_code');
        $sql->execute(array(
            ':group_code'=>$course_group,
            ':attendance'=>$attendance,
            ':session'=>$_SESSION['session_year'],
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));

        $sql->bindColumn('nrc',$nrc);
        $sql->bindColumn('full_name',$full_name);
        $sql->bindColumn('group_name',$group_name);
        $sql->bindColumn('group_code',$group_code);
        $sql->bindColumn('course_code',$course_code);
        $sql->bindColumn('course_name',$course_name);
        $sql->bindColumn('account_no',$account_no);
        $sql->bindColumn('attendance',$attendance_value);
        // $sql->bindColumn('no_of_days',$no_of_days);
        $sql->bindColumn('role',$role);
        $sql->bindColumn('bank',$bank);
        $sql->bindColumn('branch',$branch);
        $sql->fetch(PDO::FETCH_BOUND);
    }else{
        $sql = $db_ted->prepare('SELECT ex.nrc AS nrc, CONCAT(ex.first_name," ",ex.last_name) AS full_name, ex.attendance AS attendance,
                                cg.group_code AS group_code, cg.group_name AS group_name,ex.role AS role,co.course_code AS course_code, co.course_name AS course_name,
                                ex.account_no AS account_no,ex.bank AS bank,ex.branch AS branch
                                FROM  examiner ex INNER JOIN course co ON (ex.course_code = co.course_code)
                                INNER JOIN course_group cg ON (co.group_id = cg.group_code)
                                WHERE cg.group_code =:group_code
                                AND ex.attendance =:attendance
                                AND ex.session =:session
                                AND ex.belt_no =:belt_no
                                AND ex.attendance =:attendance
                                AND ex.marking_centre =:marking_centre_code');
        $sql->execute(array(
            ':group_code'=>$course_group,
            ':belt_no'=>$belt_no,
            ':attendance'=>$attendance,
            ':session'=>$_SESSION['session_year'],
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));

        $sql->bindColumn('nrc',$nrc);
        $sql->bindColumn('full_name',$full_name);
        $sql->bindColumn('group_name',$group_name);
        $sql->bindColumn('group_code',$group_code);
        $sql->bindColumn('course_code',$course_code);
        $sql->bindColumn('course_name',$course_name);
        $sql->bindColumn('account_no',$account_no);
        $sql->bindColumn('attendance',$attendance_value);
        // $sql->bindColumn('no_of_days',$no_of_days);
        $sql->bindColumn('role',$role);
        $sql->bindColumn('bank',$bank);
        $sql->bindColumn('branch',$branch);
        $sql->fetch(PDO::FETCH_BOUND);
    }
?>

<doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../../assets/css/reports.css">
        <title>Attendance Report</title>
    </head>
    <body>
   
        <style>
      </style>
    <table class="center" style="width: 500px;margin-bottom:3px;">
        <tr >
            <td>
                <img src="../../assets/img/eczlogo_tr_sm.jpg" style="width:60%">
            </td>
            <td>
               <p  style="text-align: center;">EXAMINATIONS COUNCIL OF ZAMBIA</p> 
                <p style="text-align: center;"><?php echo $_SESSION['session_name']; ?></p>
                <p style="text-align: center;">EXAMINER'S ATTENDANCE REPORT</p> 
            </td>
        </tr>
    </table>

    <table class="head-data w100" style="margin-top: 5px;">
    <tr>
        <th>
            Marking Centre Code: <?php echo $_SESSION['marking_centre_code']; ?>    
        </th>
        <th>
            Group Code: <?php echo $group_code; ?>
        </th>
        <th>
            Group Name: <?php echo $group_name; ?>
        </th>
    </tr>
    <tr>
        
    </tr>
    <tr>
        <th>
            Marking Centre Name: <?php echo $_SESSION['marking_centre']; ?>
        </th>
        <th>
            
        </th>
           
        <th>
            Attendance: <?php echo $attendance_value == 1 ?'Present' : 'Absent'; ?>
        </th>
        
    </tr>
    </table>

    <table class=" w100" style=" margin-top:10px;">
        <thead style="border-bottom: 1px solid black;border-top: 1px solid black;">
            <th>
                NRC
            </th>
            <th>
                FULL NAME
            </th>
            <th>
                ROLE
            </th>
            <th>
                COURSE / MAJOR
            </th>
            <!-- <th>
                DAYS
            </th> -->
            <th>
                ACCOUNT NO
            </th>
            <th>
                BANK
            </th>
            <th>
                BRANCH
            </th>
        </thead>
        <tbody >
            <?php
            do{
            ?>
            <tr>
                <td><?php echo $nrc; ?></td>
                <td><?php echo $full_name; ?></td>              
                <td><?php echo $role; ?></td>
                <td><?php echo $course_code,' - ',$course_name; ?></td>
                <!-- <td><?php // echo $no_of_days; ?></td> -->
                <td><?php echo $account_no; ?></td>
                <td><?php echo $bank; ?></td>
                <td><?php echo $branch; ?></td>
                
            </tr>
            <?php
            $i++;
            } while($sql->fetch(PDO::FETCH_BOUND));
            ?>
        </tbody>
    </table>

    <div>
        <p><strong>Total Number Of Examiners: <?php if($nrc){echo $i;}else{echo '0';}; ?></strong> </p>
    </div>

    <table class="w100">
        <tbody>
            <tr>
                <th>VERIFIED BY CHIEF EXAMINER (FULLNAME):..............................</th>
                <th>SIGNATURE:............................................................</</th>
            </tr>
            <tr>
                <th>CONFIRMED BY CENTRE COORDINATOR (FULLNAME):............................................................</</th>
                <th>SIGNATURE:............................................................</</th>
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
$pdf->stream('Attendance Report', Array('Attachment'=>0));
}

?>