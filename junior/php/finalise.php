<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
try{
$inserted_rows = isset($_SESSION['inserted_rows']) ? $_SESSION['inserted_rows'] : '[UNKNOWN]';
$rejected_rows = isset($_SESSION['rejected_rows']) ? $_SESSION['rejected_rows'] : '[UNKNOWN]';
$data_array['status'] = '200';
    $deleted = remove_subject_paper_from_marksheet_not_belong($db_9);
    $data_array['response_msg'] = 'Successfully uploaded '.$inserted_rows.' row(s), rejected '.$rejected_rows.', discarded / deleted '.$deleted.' row(s) in marksheet.';

if(isset($_SESSION['inserted_rows'])){
    unset($_SESSION['inserted_rows']);
    unset($_SESSION['rejected_rows']);
}
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Marksheet uploaded but with error: '.$e->getMessage();

}
echo json_encode($data_array);
?>