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
    $belt_no = $_POST['belt_no'];
    $mark = $_POST['mark'];
    $max_mark = $_POST['max_mark'];
    $date_time = date('d/m/Y H:m:s');
    $status = '-';
    $improvised_mark = '1';
    $username = $_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'];

    if(in_marksheet($db_12_gce,$exam_no,$subject_code,$paper_no) == 'true'){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The exam number '.$exam_no.' with subject '.$subject_name.' PAPER '.$paper_no.' is already in the marksheet';
    }else if($mark > $max_mark){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The entered mark for candidate is higher than '.$max_mark;
    }else if($belt_no == 0){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'The belt number entered should not be 0';
    }else if(centre_already_entered($db_12_gce,$subject_code,$paper_no,$centre_code,$belt_no,$candidate_type,$_SESSION['marking_centre_code']) != 'true'){
        $data_array['status'] = '400';
        $data_array['response_msg'] = centre_already_entered($db_12_gce,$subject_code,$paper_no,$centre_code,$belt_no,$candidate_type,$_SESSION['marking_centre_code']);
    }else{
        $sql = $db_12_gce->prepare('INSERT IGNORE INTO marks (centre_code,exam_no,subject_code,paper_no,mark,status,sen,improvised_mark,belt_no,entered_by,date_entered,marking_centre,disable)
                                VALUES(:centre_code,:exam_no,:subject_code,:paper_no,:mark,:status,:candidate_type,:improvised_mark,:belt_no,:entered_by,:date_entered,:marking_centre_code,"1")');
        $sql->execute(array(
            ':centre_code'=>$centre_code,
            ':exam_no'=>$exam_no,
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
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
            $data_array['paper_no'] = $paper_no;
            $data_array['mark'] = $mark;
            $data_array['belt_no'] = $belt_no;
            $data_array['date_entered'] = $date_time;

            group_apportion($db_12_gce,$subject_code,$paper_no,$belt_no,$username,$_SESSION['marking_centre_code']);
            add_in_apportionment($db_12_gce,$centre_code,$subject_code,$paper_no,$candidate_type,$belt_no,$_SESSION['marking_centre_code']);

            

            
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