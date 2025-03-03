<?php
// ini_set('memory_limit', '-1');
// ini_set('max_execution_time', '0');

include '../../config.php';

if(isset($_POST['subject']) && isset($_POST['improvised']) && isset($_POST['sen']) && isset($_POST['session'])){
   $subject_code = $_POST['subject'];
   $improvised = $_POST['improvised'];
   $sen = $_POST['sen'];
   $session = $_POST['session'];
   
    $filename = 'subject_'.$subject_code.'_paper_'.$paper_no.'.csv';
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Content-Type: application/csv ');

    $file = fopen('php://output', 'w');
    $fields = array('centre_code','exam_number','first_name','last_name','subject_code','paper_number','mark','status','entered_by','date_entered');
    fputcsv($file, $fields);
   if($subject_code = 'all'){
    $sql = $db_ted->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code,"2", mark,status,entered_by,date_entered
                        FROM marks WHERE status <> "L" AND improvised_mark =:improvised AND sen =:sen AND session =:session ORDER BY exam_no, centre_code');
    $sql->execute(array(
        ':improvised'=>$improvised,
        ':sen'=>$sen,
        ':session'=>$session
    ));
    $result = $sql->fetchAll();
    foreach($result as $row){
        $data = array();
        $data[] = $row['centre_code'];
        $data[] = $row['exam_no'];
        $data[] = $row['first_name'];
        $data[] = $row['last_name'];
        $data[] = $row['subject_code'];
        $data[] = $row['mark'];
        $data[] = $row['status'];
        $data[] = $row['entered_by'];
        $data[] = $row['date_entered'];
        fputcsv($file, $data);
    }
    fclose($file);
    exit;
   }else{
    $sql = $db_ted->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code,"2", mark,status,entered_by,date_entered
                        FROM marks WHERE subject_code =:subject_code AND status <> "L" AND improvised_mark =:improvised AND sen =:sen AND session =:session ORDER BY exam_no, centre_code');
    $sql->execute(array(
        ':subject_code'=>$subject_code,
        ':improvised'=>$improvised,
        ':sen'=>$sen,
        ':session'=>$session
    ));
    $result = $sql->fetchAll();
    foreach($result as $row){
        $data = array();
        $data[] = $row['centre_code'];
        $data[] = $row['exam_no'];
        $data[] = $row['first_name'];
        $data[] = $row['last_name'];
        $data[] = $row['subject_code'];
        $data[] = $row['mark'];
        $data[] = $row['status'];
        $data[] = $row['entered_by'];
        $data[] = $row['date_entered'];
        fputcsv($file, $data);
    }
    fclose($file);
    exit;
   }
}
?>
