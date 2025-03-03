<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
include '../../functions.php';
$data_array = array();
if($_SESSION['user_type'] == 'DEO'){
    if(activation_status_9($db_9,$_SESSION['username'],$_SESSION['marking_centre_code']) == 1){
        $data_array['status'] = '200';
    }else{
        $data_array['status'] = '400';
    }
    
}
echo json_encode($data_array);
?>