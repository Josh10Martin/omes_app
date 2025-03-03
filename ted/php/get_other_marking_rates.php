<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();

$sql = $db_ted->prepare('SELECT DISTINCT checker, sys_admin, null AS centre_chairperson, null AS deputy_c_person FROM marking_rates
                        UNION ALL
                        SELECT null AS checker, null AS sys_admin, centre_chairperson,deputy_c_person FROM centre_chairperson_rate');
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

$i =0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['checker_rate'] = $row['checker'] ?? '';
        $data_array[$i]['sad_rate'] = $row['sys_admin'] ?? '';
        $data_array[$i]['cch_rate'] = $row['centre_chairperson'] ?? '';
        $data_array[$i]['dcch_rate'] = $row['deputy_c_person'] ?? '';
        $i++;
}

echo json_encode($data_array)
?>