<?php
session_start();
header('Content-Type:application/json; charset=utf-8');
include '../config.php';
include '../functions.php';
$data_array = array();
if(isset($_POST['username']) && isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['user_type']) && isset($_POST['marking_centre_name']) && isset($_POST['subject_code']) && isset($_POST['subject_name']) && isset($_POST['paper_number']) && isset($_POST['session_id']) && isset($_POST['session_name']) && isset($_POST['session_level']) && isset($_POST['session_type']) && isset($_POST['session_year'])){
    
    if($_POST['user_type'] == 'DEO'){
        if(attendance_status($db_12_gce,$_POST['username']) != 'true'){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Unable to log user in. '.attendance_status($db_12_gce,$_POST['username']);
        }else{
        if(login_status($db_12_gce,$_POST['username']) == 0){
            update_login_status($db_12_gce,$_POST['username']);
            $data_array['status'] = '200';
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['first_name'] = trim(strtoupper($_POST['first_name']));
            $_SESSION['last_name'] = trim(strtoupper($_POST['last_name']));
            $_SESSION['user_type'] = trim(strtoupper($_POST['user_type']));
            $_SESSION['marking_centre_code'] = md5(trim(strtoupper($_POST['marking_centre_name'])));
            $_SESSION['marking_centre'] = trim(strtoupper($_POST['marking_centre_name']));
            $_SESSION['subject_code'] = trim($_POST['subject_code']);
            $_SESSION['subject_name'] = trim(strtoupper($_POST['subject_name']));
            $_SESSION['paper_no'] = trim($_POST['paper_number']);
            $_SESSION['session_id'] = $_POST['session_id'];
            $_SESSION['session_name'] = $_POST['session_name'];
            $_SESSION['session_level'] = $_POST['session_level'];
            $_SESSION['session_type'] = $_POST['session_type'];
            $_SESSION['session_year'] = $_POST['session_year'];
        }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There might be another session using this account';
    }
    }
    }else{
        $data_array['status'] = '200';
        $_SESSION['username'] = $_POST['username'];
        $_SESSION['first_name'] = trim(strtoupper($_POST['first_name']));
        $_SESSION['last_name'] = trim(strtoupper($_POST['last_name']));
        $_SESSION['user_type'] = trim(strtoupper($_POST['user_type']));
        $_SESSION['marking_centre_code'] = md5(trim(strtoupper($_POST['marking_centre_name'])));
        $_SESSION['marking_centre'] = trim(strtoupper($_POST['marking_centre_name']));
        $_SESSION['subject_code'] = trim($_POST['subject_code']);
        $_SESSION['subject_name'] = trim(strtoupper($_POST['subject_name']));
        $_SESSION['paper_no'] = trim($_POST['paper_number']);
        $_SESSION['session_id'] = $_POST['session_id'];
        $_SESSION['session_name'] = $_POST['session_name'];
        $_SESSION['session_level'] = $_POST['session_level'];
        $_SESSION['session_type'] = $_POST['session_type'];
        $_SESSION['session_year'] = $_POST['session_year'];
    }
 
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Parameters not set';
}
echo json_encode($data_array);
?>