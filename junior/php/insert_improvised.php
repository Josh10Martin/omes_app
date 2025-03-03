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
    $mark = $_POST['mark'];
    $max_mark = $_POST['max_mark'];
    $date_time = date('d/m/Y H:m:s');
    $status = '-';
    $improvised_mark = '1';
    if(in_marksheet($db_9,$exam_no,$subject_code,$paper_no) == 'true'){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The exam number '.$exam_no.' with subject '.$subject_name.' PAPER '.$paper_no.' is already in the marksheet';
    }else if($mark > $max_mark){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The entered mark for candidate is higher than '.$max_mark;
   
    }else{
        try{
        $sql = $db_9->prepare('INSERT IGNORE INTO marks (centre_code,exam_no,subject_code,paper_no,mark,status,sen,improvised_mark,entered_by,date_entered,marking_centre,province)
                                VALUES(:centre_code,:exam_no,:subject_code,:paper_no,:mark,:status,:candidate_type,:improvised_mark,:entered_by,:date_entered,:marking_centre_code,:province_code)');
        $sql->execute(array(
            ':centre_code'=>$centre_code,
            ':exam_no'=>$exam_no,
            ':centre_code'=>$centre_code,
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':mark'=>$mark,
            ':status'=>$status,
            ':candidate_type'=>$candidate_type,
            ':improvised_mark'=>$improvised_mark,
            ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
            ':date_entered'=>$date_time,
            ':marking_centre_code'=>$_SESSION['marking_centre_code'],
            ':province_code'=>$_SESSION['province_code']
        ));
            $data_array['status'] = '200';
            $data_array['exam_no'] = $exam_no;
            $data_array['centre_code'] = $centre_code;
            $data_array['subject_name'] = $subject_name;
            $data_array['paper_no'] = $paper_no;
            $data_array['mark'] = $mark;
            $data_array['date_entered'] = $date_time;
    }catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['status'] = 'There was a problem: '.$e->getMessage();
    }

        // }else{
        //     $data_array['status'] = '400';
        //     $data_array['response_msg'] = 'There was a problem adding improvised mark';
        // }
    }

}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Exam number parameter not set';
}
echo json_encode($data_array);
?>