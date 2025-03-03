<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$sql = $db_ted->prepare('UPDATE session SET id = "0",name ="", year ="", type=""');
$sql->execute();
if($sql->rowCount() > 0){
    $data_array['status'] = '200';
    unset($_SESSION['session_id']);
    unset($_SESSION['session_name']);
    unset($_SESSION['session_year']);
    unset($_SESSION['session_type']);
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was a problem removing session';
}
echo json_encode($data_array);
?>