<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
        $sql = $db_12_gce->prepare('SELECT COUNT(centre_code) AS no_of_schools FROM school');
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['response_msg'] = $row['no_of_schools'] ?? '0';

       
}

echo json_encode($data_array);
?>