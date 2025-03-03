<?php
header('COntent-Type: application/json;charset=utf-8');
include '../config.php';
$data_array = array();

if(isset($_POST['email'])){
        $email = $_POST['email'];
        if(empty($email)){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Email Address should not be empty';
        }else if (!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Enter an email address';
        }else{
                $sql = $db_9->prepare('SELECT username,email, first_name, last_name, note FROM users WHERE email =:email');
                $sql->execute(array(
                        ':email'=>$email
                ));
                

                if($sql->rowCount() > 0){
                        
                        $row = $sql->fetch(PDO:: FETCH_ASSOC);
                        $note = $row['note'] ?? '';
                        if(!is_null($note) || $note != ''){
                                $note = md5($email);
                                $sql2 = $db_9->prepare('UPDATE users SET note =:note WHERE email =:email');
                                $sql2->execute(array(
                                        ':email'=>$email,
                                        ':note'=>$note
                                ));
                                if($sql2->rowCount() > 0){
                                        $data_array['status'] = '200';
                                        $data_array['email'] = $row['email'] ?? '';
                                        $data_array['first_name'] = $row['first_name'] ?? '';
                                        $data_array['last_name'] = $row['last_name'] ?? '';
                                        $data_array['username'] = $row['username'] ?? '';

                        
                                }else{
                                        $data_array['status'] = '400';
                                        $data_array['response_msg'] = 'Could not process password reset request. Refresh and try again';
                                }
                        }else{
                                $data_array['status'] = '400';
                                $data_array['response_msg'] = 'You had already made a password reset request. Click the button in your email inbox';
                        }


                }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Email Address does not exist. Try again';
                }
               
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Email Address not set';
}
echo json_encode($data_array);
?>