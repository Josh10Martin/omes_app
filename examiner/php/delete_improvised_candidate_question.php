<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['exam_no']) && isset($_POST['subject_name']) && isset($_POST['paper_no'])){
        $exam_no = $_POST['exam_no'];
        $subject_name = $_POST['subject_name'];
        $paper_no = $_POST['paper_no'];

        $sql = $db_12_gce->prepare('DELETE FROM marks_questions WHERE exam_no =:exam_no AND subject_code = (SELECT subject_code FROM subjects WHERE subject_name =:subject_name) AND paper_no =:paper_no AND improvised_mark = 1');
        $sql->execute(array(
                ':exam_no'=>$exam_no,
                ':subject_name'=>$subject_name,
                ':paper_no'=>$paper_no
        ));
        $sql2 = $db_12_gce->prepare('DELETE FROM marks WHERE exam_no =:exam_no AND subject_code = (SELECT subject_code FROM subjects WHERE subject_name =:subject_name) AND paper_no =:paper_no AND improvised_mark = 1');
        $sql2->execute(array(
                ':exam_no'=>$exam_no,
                ':subject_name'=>$subject_name,
                ':paper_no'=>$paper_no
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not delete candidate';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters are set for deleting';
}
echo json_encode($data_array);
?>