<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql =$db_ted->prepare('SELECT id,name FROM attendance');
$sql->execute();
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['id']= $row['id'];
        $data_array[$i]['name'] = $row['name'];
        $i++;
}

echo json_encode($data_array);
?>