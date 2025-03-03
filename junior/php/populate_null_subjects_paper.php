<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
try{
$sql = $db_9->prepare('REPLACE INTO marking_centre(province,subject,paper,centre_code) SELECT province,subject_code,paper_no,marking_centre FROM marks GROUP BY province,subject_code,paper_no,marking_centre');
                
$sql->execute();
$data_array['status'] = '200';
$data_array['response_msg'] = 'Marksheet upload successful and ready';
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not finish off marksheet: '.$e->getMessage();
}
echo json_encode($data_array);
?>