<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
$data_array = array();
include '../../config.php';
include '../../functions.php';

if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'DEO'){
        
if($_SESSION['session_token'] == generated_session_token($db_12_gce, $_SESSION['username'])){
        $data_array['status'] = '200';
}else{
         $data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>