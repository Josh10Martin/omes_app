<?php
// ini_set('memory_limit', '-1');
// ini_set('max_execution_time', '0');

include '../../config.php';

if(isset($_POST['province'])){
    
    $province_code = explode(':', $_POST['province'])[0];
   $subject_code = $_POST['subject'];
   $marking_centre_code = isset($_POST['marking_centre']) ? $_POST['marking_centre'] : '';
   $subject_code = isset($_POST['subject']) ? $_POST['subject'] : '';
   $paper_no = isset($_POST['paper']) ? $_POST['paper'] : '';

   $sen = $_POST['sen'];
   $improvised = $_POST['improvised'];
   
    $filename = 'subject_'.$subject_code.'_paper_'.$paper_no.'.csv';
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Content-Type: application/csv ');

    $file = fopen('php://output', 'w');
    $fields = array('centre_code','exam_number','first_name','last_name','subject_code','paper_number','mark','status','entered_by','date_entered','marking_centre','province_code');
    fputcsv($file, $fields);
   if($province_code == 'all'){
    $sql = $db_9->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no, mark,status,entered_by,date_entered,marking_centre,province
                        FROM marks WHERE status <> "L" AND sen =:sen AND improvised_mark =:improvised ORDER BY exam_no, centre_code');
    $sql->execute(array(
        ':sen'=>$sen,
        ':improvised'=>$improvised
    ));
    $result = $sql->fetchAll();
    foreach($result as $row){
        $data = array();
        $data[] = $row['centre_code'];
        $data[] = $row['exam_no'];
        $data[] = $row['first_name'];
        $data[] = $row['last_name'];
        $data[] = $row['subject_code'];
        $data[] = $row['paper_no'];
        $data[] = $row['mark'];
        $data[] = $row['status'];
        $data[] = $row['entered_by'];
        $data[] = $row['date_entered'];
        $data[] = $row['marking_centre'];
        $data[] = $row['province'];
        fputcsv($file, $data);
    }
    fclose($file);
    exit;
   }else{
        if($marking_centre_code == 'all'){
             $sql = $db_9->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no, mark,status,entered_by,date_entered,marking_centre,province
                        FROM marks WHERE status <> "L" AND sen =:sen AND improvised_mark =:improvised AND province =:province_code ORDER BY exam_no, centre_code');
    $sql->execute(array(
        ':sen'=>$sen,
        ':improvised'=>$improvised,
        ':province_code'=>$province_code
    ));
    $result = $sql->fetchAll();
    foreach($result as $row){
        $data = array();
        $data[] = $row['centre_code'];
        $data[] = $row['exam_no'];
        $data[] = $row['first_name'];
        $data[] = $row['last_name'];
        $data[] = $row['subject_code'];
        $data[] = $row['paper_no'];
        $data[] = $row['mark'];
        $data[] = $row['status'];
        $data[] = $row['entered_by'];
        $data[] = $row['date_entered'];
        $data[] = $row['marking_centre'];
        $data[] = $row['province'];
        fputcsv($file, $data);
    }
    fclose($file);
    exit;
        }else{
            if($subject_code == 'all'){
                $sql = $db_9->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no, mark,status,entered_by,date_entered,marking_centre,province
                        FROM marks WHERE status <> "L" AND sen =:sen AND improvised_mark =:improvised AND province =:province_code AND marking_centre =:marking_centre_code ORDER BY exam_no, centre_code');
    $sql->execute(array(
        ':sen'=>$sen,
        ':improvised'=>$improvised,
        ':marking_centre_code'=>$marking_centre_code,
        ':province_code'=>$province_code
    ));
    $result = $sql->fetchAll();
    foreach($result as $row){
        $data = array();
        $data[] = $row['centre_code'];
        $data[] = $row['exam_no'];
        $data[] = $row['first_name'];
        $data[] = $row['last_name'];
        $data[] = $row['subject_code'];
        $data[] = $row['paper_no'];
        $data[] = $row['mark'];
        $data[] = $row['status'];
        $data[] = $row['entered_by'];
        $data[] = $row['date_entered'];
        $data[] = $row['marking_centre'];
        $data[] = $row['province'];
        fputcsv($file, $data);
    }
    fclose($file);
    exit;
            }else{
                $sql = $db_9->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no, mark,status,entered_by,date_entered,marking_centre,province
                FROM marks WHERE status <> "L" AND sen =:sen AND improvised_mark =:improvised AND province =:province_code AND marking_centre =:marking_centre_code AND subject_code =:subject_code AND paper_no =:paper_no ORDER BY exam_no, centre_code');
    $sql->execute(array(
    ':sen'=>$sen,
    ':improvised'=>$improvised,
    ':subject_code'=>$subject_code,
    ':paper_no'=>$paper_no,
    ':marking_centre_code'=>$marking_centre_code,
    ':province_code'=>$province_code
    ));
    $result = $sql->fetchAll();
    foreach($result as $row){
    $data = array();
    $data[] = $row['centre_code'];
    $data[] = $row['exam_no'];
    $data[] = $row['first_name'];
    $data[] = $row['last_name'];
    $data[] = $row['subject_code'];
    $data[] = $row['paper_no'];
    $data[] = $row['mark'];
    $data[] = $row['status'];
    $data[] = $row['entered_by'];
    $data[] = $row['date_entered'];
    $data[] = $row['marking_centre'];
    $data[] = $row['province'];
    fputcsv($file, $data);
    }
    fclose($file);
    exit;
            }
        }
    $sql = $db_9->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no, mark,status,entered_by,date_entered,marking_centre,province
                        FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND sen =:sen AND improvised_mark =:improvised AND status <> "L" ORDER BY exam_no, centre_code');
    $sql->execute(array(
        ':subject_code'=>$subject_code,
        ':paper_no'=>$paper_no,
        ':sen'=>$sen,
        ':improvised'=>$improvised
    ));
    $result = $sql->fetchAll();
    foreach($result as $row){
        $data = array();
        $data[] = $row['centre_code'];
        $data[] = $row['exam_no'];
        $data[] = $row['first_name'];
        $data[] = $row['last_name'];
        $data[] = $row['subject_code'];
        $data[] = $row['paper_no'];
        $data[] = $row['mark'];
        $data[] = $row['status'];
        $data[] = $row['entered_by'];
        $data[] = $row['date_entered'];
        $data[] = $row['marking_centre'];
        $data[] = $row['province'];
        fputcsv($file, $data);
    }
    fclose($file);
    exit;
   }
}
?>
