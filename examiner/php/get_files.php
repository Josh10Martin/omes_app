<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_12_gce->prepare('SELECT id, description,url FROM documents');
$sql->execute();
$i = 0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $data_array[$i]['if'] = $row['id'] ?? '';
    $data_array[$i]['file_description'] = $row['description'] ?? '';
    $data_array[$i]['url'] = $row['url'] ?? '';
    $i++;
}
echo json_encode($data_array);
?>