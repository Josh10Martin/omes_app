<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['exam_no']) && isset($_POST['subject_code']) && isset($_POST['belt_no']) && isset($_POST['mark'])){
    $exam_no = $_POST['exam_no'];
    $subject_code = $_POST['subject_code'];
    $mark = $_POST['mark'];
    $belt_no = $_POST['belt_no'];

    $sql = $db_ted->prepare('UPDATE marks SET mark =:mark, belt_no =:belt_no WHERE exam_no =:exam_no AND subject_code =:subject_code AND improvised_mark = 1 AND session =:session');
    $sql->execute(array(
        ':exam_no'=>$exam_no,
        ':subject_code'=>$subject_code,
        ':belt_no'=>$belt_no,
        ':session'=>$_SESSION['session_year'],
        ':mark'=>$mark
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['mark'] = $mark;
        $data_array['belt_no'] = $belt_no;
        $data_array['exam_no'] = $exam_no;
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