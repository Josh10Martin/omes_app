<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['exam_no']) && isset($_POST['subject_name']) && isset($_POST['paper_no']) && isset($_POST['mark']) && isset($_POST['question'])){
    $exam_no = $_POST['exam_no'];
    $subject_name = $_POST['subject_name'];
    $paper_no = $_POST['paper_no'];
    $mark = $_POST['mark'];
    $question = $_POST['question'];

    $sql = $db_12_gce->prepare('UPDATE marks_questions SET mark =:mark WHERE exam_no =:exam_no AND subject_code = (SELECT subject_code FROM subjects WHERE subject_name =:subject_name) AND paper_no =:paper_no AND question =:question AND improvised_mark = 1');
    $sql->execute(array(
        ':exam_no'=>$exam_no,
        ':subject_name'=>$subject_name,
        ':paper_no'=>$paper_no,
        ':question'=>$question,
        ':mark'=>$mark
    ));
    $sql2 = $db_12_gce->prepare('UPDATE marks m
                        INNER JOIN (SELECT  exam_no,subject_code,paper_no, SUM(mark) AS mark,status,sen,improvised_mark,entered_by,MAX(date_entered) AS date_entered,marking_centre FROM marks_questions 
                        WHERE exam_no =:exam_no AND subject_code = (SELECT subject_code FROM subjects WHERE subject_name =:subject_name AND improvised_mark = 1 AND paper_no =:paper_no)
                        GROUP BY exam_no,subject_code,paper_no,status,sen,improvised_mark,entered_by,marking_centre) mq
                         ON m.exam_no = mq.exam_no
                         SET m.mark = mq.mark
                         WHERE m.exam_no = mq.exam_no AND mq.exam_no =:exam_no AND m.subject_code = mq.subject_code AND mq.subject_code = (SELECT subject_code FROM subjects WHERE subject_name =:subject_name) AND m.paper_no = mq.paper_no AND mq.paper_no =:paper_no AND m.sen = mq.sen AND m.improvised_mark = mq.improvised_mark AND mq.improvised_mark = 1 AND m.marking_centre = mq.marking_centre
                        ');
        $sql2->execute(array(
            ':exam_no'=>$exam_no,
            ':subject_name'=>$subject_name,
            ':paper_no'=>$paper_no,
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