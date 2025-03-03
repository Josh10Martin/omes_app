<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['centre_code']) && isset($_POST['subject_code']) && isset($_POST['paper_no'])){
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $paper_no = $_POST['paper_no'];

        $sql = $db_12_gce->prepare('UPDATE marks_questions SET disable = 0 WHERE centre_code =:centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND disable = 1 AND marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':centre_code'=>$centre_code,
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'SUccessfully enabled editting of marks';
        }else{
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'Could not enabled editting of some marks as they may have been already enabled';
        }
        
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters set for enabling edit';
}
echo json_encode($data_array);
;?>