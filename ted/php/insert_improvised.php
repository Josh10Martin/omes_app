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
    $mark = $_POST['mark'];
    $max_mark = $_POST['max_mark'];
    $belt_no = $_POST['belt_no'];
    $date_time = date('d/m/Y H:m:s');
    $status = '-';
    $improvised_mark = '1';
    $username = $_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'];

    if(in_marksheet_ted($db_ted,$exam_no,$subject_code,$_SESSION['session_year']) == 'true'){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The exam number '.$exam_no.' with subject '.$subject_name.' is already in the marksheet';
    }else if($mark > $max_mark){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The entered mark for candidate is higher than '.$max_mark;
    }else if($belt_no == 0){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The belt number entered should not be 0';
    }else if(ted_centre_already_entered($db_ted,$subject_code,$centre_code,$belt_no,$_SESSION['marking_centre_code'],$_SESSION['session_year']) != 'true'){
        $data_array['status'] = '400';
        $data_array['response_msg'] = ted_centre_already_entered($db_ted,$subject_code,$centre_code,$belt_no,$_SESSION['marking_centre_code'],$_SESSION['session_year']);
    }else{
        $sql = $db_ted->prepare('INSERT IGNORE INTO marks (centre_code,exam_no,subject_code,mark,status,sen,improvised_mark,belt_no,entered_by,date_entered,marking_centre,session)
                                VALUES(:centre_code,:exam_no,:subject_code,:mark,:status,:candidate_type,:improvised_mark,:belt_no,:entered_by,:date_entered,:marking_centre_code,:session)');
        $sql->execute(array(
            ':centre_code'=>$centre_code,
            ':exam_no'=>$exam_no,
            ':subject_code'=>$subject_code,
            ':session'=>$_SESSION['session_year'],
            ':mark'=>$mark,
            ':status'=>$status,
            ':candidate_type'=>$candidate_type,
            ':improvised_mark'=>$improvised_mark,
            ':belt_no'=>$belt_no,
            ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
            ':date_entered'=>$date_time,
            ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['exam_no'] = $exam_no;
            $data_array['centre_code'] = $centre_code;
            $data_array['subject_name'] = $subject_name;
            $data_array['mark'] = $mark;
            $data_array['date_entered'] = $date_time;

            ted_group_apportion($db_ted,$subject_code,$belt_no,$username,$_SESSION['marking_centre_code'],$_SESSION['session_year']);
            // ted_add_in_apportionment($db_ted,$centre_code,$subject_code,$belt_no,$_SESSION['marking_centre_code']);
            ted_add_improvised_script($db_ted,$centre_code,$subject_code,$_SESSION['marking_centre_code'],$_SESSION['session_year']);

        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'There was a problem adding improvised mark';
        }
    }

}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Exam number parameter not set';
}
echo json_encode($data_array);
?>