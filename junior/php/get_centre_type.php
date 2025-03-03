<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT type AS centre_type, CASE WHEN type ="E" THEN "GRADE 9 EXTERNAL" WHEN type ="I" THEN "GRADE 9 INTERNAL" END AS centre_type_name
                        FROM session');
$sql->execute();
$i = 0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['centre_type'] = $row['centre_type'];
        $data_array[$i]['centre_type_name'] = $row['centre_type_name'];
        $i++;
}
echo json_encode($data_array);
?>