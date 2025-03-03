<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql =$db_12_gce->prepare('SELECT DISTINCT attendance AS id, CASE WHEN attendance = 1 THEN "PRESENT" ELSE "ABSENT" END AS name FROM examiner');
$sql->execute();
// $row = $sql->fetch(PDO::FETCH_ASSOC);
// $data_array[0]['id'] = $row['id'];
// $data_array[0]['name'] = $row['name'];
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['id']= $row['id'] ?? '';
        $data_array[$i]['name'] = $row['name'] ?? '';
        $i++;
}

echo json_encode($data_array);
?>