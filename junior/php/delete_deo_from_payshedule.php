<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if (isset($_POST['username'])){

        $username = $_POST['username'];
        $sql = $db_9->prepare('DELETE FROM data_entry_claims WHERE username =:username');
        $sql->execute(array(
            ':username'=>$username
        ));
        if($sql->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Deleted '.$username;
        }else{
            $data_array['status'] = '400';
        }

    

}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'username is not set';
}
echo json_encode($data_array);
?>