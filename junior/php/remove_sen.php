<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['marking_centre_code'])){
        $marking_centre_code = $_POST['marking_centre_code'];

        $sql = $db_9->prepare('DELETE FROM marks_prep WHERE sen = "1" AND marking_centre =:marking_centre_code AND province =:province_code');
        $sql->execute(array(
                ':marking_centre_code'=>$marking_centre_code,
                ':province_code'=>$_SESSION['province_code']
        ));
        if($sql->rowCount() == 0){
                $data_array['status'] = '400';
                $data_array['response_msg'] == 'Could not delete sen from marking_centre';
        }else{
                $data_array['status'] = '200';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Marking centre parameter not set for delete';
}
echo json_encode($data_array);
?>