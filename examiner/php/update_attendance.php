<?php
session_start();
header('Content-Type:application/json; charset=utf-8;');
include '../../config.php';
$data_array = array();

    $_POST = json_decode(file_get_contents('php://input'),JSON_OBJECT_AS_ARRAY);
    if(isset($_POST['examiner_number'])){
    $examiner_number = $_POST['examiner_number'];
    $attendance = $_POST['attendance'];
    try{
    $sql = $db_12_gce->prepare('UPDATE examiner SET attendance =:attendance WHERE examiner_number =:examiner_number');
    $sql->execute(array(
        ':examiner_number'=>$examiner_number,
        ':attendance'=>$attendance
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
         $data_array['response_msg'] = 'Attendance updated for '.$examiner_number;
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not update '.$examiner_number;
    }
    
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There wan an error updating attendance: '.$e->getMessage();
}
}

echo json_encode($data_array);
?>