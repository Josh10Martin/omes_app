<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_POST['subject_code']) && isset($_POST['paper_no'])){
    $subject_code = $_POST['subject_code'];
    $paper_no = $_POST['paper_no'];
    $data_array['chief_examiner_username'] = chief_examiner_username($db_12_gce,$subject_code,$paper_no);
}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>