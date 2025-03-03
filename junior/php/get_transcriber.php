<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();


$sql = $db_9->prepare('SELECT id, nrc, phone_number,first_name,last_name, role
                        FROM transcriber WHERE marking_centre =:marking_centre_code');
$sql->execute(array(
      ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
      
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                $data_array[$i]['phone'] = $row['phone_number'] ?? '';
                $data_array[$i]['role'] = $row['role'] ?? '';
                $i++;
        }
}else{
        $data_array['status'] = '400';
}


echo json_encode($data_array);
?>