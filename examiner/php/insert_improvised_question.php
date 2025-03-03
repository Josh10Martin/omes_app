<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
if(isset($_POST['exam_no'])){
    $exam_no = $_POST['exam_no'];
    $centre_code = $_POST['centre_code'];
    $candidate_type = $_POST['candidate_type'];
    $subject_code = explode(':',$_POST['subject'])[0];
    $subject_name = explode(':',$_POST['subject'])[1];
    $paper_no = $_POST['paper'];
    $marks = $_POST['mark'];
    $sum =0;
    foreach($marks as $value){
        $sum += $value;
    }
    $max_mark = $_POST['max_mark'];
    $date_time = date('d/m/Y H:m:s');
    $status = '-';
    $improvised_mark = '1';
    if(in_marksheet($db_12_gce,$exam_no,$subject_code,$paper_no) == 'true'){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The exam number '.$exam_no.' with subject '.$subject_name.' PAPER '.$paper_no.' is already in the marksheet';
    }else if($sum > $max_mark){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The sum mof the entered mark(s) for each question(s) for candidate is higher than '.$max_mark;
    }else{
        try{
        foreach($marks as $question_no => $mark){

              
        $sql = $db_12_gce->prepare('INSERT IGNORE INTO marks_questions (centre_code,exam_no,subject_code,paper_no,question,mark,status,sen,improvised_mark,entered_by,date_entered,marking_centre,disable)
                                VALUES(:centre_code,:exam_no,:subject_code,:paper_no,:question,:mark,:status,:candidate_type,:improvised_mark,:entered_by,:date_entered,:marking_centre_code, "1")');
        $sql->execute(array(
            ':centre_code'=>$centre_code,
            ':exam_no'=>$exam_no,
            ':question'=>$question_no,
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':mark'=>$mark,
            ':status'=>$status,
            ':candidate_type'=>$candidate_type,
            ':improvised_mark'=>$improvised_mark,
            ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
            ':date_entered'=>$date_time,
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
       
    
            // $i =0;
            // while($row = $sql->fetch(PDO::FETCH_ASSOC)){
               
            //     $data_array[$i]['exam_no'] = $exam_no;
            //     $data_array[$i]['centre_code'] = $centre_code;
            //     $data_array[$i]['subject_name'] = $subject_name;
            //     $data_array[$i]['paper_no'] = $paper_no;
            //     $data_array[$i]['question'] = $question_no;
            //     $data_array[$i]['mark'] = $mark;
            //     $data_array[$i]['date_entered'] = $date_time;
            //     $i++;
            // }
        

}
$sql2 = $db_12_gce->prepare('INSERT IGNORE INTO marks
SELECT centre_code,exam_no,first_name,last_name,subject_code,paper_no,SUM(mark) AS mark,status,sen,improvised_mark,entered_by, MAX(date_entered) AS date_entered, marking_centre, "1"
FROM marks_questions WHERE centre_code =:centre_code AND exam_no =:exam_no AND subject_code =:subject_code AND paper_no =:paper_no 
GROUP BY centre_code,exam_no,first_name,last_name,subject_code,paper_no,status,sen,improvised_mark,entered_by,marking_centre
');
$sql2->execute(array(
    ':centre_code'=>$centre_code,
    ':exam_no'=>$exam_no,
    ':subject_code'=>$subject_code,
    ':paper_no'=>$paper_no,
));
    }catch(PDOEXception $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was am error: '.$e->getMessage();
    }
    }

}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Exam number parameter not set';
}
echo json_encode($data_array);
?>