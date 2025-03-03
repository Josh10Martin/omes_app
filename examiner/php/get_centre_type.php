<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_12_gce->prepare('SELECT type AS centre_type, CASE WHEN type ="E" THEN "G.C.E" WHEN type ="I" THEN "GRADE 12" END AS centre_type_name
                        FROM session');
$sql->execute();
// $row = $sql->fetch(PDO::FETCH_ASSOC);
// $data_array[0]['centre_type'] = $row['centre_type'];
// $data_array[0]['centre_type_name'] = $row['centre_type_name'];
$i = 0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['centre_type'] = $row['centre_type'];
        $data_array[$i]['centre_type_name'] = $row['centre_type_name'];
        $i++;
}
echo json_encode($data_array);
?>