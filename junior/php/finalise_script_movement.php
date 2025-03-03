<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['session_type'] == 'I'){
    $sql = $db_9->prepare('UPDATE apportionment_summary SET valid = 1 WHERE valid = 0 AND province =:province_code');
$sql->execute(array(
    ':province_code'=>$_SESSION['province_code']
));
if($sql->rowCount() > 0){
    $data_array['status'] = '200';
    $data_array['response_msg'] = 'Successfully effected script movement';
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Script movement done but could not finalise';
}
}else{
    $sql = $db_9->prepare('UPDATE marking_centre_centres SET valid = 1 WHERE valid = 0 AND province =:province_code');
    $sql->execute(array(
        ':province_code'=>$_SESSION['province_code']
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Successfully effected centre movement';
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'centre movement done but could not finalise';
    }
}
echo json_encode($data_array);
?>