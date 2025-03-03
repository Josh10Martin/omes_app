<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_POST['subject_name'])){
    $subject_name = $_POST['subject_name'];
    $data_array['subject_code'] = subject_code($db_12_gce,$subject_name);
}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>