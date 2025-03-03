<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_POST['id']) && isset($_POST['belt_no'])){
        $id = $_POST['id'];
        $belt_no = $_POST['belt_no'];
         if($belt_no == 0){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'You cannot give a zero (0) belt';
         }else{
        $sql = $db_ted->prepare('UPDATE examiner SET belt_no =:belt_no WHERE id =:id');
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