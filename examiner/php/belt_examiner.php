<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_POST['id']) && isset($_POST['belt_no'])){
        $id = $_POST['id'];
        $belt_no = $_POST['belt_no'];
        $roles = array('CHECKER','EXAMINER','TEAM LEADER');
        if(in_array(role_g12($db_12_gce,$id),$roles) && $belt_no == 0){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Checkers, Team Leaders and Examiner0 should not be belted at 0';
        }else if(!in_array(role_g12($db_12_gce,$id),$roles) && $belt_no != 0){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Chief examiners and Deputy chief examiners should be belted at 0';
        }else{
        $sql = $db_12_gce->prepare('UPDATE examiner SET belt_no =:belt_no WHERE id =:id');
        $sql->execute(array(
                ':id'=>$id,
                ':belt_no'=>$belt_no
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['id'] = $id;
                $data_array['belt_no'] = $belt_no;
        }
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all belting parameters set';
}
echo json_encode($data_array);
?>