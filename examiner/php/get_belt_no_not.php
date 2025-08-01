<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['current_belt']) && isset($_POST['subject_code']) && isset($_POST['paper_no'])){
    $current_belt = $_POST['current_belt'];
    $subject_code = $_POST['subject_code'];
    $paper_no = $_POST['paper_no'];

    $sql = $db_12_gce->prepare('SELECT DISTINCT belt_no from group_apportion WHERE subject =:subject_code AND paper =:paper_no
                            AND belt_no <>:belt_no AND marking_centre =:marking_centre_code');
    $sql->execute(array(
        ':belt_no'=>$current_belt,
        ':subject_code'=>$subject_code,
        ':paper_no'=>$paper_no,
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
    ));
    if($sql->rowCount() > 0){
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
            $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
            $i++;
        }
    }
}
echo json_encode($data_array);
?>