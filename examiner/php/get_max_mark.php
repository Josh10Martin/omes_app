<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_POST['subject_code']) && isset($_POST['paper_no'])){
    $subject_code = $_POST['subject_code'];
    $paper_no = $_POST['paper_no'];

    $sql = $db_12_gce->prepare('SELECT max_mark FROM paper WHERE subject_code =:subject_code AND paper_no =:paper_no');
    $sql->execute(array(
        ':subject_code'=>$subject_code,
        ':paper_no'=>$paper_no
    ));
    $row = $sql->fetch(PDO:: FETCH_ASSOC);
    $data_array['max_mark'] = $row['max_mark'] ?? '';
}
echo json_encode($data_array);
?>