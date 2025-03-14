<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['email'])){
        $email = strtolower($_POST['email']);
        $username = strtolower($_POST['username']);
        $first_name = strtoupper($_POST['first_name']);
        $last_name = strtoupper($_POST['last_name']);
        $user_type = strtoupper($_POST['user_type']);
        $province_code = explode(':',$_POST['province'])[0];
        $province_name = explode(':',$_POST['province'])[1];
        $rand_password = substr(md5(rand(10000,99999)),1,8);
        $option = array('cost'=>12);
        $password_hash = password_hash($rand_password,PASSWORD_BCRYPT,$option);
try{
        $sql = $db_ted->prepare('INSERT IGNORE INTO users (username,email,password,first_name,last_name,province,user_type)
                                VALUES(:username,:email,:password,:first_name,:last_name,:province,:user_type)');
        $sql->execute(array(
                ':username'=>$username,
                ':email'=>$email,
                ':password'=>$password_hash,
                ':first_name'=>$first_name,
                ':last_name'=>$last_name,
                ':user_type'=>$user_type,
                ':province'=>$province_code
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['email'] = $email;
                $data_array['username'] = $username;
                $data_array['first_name'] = $first_name;
                $data_array['last_name'] = $last_name;
                $data_array['password'] = $rand_password;
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not add SESO user. Please try again';
        
        }
}catch(PDOEXCEPTION $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Error: '.$e->getMessage();
}

}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter not set. Refresh and try again';

}

echo json_encode($data_array);
?>