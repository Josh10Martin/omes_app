<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
// include '../../functions.php';
$data_array = array();

if(isset($_POST['roles']) && isset($_POST['ac_status'])){
      $role = $_POST['roles'];
      $status = $_POST['ac_status'];

      if($role == 'all'){
            $sql = $db_9->prepare('UPDATE users SET activation_status =:status WHERE user_type IN ("ADMIN","DEO")');
            $sql->execute(array(
                  ':status'=>$status
            ));
            if($sql->rowCount() > 0){
                  $data_array['status'] = '200';
                  $data_array['response_msg'] = 'Action successful on System Administrators and Data Entry Officers';
            }else{
                  $data_array['status'] = '400';
                  $data_array['response_msg'] = 'Could not complete the action. Please try again';
            }
      }else{
            $sql = $db_9->prepare('UPDATE users SET activation_status =:status WHERE user_type =:role');
            $sql->execute(array(
                  ':status'=>$status,
                  ':role'=>$role
            ));
            if($sql->rowCount() > 0){
                  $data_array['status'] = '200';
                  $data_array['response_msg'] = 'Action successful';
            }else{
                  $data_array['status'] = '400';
                  $data_array['response_msg'] = 'Could not complete the action. This may be due to the requested action alredy actioned';
            }
      }

      
}else{
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Not all parameters are set';
}
echo json_encode($data_array);
?>