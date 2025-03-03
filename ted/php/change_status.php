<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
if(isset($_POST['username'])){

$username = $_POST['username'];
activation_value($db_ted,$username);
$activation_value = activation_value($db_ted,$username) == '0' ? '1' : '0';
$status = activation_value($db_ted,$username) == '0' ? 'Activating' : 'Deactivating';
$sql=$db_ted->prepare('UPDATE users SET activation_status = :activation_value WHERE activation_status <> :activation_value AND username =:username');
$sql->execute(array(
        ':activation_value'=>$activation_value,
        ':username'=>$username
));
if($sql->rowCount() == 0){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem '.$status.' seso. Please try again';
}else{
        $data_array['status'] = '200';
        $data_array['activation_value'] =  $activation_value;
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameter not set for SESO. Please try again';
}
echo json_encode($data_array);
?>