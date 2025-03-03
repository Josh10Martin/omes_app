<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
if(isset($_POST['centre_code']) && isset($_POST['subject_code']) && isset($_POST['paper_no'])){
    $centre_code = $_POST['centre_code'];
    $subject_code = $_POST['subject_code'];
    $paper_no = $_POST['paper_no'];
    if(centre_in_belt_g12_gce($db_12_gce,$subject_code,$paper_no,$centre_code,$_SESSION['marking_centre_code']) != 'false'){
        $data_array['status'] = '200';
        $data_array['response_msg'] = $data_array['status'] = '400';
    $data_array['response_msg'] =centre_in_belt_g12_gce($db_12_gce,$subject_code,$paper_no,$centre_code,$_SESSION['marking_centre_code']);
    }else{
        $data_array['status'] = '400';
    }

}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Not all parameters are set for checking belt number';
}
echo json_encode($data_array);
?>