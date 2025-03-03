<?php
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();
$sql = $db_ted->prepare('SELECT p_code AS province_code, p_name AS province FROM province ORDER BY p_name ASC');
$sql->execute();
$row = $sql->fetch(PDO:: FETCH_ASSOC);
$i=0;
while($row = $sql->fetch(PDO:: FETCH_ASSOC)){
        $data_array[$i]['province_code'] = $row['province_code'];
        $data_array[$i]['province'] = $row['province'];
        $i++;
}
echo json_encode($data_array);
?>