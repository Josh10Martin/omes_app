<?php
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();
$sql = $db_9->prepare('SELECT p_code AS province_code, p_name AS province FROM province');
$sql->execute();
$row = $sql->fetch(PDO:: FETCH_ASSOC);
$data_array[0]['province_code'] = $row['province_code'];
$data_array[0]['province'] = $row['province'];
$i=1;
while($row = $sql->fetch(PDO:: FETCH_ASSOC)){
        $data_array[$i]['province_code'] = $row['province_code'];
        $data_array[$i]['province'] = $row['province'];
        $i++;
}
echo json_encode($data_array);
?>