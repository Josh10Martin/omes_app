<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT id,name,CASE WHEN type ="E" THEN "GRADE 9 EXTERNAL" WHEN type="I" THEN "GRADE 9 INTERNAL" ELSE "[UNKBOWN]" END AS type FROM session');
$sql->execute();
if($sql->rowCount() > 0){
    $row = $sql->fetch(PDO:: FETCH_ASSOC);
    $data_array['status'] = '200';
    $data_array['code'] = $row['id'] ?? '';
    $data_array['description'] = $row['name'] ?? '';
    $data_array['type'] = $row['type'] ?? '';
}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>