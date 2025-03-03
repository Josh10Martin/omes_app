<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['start_centre']) && isset($_POST['end_centre'])){
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $start_centre = $_POST['start_centre'];
        $end_centre = $_POST['end_centre'];
if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
        $sql = $db_9->prepare('SELECT m.exam_no AS exam_no, m.first_name AS first_name,m.last_name AS last_name,m.centre_code AS centre_code,
        m.status AS status, su.subject_code AS subject_code,su.subject_name AS subject_name, pa.paper_no AS paper_no
        FROM marks m INNER JOIN subjects su ON (m.subject_code = su.subject_code)
        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
        WHERE m.paper_no = pa.paper_no
        AND m.marking_centre =:marking_centre_code
        AND m.province =:province_code
        AND m.subject_code =:subject_code
        AND m.paper_no =:paper_no
        AND CAST(m.centre_code AS UNSIGNED) BETWEEN :start_centre AND :end_centre
        AND m.status = "L"
        ORDER BY CAST(m.centre_code AS UNSIGNED) ASC
        ');
$sql->execute(array(
':subject_code'=>$subject_code,
':paper_no'=>$paper_no,
':start_centre'=>$start_centre,
':end_centre'=>$end_centre,
':marking_centre_code'=>$_SESSION['marking_centre_code'],
':province_code'=>$_SESSION['province_code']

));
if($sql->rowCount() > 0){
    // $row = $sql->fetch(PDO::FETCH_ASSOC);
    // $data_array[0]['exam_no'] = $row['exam_no'] ?? '';
    // $data_array[0]['last_name'] = $row['last_name'] ?? '';
    // $data_array[0]['first_name'] = $row['first_name'] ?? '';
    // $data_array[0]['centre_code'] = $row['centre_code'] ?? '';
    // $data_array[0]['status'] = $row['status'] ?? '';
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
    $sql = $db_9->prepare('SELECT m.exam_no AS exam_no, m.first_name AS first_name,m.last_name AS last_name,m.centre_code AS centre_code,
        m.status AS status, su.subject_code AS subject_code,su.subject_name AS subject_name, pa.paper_no AS paper_no
        FROM marks m INNER JOIN subjects su ON (m.subject_code = su.subject_code)
        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
        WHERE m.paper_no = pa.paper_no
        AND m.province =:province_code
        AND m.subject_code =:subject_code
        AND m.paper_no =:paper_no
        AND ((m.centre_code BETWEEN :start_centre AND :end_centre) OR (m.centre_code NOT BETWEEN :start_centre AND :end_centre))
        AND m.status = "L"
        ');
$sql->execute(array(
':subject_code'=>$subject_code,
':paper_no'=>$paper_no,
':start_centre'=>$start_centre,
':end_centre'=>$end_centre,
':province_code'=>$_SESSION['province_code']

));
if($sql->rowCount() > 0){
    // $row = $sql->fetch(PDO::FETCH_ASSOC);
    // $data_array[0]['exam_no'] = $row['exam_no'] ?? '';
    // $data_array[0]['last_name'] = $row['last_name'] ?? '';
    // $data_array[0]['first_name'] = $row['first_name'] ?? '';
    // $data_array[0]['centre_code'] = $row['centre_code'] ?? '';
    // $data_array[0]['status'] = $row['status'] ?? '';
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