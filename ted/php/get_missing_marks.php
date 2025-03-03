<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['subject']) && isset($_POST['start_centre']) && isset($_POST['end_centre'])){
        $subject_code = $_POST['subject'];
        $start_centre = $_POST['start_centre'];
        $end_centre = $_POST['end_centre'];
if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
        $sql = $db_ted->prepare('SELECT m.exam_no AS exam_no, m.first_name AS first_name,m.last_name AS last_name,m.centre_code AS centre_code,
        m.status AS status, su.subject_code AS subject_code,su.subject_name AS subject_name
        FROM marks m INNER JOIN subjects su ON (m.subject_code = su.subject_code)
        WHERE m.marking_centre =:marking_centre_code
        AND m.subject_code =:subject_code
        AND ((m.centre_code BETWEEN :start_centre AND :end_centre) OR (m.centre_code NOT BETWEEN :start_centre AND :end_centre))
        AND m.status = "L"
        ');
$sql->execute(array(
':subject_code'=>$subject_code,
':start_centre'=>$start_centre,
':end_centre'=>$end_centre,
':marking_centre_code'=>$_SESSION['marking_centre_code']

));
if($sql->rowCount() > 0){
    $i =0;
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['exam_no'] = $row['exam_no'] ?? '';
        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
        $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
        $data_array[$i]['status'] = $row['status'] ?? '';
        $i++;
    }
}
}else{
    $sql = $db_ted->prepare('SELECT m.exam_no AS exam_no, m.first_name AS first_name,m.last_name AS last_name,m.centre_code AS centre_code,
        m.status AS status, su.subject_code AS subject_code,su.subject_name AS subject_name
        FROM marks m INNER JOIN subjects su ON (m.subject_code = su.subject_code)
        WHERE m.subject_code =:subject_code
        AND ((m.centre_code BETWEEN :start_centre AND :end_centre) OR (m.centre_code NOT BETWEEN :start_centre AND :end_centre))
        AND m.status = "L"
        ');
$sql->execute(array(
':subject_code'=>$subject_code,
':start_centre'=>$start_centre,
':end_centre'=>$end_centre

));
if($sql->rowCount() > 0){
    $i =0;
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['exam_no'] = $row['exam_no'] ?? '';
        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
        $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
        $data_array[$i]['status'] = $row['status'] ?? '';
        $i++;
    }
}
}
}
echo json_encode($data_array);
?>