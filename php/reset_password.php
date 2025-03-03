<?php
header('COntent-Type: application/json;charset=utf-8');
include '../config.php';
$data_array = array();

if(isset($_POST['password']) && isset($_POST['password1']) && isset($_POST['username']) && isset($_POST['email'])){
        $password = $_POST['password'];
        $password1 = $_POST['password1'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $option = array('cost'=> 12);
        $hashed_password = password_hash($password,PASSWORD_BCRYPT,$option);

        $sql = $db_9->prepare('SELECT note FROM users WHERE (note <> "" OR note IS NOT NULL) AND username =:username AND email =:email');
        $sql->execute(array(
                ':username'=>$username,
                ':email'=>$email
        ));
        if($sql->rowCount() > 0){
                if(!empty($password) || !empty($password1)){
                        if($password == $password1){
                                if(preg_match($password_pattern,$password)){
                                        
                                        $sql2 = $db_9->prepare('UPDATE users SET note = "", password =:new_password WHERE username =:username AND email =:email');
                                        $sql2->execute(array(
                                                ':new_password'=>$hashed_password,
                                                ':username'=>$username,
                                                ':email'=>$email,
                                        ));
                                        if($sql2->rowCount() > 0){
                                                $data_array['status'] = '200';
                                                $data_array['response_msg'] = 'Password successfully reset.';
                                        }else{
                                                $data_array['status'] = '400';
                                                $data_array['response_msg'] = 'Could not reset password. There was a problem';
                                        }
                                }else{
                                        $data_array['status'] = '400';
                                        $data_array['response_msg'] = 'Password does not meet the set requirements';
                                }
                        }else{
                                $data_array['status'] = '400';
                                $data_array['response_msg'] = 'Passwords do not match';
                        }
                }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'All fields should be filled';
                }

        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'You need to make a ppassword reset request';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters are set';
}
echo json_encode($data_array);

?>