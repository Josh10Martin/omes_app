<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
include '../../functions.php';
$data_array = array();
if($_SESSION['user_type'] == 'DEO'){
    if(activation_status($db_12_gce,$_SESSION['username'],$_SESSION['marking_centre_code']) == 1){
        $data_array['status'] = '200';
    }else{
        $data_array['status'] = '400';
    }
    // if(login_status($db_12_gce,$_SESSION['username']) == 1){
    //     $data_array['status'] = '400';
    //     $data_array['response_msg'] = 'There is another account using this session';
    //   }else{
    //     echo update_login_status($db_12_gce,$_SESSION['username']);
    //   }
}
echo json_encode($data_array);
?>