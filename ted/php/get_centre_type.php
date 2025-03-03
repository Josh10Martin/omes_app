<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_ted->prepare('SELECT name,level AS centre_type_name
                        FROM session');
$sql->execute();
$i = 0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['centre_type'] = $row['level'];
        $data_array[$i]['centre_type_name'] = $row['name'];
        $i++;
}
echo json_encode($data_array);
?>