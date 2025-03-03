<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['centre_code'])){
        $centre_code = $_POST['centre_code'];
        $sql = $db_9->prepare('DELETE FROM centre WHERE centre_code = :centre_code');
        $sql->execute(array(
                ':centre_code'=>$centre_code
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not delete centre. Please try again';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Centre code parameter not set';
}
echo json_encode($data_array);;
?>