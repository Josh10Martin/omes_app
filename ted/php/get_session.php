<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_ted->prepare('SELECT id,name,level FROM session WHERE year =:session');
$sql->execute(array(
    ':session'=>$_SESSION['session_year']
));
if($sql->rowCount() > 0){
    $row = $sql->fetch(PDO:: FETCH_ASSOC);
    $data_array['status'] = '200';
    $data_array['code'] = $row['id'] ?? '';
    $data_array['description'] = $row['name'] ?? '';
}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>