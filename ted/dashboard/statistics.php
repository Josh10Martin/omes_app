<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
    $sql = $db_ted->prepare('SELECT SUM(status ="-") AS no_of_entered_marks, SUM(status ="L") AS no_of_missing_marks, SUM(improvised_mark = "1") AS no_of_improvised_marks,COUNT(exam_no) AS count_rows
                            FROM marks');
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $data_array['no_of_entered_marks'] = $row['no_of_entered_marks'] ?? '0';
    $data_array['no_of_missing_marks'] = $row['no_of_missing_marks'] ?? '0';
    $data_array['no_of_improvised_marks'] = $row['no_of_improvised_marks'] ?? '0';
    $data_array['count_rows'] = $row['count_rows'] ?? '0';

}else{
    $sql = $db_ted->prepare('SELECT SUM(status ="-") AS no_of_entered_marks, SUM(status ="L") AS no_of_missing_marks, SUM(improvised_mark = "1") AS no_of_improvised_marks,COUNT(exam_no) AS count_rows
                            FROM marks WHERE marking_centre =:marking_centre_code');
    $sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
    ));
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $data_array['no_of_entered_marks'] = $row['no_of_entered_marks'] ?? '0';
    $data_array['no_of_missing_marks'] = $row['no_of_missing_marks'] ?? '0';
    $data_array['no_of_improvised_marks'] = $row['no_of_improvised_marks'] ?? '0';
    $data_array['count_rows'] = $row['count_rows'] ?? '0';
}
echo json_encode($data_array);

?>