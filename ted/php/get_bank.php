<?php
header('Content-Type:application/json; charset=utf-8;');
include '../../config.php';
$data_array = array();
$sql= $db_9->prepare('SELECT id,name FROM bank');
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);
$data_array[0]['id'] = $row['id'];
$data_array[0]['name'] = $row['name'];
$i=1;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['id'] = $row['id'];
        $data_array[$i]['name'] = $row['name'];
        $i++;
}
echo json_encode($data_array);
?>