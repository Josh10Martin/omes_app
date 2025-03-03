<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['username'])){

$username = $_POST['username'];
$sql0 = $db_9->prepare('SELECT activation_status FROM users WHERE username = :username');
$sql0->execute([':username' => $username]);
$row = $sql0->fetch(PDO::FETCH_ASSOC);
$activation_status = $row['activation_status'] ?? '';

$sql=$db_9->prepare('UPDATE users SET activation_status = CASE WHEN activation_status = 0 THEN 1 ELSE 0 END WHERE  username =:username');
$sql->execute(array(
        ':username'=>$username
));
if($sql->rowCount() == 0){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem changing user status. Please try again';
}else{
        $data_array['status'] = '200';
        $data_array['before_activation_status'] = $activation_status;
        $data_array['response_msg'] =  'Successfully updated user activation status';
       
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter not set for ADMIN. Please try again';
}
echo json_encode($data_array);
?>