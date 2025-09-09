<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();

if(isset($_POST['id']) && isset($_POST['marking_centre'])){
        $id = $_POST['id'];
        $marking_centre = $_POST['marking_centre'];

        $sql = $db_12_gce->prepare('UPdate marks SET status ="L", belt_no = 0, id_group ="none", entered_by = "none", date_entered = "none", marking_centre =:marking_centre_code, disable = 0
                                        WHERE id =:id');
        $sql->execute(array(
                ':marking_centre_code'=>$marking_centre,
                ':id'=>$id,
        ));
        if($sql ->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'Successfully transferred candidate';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was a problem transferring candidate. Check the current marking centre and try again';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters set';
}

echo json_encode($data_array);

?>