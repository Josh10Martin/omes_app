<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT 
MAX(checker) AS checker,
MAX(sys_admin) AS sys_admin,
MAX(transcriber) AS transcriber,
MAX(lunch) AS lunch,
MAX(transport) AS transport
FROM (
SELECT 
    checker, sys_admin, transcriber, null AS lunch, null AS transport 
FROM marking_rates
UNION ALL
SELECT 
    null AS checker, null AS sys_admin, null AS transcriber, lunch, transport 
FROM lun_trans
) AS combined
');
$sql->execute();
$i =0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['checker_rate'] = $row['checker'] ?? '';
        $data_array[$i]['sad_rate'] = $row['sys_admin'] ?? '';
        $data_array[$i]['lunch_rate'] = $row['lunch'] ?? '';
        $data_array[$i]['transport_rate'] = $row['transport'] ?? '';
        $data_array[$i]['transcriber_rate'] = $row['transcriber'] ?? '';
        $i++;
}

echo json_encode($data_array)
?>