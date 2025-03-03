<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['username'])){
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $province = $_POST['province'];
        $sql = $db_ted->prepare('UPDATE users SET first_name =:first_name,last_name =:last_name, province =:province WHERE username =:username AND user_type = "SESO"');
        $sql->execute(array(
                ':username'=>$username,
                ':first_name'=>$first_name,
                ':last_name'=>$last_name,
                ':province'=>$province
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'SESO successfully updated';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was a problem updating this particular user';
        }

}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'username param not set';
}
echo json_encode($data_array);
?>