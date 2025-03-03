<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$user_type = 'SESO';
if(isset($_POST['username'])){
       $username = $_POST['username'];
       $sql = $db_ted->prepare('DELETE FROM users WHERE username =:username AND user_type =:user_type');
       $sql->execute(array(
        ':username'=>$username,
        ':user_type'=>$user_type
       ));
       if($sql->rowCount() > 0){
        $data_array['status'] = '200';
       }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem deleting seso. Please try again';
       }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter not set for SESO to delete. Please try again';
}
echo json_encode($data_array);
?>