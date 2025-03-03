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

    if(isset($_POST['subject']) && isset($_POST['paper']) ){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $centre_type = $_POST['centre_type'];
        
        $sql = $db_12_gce->prepare('SELECT su.subject_code AS subject_code,su.subject_name AS subject_name, pa.paper_no AS paper_no,
                                   CAST(m.mark AS UNSIGNED) AS mark, COUNT(m.exam_no) AS no_of_candidates,
                                 (SELECT COUNT(*) FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code) AS total_no_of_candidates, 
                                 (SELECT COUNT(*) FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code AND status ="L") AS no_of_missing_mark, 
                                 (SELECT COUNT(*) FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code  AND status ="X")AS no_of_absentees,
                                 (SELECT mark FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code AND status NOT IN ("X","L") ORDER BY CAST(mark AS UNSIGNED) DESC LIMIT 1) AS highest_mark,
                                 (SELECT mark FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code AND status NOT IN ("X","L") ORDER BY CAST(mark AS UNSIGNED) ASC LIMIT 1) AS lowest_mark
                                FROM marks m INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                                WHERE m.paper_no = pa.paper_no
                                AND m.subject_code = pa.subject_code
                                AND m.subject_code =:subject_code
                                AND m.paper_no =:paper_no
                                AND m.status NOT IN ("L","X")
                                AND m.centre_code IN (SELECT centre_code FROM school WHERE centre_type =:centre_type)
                                AND m.marking_centre =:marking_centre_code
                                GROUP BY su.subject_code,su.subject_name,pa.paper_no, CAST(m.mark AS UNSIGNED)
                                ORDER BY CAST(m.mark AS UNSIGNED) DESC');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':centre_type'=>$centre_type,
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));

        if($sql ->rowCount() > 0){
            $data_array['status'] = '200';
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $data_array[0]['subject_code'] = $row['subject_code'];
            $data_array[0]['subject_name'] = $row['subject_name'];
            $data_array[0]['paper_no'] = $row['paper_no'];
            $data_array[0]['total_no_of_candidates'] = $row['total_no_of_candidates'];
            #$data_array[0]['no_of_candidates'] = $row['no_of_candidates'];
            $data_array[0]['mark'] = $row['mark'];
            $data_array[0]['no_of_missing_mark'] = $row['no_of_missing_mark'];
            $data_array[0]['highest_mark'] = $row['highest_mark'];
            $data_array[0]['lowest_mark'] = $row['lowest_mark'];
            $data_array[0]['no_of_absentees'] = $row['no_of_absentees'];
         
            $i=1;
            while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                    $data_array[$i]['mark'] = $row['mark'];
                    $data_array[$i]['no_of_candidates'] = $row['no_of_candidates'];
                    $i++;
            }
    }else{
            $data_array['status'] = '400';
    }
    echo json_encode($data_array);

    }
?>