<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
if(isset($_POST['email'])){
        if($_SESSION['user_type'] == 'SESO'){
        $email = trim(strtolower($_POST['email']));
        $username = trim(strtolower($_POST['username']));
        $first_name = strtoupper($_POST['first_name']);
        $last_name = strtoupper($_POST['last_name']);
        $user_type = strtoupper($_POST['user_type']);
        $marking_centre_code = explode(':', $_POST['marking_centre'] ?? '')[0];
        $marking_centre_name = explode(':', $_POST['marking_centre'] ?? '')[1];
        $rand_password = substr(md5(rand(10000,99999)),1,8);
        $option = array('cost'=>12);
        $password_hash = password_hash($rand_password,PASSWORD_BCRYPT,$option);
        if(username_exists($db_9,$username) != 'false'){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'username '.username_exists($db_9,$username).' is in use. Please choose another username';
        }else{
                try{
                        $sql = $db_9->prepare('INSERT IGNORE INTO users (username,email,password,first_name,last_name,province,user_type,marking_centre)
                                                VALUES(:username,:email,:password,:first_name,:last_name,:province,:user_type,:marking_centre)');
                        $sql->execute(array(
                                ':username'=>$username,
                                ':email'=>$email,
                                ':password'=>$password_hash,
                                ':first_name'=>$first_name,
                                ':last_name'=>$last_name,
                                ':user_type'=>$user_type,
                                ':marking_centre'=>$marking_centre_code,
                                ':province'=>$_SESSION['province_code']
                        ));
                        if($sql->rowCount() > 0){
                                $data_array['status'] = '200';
                                $data_array['email'] = $email;
                                $data_array['username'] = $username;
                                $data_array['first_name'] = $first_name;
                                $data_array['last_name'] = $last_name;
                                $data_array['marking_centre_name'] = $marking_centre_name;
                                $data_array['password'] = $rand_password;
                                $data_array['user_type'] = $user_type == 'ADMIN' ? 'SYSTEMS ADMINISTRATOR' : 'DATA ENTRY OPERATOR';
                        }else{
                                $data_array['status'] = '400';
                                $data_array['response_msg'] = 'Could not add ADMIN user. Please try again';
                        
                        }
                }catch(PDOEXCEPTION $e){
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Error: '.$e->getMessage();
                }
        }
}else{
        $email = trim(strtolower($_POST['email']));
        $activation_status = $_POST['activation_status'];
        $username = trim(strtolower($_POST['username']));
        $first_name = strtoupper($_POST['first_name']);
        $last_name = strtoupper($_POST['last_name']);
        $user_type = strtoupper($_POST['user_type']);
        $marking_centre_code = explode(':', $_POST['marking_centre'] ?? '')[0];
        $marking_centre_name = explode(':', $_POST['marking_centre'] ?? '')[1];
        $rand_password = substr(md5(rand(10000,99999)),1,8);
        $option = array('cost'=>12);
        $password_hash = password_hash($rand_password,PASSWORD_BCRYPT,$option);
        if(username_exists($db_9,$username) != 'false'){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'username '.username_exists($db_9,$username).' is in use. Please choose another username';
        }else{
                try{
                        $sql = $db_9->prepare('INSERT IGNORE INTO users (username,email,password,first_name,last_name,province,user_type,marking_centre)
                                                VALUES(:username,:email,:password,:first_name,:last_name,:province,:user_type,:marking_centre)');
                        $sql->execute(array(
                                ':username'=>$username,
                                ':email'=>$email,
                                ':password'=>$password_hash,
                                ':first_name'=>$first_name,
                                ':last_name'=>$last_name,
                                ':user_type'=>$user_type,
                                ':marking_centre'=>$marking_centre_code,
                                ':province'=>$_SESSION['province_code']
                        ));
                        if($sql->rowCount() > 0){
                                $data_array['status'] = '200';
                                $data_array['email'] = $email;
                                $data_array['username'] = $username;
                                $data_array['first_name'] = $first_name;
                                $data_array['last_name'] = $last_name;
                                $data_array['marking_centre_name'] = $marking_centre_name;
                                $data_array['activation_status'] = $activation_status;
                                $data_array['password'] = $rand_password;
                                $data_array['user_type'] = $user_type == 'ADMIN' ? 'SYSTEMS ADMINISTRATOR' : 'DATA ENTRY OPERATOR';
                        }else{
                                $data_array['status'] = '400';
                                $data_array['response_msg'] = 'Could not add  user. Please try again';
                        
                        }
                }catch(PDOEXCEPTION $e){
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Error: '.$e->getMessage();
                }
        }
}
//end
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter not set. Refresh and try again';

}

echo json_encode($data_array);
?>