<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['exam_no']) && isset($_POST['subject_name']) && isset($_POST['paper_no']) && isset($_POST['mark']) && isset($_POST['belt_no']) && isset($_POST['sen'])){
    $exam_no = $_POST['exam_no'];
    $subject_name = $_POST['subject_name'];
    $paper_no = $_POST['paper_no'];
    $mark = $_POST['mark'];
    $belt_no = $_POST['belt_no'];
    $sen = $_POST['sen'];

    $sql = $db_12_gce->prepare('UPDATE marks SET mark =:mark,belt_no =:belt_no,sen =:sen WHERE exam_no =:exam_no AND subject_code = (SELECT subject_code FROM subjects WHERE subject_name =:subject_name) AND paper_no =:paper_no AND improvised_mark = 1 AND disable = 0');
    $sql->execute(array(
        ':exam_no'=>$exam_no,
        ':subject_name'=>$subject_name,
        ':paper_no'=>$paper_no,
        ':mark'=>$mark,
        ':sen'=>$sen,
        ':belt_no'=>$belt_no
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['mark'] = $mark;
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not update mark. There was a problem';
    }
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Not all parameters set';
}
echo json_encode($data_array);

?>