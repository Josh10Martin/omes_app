<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();
$data_array['max_number'] = max_number($db_9);
echo json_encode($data_array);
?>