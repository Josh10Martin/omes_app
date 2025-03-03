<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$admin = 'ADMIN';
$deo = 'DEO';
if(isset($_POST['username'])){
       $username = $_POST['username'];
       if($_SESSION['user_type'] == 'SESO'){
       $sql = $db_ted->prepare('DELETE FROM users WHERE username =:username AND user_type =:user_type');
       $sql->execute(array(
        ':username'=>$username,
        ':user_type'=>$admin
       ));
       if($sql->rowCount() > 0){
        $data_array['status'] = '200';
       }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem deleting admin. Please try again';
       }
}else{
        $sql = $db_ted->prepare('DELETE FROM users WHERE username =:username AND user_type =:user_type');
       $sql->execute(array(
        ':username'=>$username,
        ':user_type'=>$deo
       ));
       if($sql->rowCount() > 0){
        $data_array['status'] = '200';
       }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem deleting admin. Please try again';
       }
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter not set for ADMIN to delete. Please try again';
}
echo json_encode($data_array);
?>