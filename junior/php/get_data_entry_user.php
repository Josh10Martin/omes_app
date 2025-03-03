<?php
header("Access-Control-Allow-Origin: *"); 
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['marking_centre_code'])){

        $marking_centre_code = $_POST['marking_centre_code'];

        $sql = $db_9->prepare('SELECT username,full_name FROM data_entry_claims WHERE marking_centre_code =:marking_centre_code');
        $sql->execute(array(
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql->rowCount() > 0){
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                      $data_array[$i]['username'] = $row['username'] ?? '';
                      $data_array[$i]['full_name'] = $row['full_name'] ?? '';
                      $i++;
                }
        }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>