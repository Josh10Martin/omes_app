<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';


$sql = $db_9->prepare('SELECT subject_code, subject_name
                        FROM subjects');
$sql->execute();

if($sql->rowCount() > 0){
    $data_array = array();
    
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
           $data_array[]=$row;
    }
    echo json_encode($data_array);
}else{
    echo json_encode(array('message' => 'No Data found'));
}

//echo json_encode($response);
?>
