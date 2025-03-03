<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['id'])){
        $id = $_POST['id'];

        $sql = $db_9->prepare('DELETE FROM examiner WHERE id =:id');
        $sql->execute(array(
                ':id'=>$id
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'This user could not be deleted. Please try again';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter not set for deleting user. Please try again';
}
echo json_encode($data_array);
?>