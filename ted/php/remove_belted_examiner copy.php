<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['id'])){
        $id = $_POST['id'];
        $sql = $db_ted->prepare('UPDATE examiner SET belt_no = NULL WHERE id =:id');
        $sql->execute(array(
                ':id'=>$id
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['id'] = $id;
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was a problem removing examiner. Try again';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter id not set for removing examiner';
}
echo json_encode($data_array);
?>