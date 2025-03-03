<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_12_gce->prepare('SELECT su.subject_name AS subject_name, pa.id AS id, pa.paper_no AS paper_no,pa.max_questions AS max_questions
                            FROM subjects su INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                            ');
$sql->execute();
$i =0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
    $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
    $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
    $data_array[$i]['id'] = $row['id'] ?? '';
    $data_array[$i]['max_questions'] = $row['max_questions'] ?? '';
    $i++;
}
echo json_encode($data_array);
?>