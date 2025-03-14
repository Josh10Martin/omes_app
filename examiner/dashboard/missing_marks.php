<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
        $sql = $db_12_gce->prepare('SELECT COUNT(exam_no) AS no_of_missing_marks FROM marks WHERE status = "L"');
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['response_msg'] = $row['no_of_missing_marks'] ?? '0';

}else{
        $sql = $db_12_gce->prepare('SELECT COUNT(exam_no) AS no_of_missing_marks FROM marks WHERE marking_centre =:marking_centre_code AND status = "L"');
        $sql->execute(array(
                
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['response_msg'] = $row['no_of_missing_marks'] ?? '0';

}

echo json_encode($data_array);
?>