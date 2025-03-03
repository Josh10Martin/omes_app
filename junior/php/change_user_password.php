<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../config.php';
$data_array = array();

if(isset($_SESSION['username']) && isset($_POST['password']) && isset($_POST['password1']) && isset($_POST['password2'])){
        $username = $_SESSION['username'];
        $password = $_POST['password'];
        $password1 = $_POST['password1'];
        $password2 = $_POST['password2'];
        $password_pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        $pattern = preg_match($password_pattern,$password1);
        $option = array('cost'=>12);
        // $hashed_password = password_verify($password, PASSWORD_BCRYPT,$option);

        if(empty($password) || empty($password1) || empty($password2)){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'All fields should not be empty';
        }else{
                
                $sql = $db_9->prepare('SELECT password FROM users WHERE username =:username');
                $sql->execute(array(
                        ':username'=>$username
                ));
                $row = $sql->fetch(PDO:: FETCH_ASSOC);
                $db_password = $row['password'];
                if(password_verify($password,$db_password)){
                        if($pattern){
                                if($password1 == $password2){
                                        $hash_password = password_hash($password1, PASSWORD_BCRYPT,$option);
                                        $sql2 = $db_9->prepare('UPDATE users SET password = :new_password WHERE username =:username');
                                       
                                        $sql2->execute(array(
                                                ':new_password'=>$hash_password,
                                                ':username'=>$username
                                        ));
                                        if($sql2->rowCount() > 0){
                                                $data_array['status'] = '200';
                                                $data_array['response_msg'] = 'Password succesfully changed.';
                                                
                                               
                                        }else{
                                                $data_array['status'] = '400';
                                                $data_array['response_msg'] = 'Could not update password. Try logging in again';
                                        }
                                }else{
                                        $data_array['status'] = '400';
                                        $data_array['response_msg'] = 'New passwords do not match. Try again';
                                }
        
                               
                        }else{
                                $data_array['status'] = '400';
                                $data_array['response_msg'] = 'The new password does not follow the set requirement';
                        }

                        }else{
                                $data_array['status'] = '400';
                                $data_array['response_msg'] = 'The current password is incorrect. Try again';
                        }
                       

                

                
               
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters are set';
}
echo json_encode($data_array);
?>