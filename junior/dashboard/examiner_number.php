<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
        $sql = $db_9->prepare('SELECT COUNT(nrc) AS no_of_examiners FROM examiner');
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['response_msg'] = $row['no_of_examiners'] ?? '0';
}else if($_SESSION['user_type'] == 'ADMIN'){
        $sql = $db_9->prepare('SELECT COUNT(nrc) AS no_of_examiners FROM examiner WHERE marking_centre =:marking_centre_code AND province =:province_code');
        $sql->execute(array(
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':province_code'=>$_SESSION['province_code']
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['response_msg'] = $row['no_of_examiners'] ?? '0';
}else{
        $sql = $db_9->prepare('SELECT COUNT(nrc) AS no_of_examiners FROM examiner WHERE province =:province_code');
        $sql->execute(array(
                
                ':province_code'=>$_SESSION['province_code']
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['response_msg'] = $row['no_of_examiners'] ?? '0';
}

echo json_encode($data_array);
?>