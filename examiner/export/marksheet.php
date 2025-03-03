<?php
// ini_set('memory_limit', '-1');
// ini_set('max_execution_time', '0');

include '../../config.php';

if(isset($_POST['marking_centre']) ){
   $marking_centre_code = $_POST['marking_centre'];
   $subject_code = isset($_POST['subject_code']) ? $_POST['subject_code'] : '';
   $sen = $_POST['sen'];
   $improvised = $_POST['improvised'];
   $centre_code = isset($_POST['centre_code']) ? $_POST['centre_code'] : '';
   $paper_no = isset($_POST['paper_no']) ? $_POST['paper_no'] : '';
   
    $filename = 'subject_'.$subject_code.'_paper_'.$paper_no.'.csv';
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.$filename);
    header('Content-Type: application/csv ');

    $file = fopen('php://output', 'w');
    $fields = array('CENTRE CODE','EXAM NUMBER','FIRST NAME','LAST NAME','SUBJECT CODE','PAPER NUMBER','MARK','STATUS','ENTERED BY','DATE ENTERED');
    fputcsv($file, $fields);

  if($marking_centre_code == 'all'){
            $sql = $db_12_gce->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no, mark,status,entered_by,date_entered
            FROM marks WHERE sen =:sen AND improvised_mark =:improvised AND status <> "L" ORDER BY exam_no, centre_code');
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
            fputcsv($file, $data);
            }
            fclose($file);

  }else{
    if($subject_code == 'all'){
        $sql = $db_12_gce->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no, mark,status,entered_by,date_entered
            FROM marks WHERE sen =:sen AND improvised_mark =:improvised AND status <> "L" AND marking_centre =:marking_centre_code ORDER BY exam_no, centre_code');
            $sql->execute(array(
            ':sen'=>$sen,
            ':improvised'=>$improvised,
            ':marking_centre_code'=>$marking_centre_code
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
            fputcsv($file, $data);
            }
            fclose($file);
    }else{
        if($centre_code == 'all'){
            $sql = $db_12_gce->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no, mark,status,entered_by,date_entered
                            FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no AND sen =:sen AND improvised_mark =:improvised AND status <> "L" AND marking_centre =:marking_centre_code ORDER BY exam_no, centre_code');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':sen'=>$sen,
            ':improvised'=>$improvised,
            ':marking_centre_code'=>$marking_centre_code
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
            fputcsv($file, $data);
        }
        fclose($file);
        exit;
        }else{
            $sql = $db_12_gce->prepare('SELECT centre_code,exam_no, first_name, last_name,subject_code, paper_no, mark,status,entered_by,date_entered
                            FROM marks WHERE centre_code =:centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND sen =:sen AND improvised_mark =:improvised AND status <> "L" AND marking_centre =:marking_centre_code ORDER BY exam_no, centre_code');
        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':centre_code'=>$centre_code,
            ':sen'=>$sen,
            ':improvised'=>$improvised,
            ':marking_centre_code'=>$marking_centre_code
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
            fputcsv($file, $data);
        }
        fclose($file);
        exit;
        }
    }
  }
    
   
}
?>
