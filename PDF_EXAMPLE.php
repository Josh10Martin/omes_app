
<?php

     
    require_once '../php/config.php';
    // require_once '../php/functions.php';
    require_once '../dompdf/autoload.inc.php';
    // require_once '../qrcode/qrlib.php';
    use Dompdf\Dompdf;
    use Dompdf\Options;
    use Dompdf\FontMetrics;

    $options = new Options();
    $options->set('isphpEnabled', 'true');
    
   

    $pdf = new Dompdf($options);
    ob_start();
         
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../layouts/styles.css">
    <title>Provisional register [<?php if($receipt != 'PENDING'){echo 'final';}else{echo 'pending';} ?>]</title>
</head>
<body class="pdf">
    <table class="head">
        <tr>
            <td>
                <img src="../images/logo.j" alt="" srcset="">
            examinations council of zambia <br /> <?php echo $_SESSION['year']; ?> <?php echo isset($_SESSION['level']) ? $_SESSION['level'] : ''; ?> examinations <br /> candidate provisional register [<?php if($receipt != 'PENDING'){echo 'final';}else{echo 'pending';} ?>] <br /> <?php echo $_SESSION['centre_code']; ?> - <?php echo $_SESSION['centre_name']; ?> <br /> <?php echo $_SESSION['district_name']; ?> district, <?php echo $_SESSION['province_name']; ?> province

            </td>
        </tr>
    </table>
    <?php if($receipt != 'PENDING'){ ?>
    <table class="foot">
        
        <tr>
        <td>date verified ................../.........../................/</td>
        <td>head teachers full name ..............................................................................................</td>
        <td>head teachers signature.........................................</td>
        
    </tr>
</table>
<?php } ?>
    <table class="data">
        <tr>
            <th style="width:2cm;">exam no.</th>
            <th style="width:2cm;">surname</th>
            <th style="width:2.5cm;">othername(s)</th>
            <th style="width:1cm;">sex</th>
            <?php if($_SESSION['centre_type'] == 'E'){ ?>
            <th style="width:1cm;">nrc / passport</th>
            <?php } ?>
            <th style="width:2cm;">dob</th>
            <th style="width:2.5cm;">sen</th>
            <th style="width:3cm;">subjects</th>
            <?php if($receipt != 'PENDING'){ ?>
            <th style="width:2cm;">receipt no</th>
           
            <th>signature</th>
            <?php } ?>
        </tr>
        
            <?php do{ ?>
                <tr>
            <td><?php echo $exam_no; ?></td>
            <td><?php echo $surname; ?></td>
            <td><?php echo $othername; ?></td>
            <td><?php echo $sex; ?></td>
            <?php if($_SESSION['centre_type'] == 'E'){ ?>
            <td><?php echo $nrc_pass; ?></td>
            <?php } ?>
            <td><?php echo $dob; ?></td>
            <td><?php echo $sen_desc; ?></td>
            <td><?php echo $subjects_registered,' [',$subject_no,']'; ?></td>
            <?php if($receipt != 'PENDING'){ ?>
            <td><?php echo $receipt_no; ?></td>
          
            <td></td>
            <?php } ?>
            </tr>
            <?php } while($sql->fetch(PDO::FETCH_BOUND));?>
            <tr>
            <td class="total" colspan="2" style=" text-align:left; text-transform:uppercase;border-bottom:none; border-left:none; border-right:none;">total number of candidates: <?php echo $total; ?></td>
        <td style="border-bottom:none; border-left:none; border-right:none;"></td>
        <td style="border-bottom:none; border-left:none; border-right:none;"></td>
        <td style="border-bottom:none; border-left:none; border-right:none;"></td>
        <td style="border-bottom:none; border-left:none; border-right:none;"></td>
        <?php if($_SESSION['centre_type'] == 'E'){ ?>
        <td style="border-bottom:none; border-left:none; border-right:none;"></td>
        <?php } ?>
        <td style="border-bottom:none; border-left:none; border-right:none;"></td>
        <?php if($receipt != 'PENDING'){ ?>
        <td style="border-bottom:none; border-left:none; border-right:none;"></td>
        
        <td style="border-bottom:none; border-left:none; border-right:none;"></td>
        <?php
        }
        ?>
       

            </tr>
    </table>

   
</body>
</html>
<?php

    $filename = $_SESSION['centre_code'].'_provisional_register.pdf';
////////////////render pdf////////////
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
    $date_generated = 'date generated: '.date("d/m/Y h:m:s a");
    // $serial = $in_serial;

    $textHeight = $fontMetrics->getFontHeight($text, 20);
    $textWidth = $fontMetrics->getTextWidth($font, $text, 5);

    $x = $w - $textWidth;
    $y = $h - $textHeight;

    $canvas->page_text($x, $y, $text, $font, 10);
    $canvas->page_text(500, $y, $date_generated, $font, 10);
    // $canvas->page_text(50, 805, $serial, $font, 10);
    // $pdf->stream($filename);
    $pdf->stream($filename, Array('Attachment'=>0));

    
?>