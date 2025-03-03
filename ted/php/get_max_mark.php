<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_POST['subject_code'])){
    $subject_code = $_POST['subject_code'];

    $sql = $db_ted->prepare('SELECT max_mark FROM subjects WHERE subject_code =:subject_code AND session =:session');
    $sql->execute(array(
        ':subject_code'=>$subject_code,
        ':session'=>$_SESSION['session_year']
    ));
    $row = $sql->fetch(PDO:: FETCH_ASSOC);
    $data_array['max_mark'] = $row['max_mark'] ?? '';
}
echo json_encode($data_array);
?>