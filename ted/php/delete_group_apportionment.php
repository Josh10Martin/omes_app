<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['id'])){
        $id = $_POST['id'];
        $sql = $db_ted->prepare('DELETE FROM group_apportion WHERE id =:id');
        $sql->execute(array(
                ':id'=>$id
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] ='200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not delete apportion '.$id;
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter id not set';
}
echo json_encode($data_array);
?>