<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
// include '../../functions.php';
$data_array = array();
if(isset($_POST['username'])){

$username = $_POST['username'];
// activation_value($db_9,$username);
// $activation_value = activation_value($db_9,$username) == '0' ? '1' : '0';
// $status = activation_value($db_9,$username) == '0' ? 'Activating' : 'Deactivating';
try{

$sql=$db_9->prepare('UPDATE users SET activation_status = CASE WHEN activation_status = 0 THEN 1 ELSE 0 END WHERE username =:username');
$sql->execute(array(
        ':username'=>$username
));
        $data_array['status'] = '200';
        // $data_array['activation_value'] =  $activation_value;

}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem: '.$e->getMessage();
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter not set. Please try again';
}
echo json_encode($data_array);
?>