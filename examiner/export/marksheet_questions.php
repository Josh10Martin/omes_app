<?php
// ini_set('memory_limit', '-1');
// ini_set('max_execution_time', '0');

include '../../config.php';

if(isset($_POST['subject']) || isset($_POST['paper'])){
   $subject_code = $_POST['subject'];
   $sen = $_POST['sen'];
   $improvised = $_POST['improvised'];
   $paper_no = isset($_POST['paper']) ? $_POST['paper'] : '';
   
    $filename = 'subject_'.$subject_code.'_paper_'.$paper_no.'.csv';
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Content-Type: application/csv ');

    $file = fopen('php://output', 'w');
    $fields = array('CENTRE CODE','EXAM NUMBER','FIRST NAME','LAST NAME','SUBJECT CODE','PAPER NUMBER','QUESTION','MARK','STATUS','ENTERED BY','DATE ENTERED');
    fputcsv($file, $fields);
   if($subject_code == 'all'){
    $sql = $db_12_gce->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no,question, mark,status, entered_by,date_entered
                        FROM marks_questions WHERE status <> "L" AND sen =:sen AND improvised_mark =:improvised ORDER BY exam_no, centre_code');
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
        $data[] = $row['question'];
        $data[] = $row['mark'];
        $data[] = $row['status'];
        $data[] = $row['entered_by'];
        $data[] = $row['date_entered'];
        fputcsv($file, $data);
    }
    fclose($file);
    exit;
   }else{
    
    $sql = $db_12_gce->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no,question, mark,status,entered_by,date_entered
                        FROM marks_questions WHERE subject_code =:subject_code AND paper_no =:paper_no AND sen =:sen AND improvised_mark =:improvised AND status <> "L" ORDER BY exam_no, centre_code');
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
        $data[] = $row['question'];
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
