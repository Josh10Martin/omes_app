<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
$data_array = array();
if(isset($_SESSION['user_type'])){
if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
    if((!isset($_SESSION['user_type']) || empty($_SESSION['user_type'])) && (!isset($_SESSION['username']) || empty($_SESSION['username'])) && (!isset($_SESSION['first_name']) || empty($_SESSION['first_name'])) && (!isset($_SESSION['last_name']) || empty($_SESSION['last_name'])) && (!isset($_SESSION['province_code']) || empty($_SESSION['province_code'])) && (!isset($_SESSION['province_name']) || empty($_SESSION['province_name'])) && (!isset($_SESSION['marking_centre']) || empty($_SESSION['marking_centre'])) && (!isset($_SESSION['marking_centre_code']) || empty($_SESSION['marking_centre_code'])) && (!isset($_SESSION['session_id']) || empty($_SESSION['session_id'])) && (!isset($_SESSION['session_name']) || empty($_SESSION['session_name'])) && (!isset($_SESSION['session_year']) || empty($_SESSION['session_year'])) && (!isset($_SESSION['session_type']) || empty($_SESSION['session_type'])) && (!isset($_SESSION['session_level']) || empty($_SESSION['session_level']))){
        $data_array['status'] = '400';
    }else{
        $data_array['status'] = '200';
    }
}else if($_SESSION['user_type'] == 'ECZ'){
    if((!isset($_SESSION['user_type']) || empty($_SESSION['user_type'])) && (!isset($_SESSION['username']) || empty($_SESSION['username'])) && (!isset($_SESSION['first_name']) || empty($_SESSION['first_name'])) && (!isset($_SESSION['last_name']) || empty($_SESSION['last_name'])) && (!isset($_SESSION['session_id']) || empty($_SESSION['session_id'])) && (!isset($_SESSION['session_name']) || empty($_SESSION['session_name'])) && (!isset($_SESSION['session_year']) || empty($_SESSION['session_year'])) && (!isset($_SESSION['session_type']) || empty($_SESSION['session_type'])) && (!isset($_SESSION['session_level']) || empty($_SESSION['session_level']))){
        $data_array['status'] = '400';
    }else{
        $data_array['status'] = '200';
    }
}else{
    $data_array['status'] = '400';
}
}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>