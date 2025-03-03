<?php
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql= $db_9->prepare('SELECT subject_code,subject_name FROM subjects');
$sql->execute();
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['subject_code'] = $row['subject_code'];
        $data_array[$i]['subject_name'] = $row['subject_name'];
        $i++;
}
echo json_encode($data_array);
?>