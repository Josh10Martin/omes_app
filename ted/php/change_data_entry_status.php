<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
$data_array = array();

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $sql = $db_ted->prepare('UPDATE examiner SET activation_status = CASE WHEN activation_status = 1 THEN 0 ELSE 1 END WHERE id =:id AND role = "DATA ENTRY OFFICER"');
    $sql->execute(array(
        ':id'=>$id
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Successfully updated activation status';
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error';
    }
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Username not set';
}
echo json_encode($data_array);
?>