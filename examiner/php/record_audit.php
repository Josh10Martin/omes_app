<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if (
    isset($_POST['centre_code']) && 
    isset($_POST['subject_code']) && 
    isset($_POST['paper_no']) && 
    isset($_POST['improvised']) &&
    isset($_POST['username']) &&
    isset($_POST['first_name']) &&
    isset($_POST['last_name'])
) {
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $paper_no = $_POST['paper_no'];
        $improvised = $_POST['improvised'];
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date_time = date('d/m/Y H:m:s');
        try{
        $sql = $db_12_gce->prepare('INSERT IGNORE INTO marks_audit_trail (centre_code, subject_code, paper_no, improvised_mark, entered_by,action, date_entered, marking_centre)
                                        VALUES(:centre_code, :subject_code, :paper_no, :improvised, CONCAT(:username," - ",:first_name," ",:last_name),"MARKSHEET DISABLED", :date_time, :marking_centre_code)
                                        
                                        ');
        $sql->execute(array(
                ':centre_code'=>$centre_code,
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':improvised'=>$improvised,
                ':date_time'=>$date_time,
                ':username'=>$username,
                ':first_name'=>$first_name,
                ':last_name'=>$last_name,
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
              
        }else{
                $data_array['status'] = '400';
              
        }
        
        }catch(PDOException $e){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Error recording: '.$e->getMessage();
        }
        
        
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters set for enabling edit';
}
echo json_encode($data_array);
;?>