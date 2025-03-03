<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
        $sql = $db_12_gce->prepare('SELECT COUNT(*) AS no_of_examiners,SUM(attendance = 1) AS no_of_examiners_present FROM examiner');
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['no_of_examiners'] = $row['no_of_examiners'] ?? '0';
        $data_array['no_of_examiners_present'] = $row['no_of_examiners_present'] ?? '0';
}else {
        $sql = $db_12_gce->prepare('SELECT COUNT(*) AS no_of_examiners,SUM(attendance = 1) AS no_of_examiners_present FROM examiner WHERE marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['no_of_examiners'] = $row['no_of_examiners'] ?? '0';
        $data_array['no_of_examiners_present'] = $row['no_of_examiners_present'] ?? '0';
}

echo json_encode($data_array);
?>