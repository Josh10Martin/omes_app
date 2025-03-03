<?php
header('Content-Type:application/json; charset=utf-8;');
include '../../../config.php';
$data_array = array();

$sql = $db_ted->prepare('SELECT id,name,year,level FROM session WHERE year = (SELECT MAX(year) FROM session)');
$sql->execute();
$row = $sql->fetch(PDO:: FETCH_ASSOC);

$data_array['id'] = $row['id'] ?? '';
$data_array['session_name'] = $row['name'] ?? '';
$data_array['year'] = $row['year'] ?? '';
$data_array['level'] = $row['level'] ?? '';

echo json_encode($data_array);
?>