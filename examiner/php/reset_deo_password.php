<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['id'])){
        $id = $_POST['id'];
        $rand_password = substr(md5(rand(10000,99999)),1,5);
        $option = array('cost'=>12);
        $hash_password = password_hash($rand_password,PASSWORD_BCRYPT,$option);
        $sql = $db_0->prepare('UPDATE users SET password =:password WHERE id =:id');
        $sql->execute(array(
                ':password'=>$hash_password,
                ':id'=>$id
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'New password: '.$rand_password;
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was a problem in trying to reset password. Try again';
        }

}else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'The id parameter not set';
}
echo json_encode($data_array);
?>