<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
    $sql =$db_9->prepare('SELECT SUM(attendance = "1") AS present, SUM(attendance = "0") AS absent FROM examiner');
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $data_array['present'] = $row['present'] ?? '';
    $data_array['absent'] = $row['absent'] ?? '';
}else if($_SESSION['user_type'] == 'SESO'){
    $sql =$db_9->prepare('SELECT SUM(attendance = "1") AS present, SUM(attendance = "0") AS absent FROM examiner WHERE province =:province_code');
    $sql->execute(array(
        ':province_code'=>$_SESSION['province_code']
    ));
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $data_array['present'] = $row['present'] ?? '';
    $data_array['absent'] = $row['absent'] ?? '';
}else{
    $sql =$db_9->prepare('SELECT SUM(attendance = "1") AS present, SUM(attendance = "0") AS absent FROM examiner WHERE province =:province_code AND marking_centre =:marking_centre_code');
    $sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':province_code'=>$_SESSION['province_code']
    ));
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $data_array['present'] = $row['present'] ?? '';
    $data_array['absent'] = $row['absent'] ?? '';
}
echo json_encode($data_array);
?>