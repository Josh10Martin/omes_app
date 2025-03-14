<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
$data_array = array();

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = $db_12_gce->prepare('UPDATE examiner SET login_status = CASE WHEN login_status = 1 THEN 0 ELSE 1 END WHERE id =:id AND role = "DATA ENTRY OFFICER"');
    $sql->execute(array(
        ':id'=>$id
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Successfully updated login / logout status';
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not update login / logout status';
    }
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Username for login / logout not set';
}
echo json_encode($data_array);
?>