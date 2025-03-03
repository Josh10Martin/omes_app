<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT no_of_scripts FROM transcriber_script_no WHERE marking_centre =:marking_centre_code');
$sql->execute(array(
      ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
$row = $sql->fetch(PDO::FETCH_ASSOC);
$data_array['no_of_scripts'] = $row['no_of_scripts'] ?? '';

echo json_encode($data_array);
?>