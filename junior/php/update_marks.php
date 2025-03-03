<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['absent_exam_no'])){
        $absent_exam_no = $_POST['absent_exam_no'];
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $paper_no = $_POST['paper_no'];
        $date_entered = date('d/m/Y H:m:s');
        $sql = $db_9->prepare('UPDATE marks SET mark ="0",status ="X",entered_by =:entered_by,date_entered =:date_entered
                                                WHERE subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND exam_no =:exam_no
                                                AND marking_centre =:marking_centre_code AND province =:province_code');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':centre_code'=>$centre_code,
                ':exam_no'=>$absent_exam_no,
                ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                ':date_entered'=>$date_entered,
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':province_code'=>$_SESSION['province_code']
        ));

        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not update candidate to absent';
        }
}
if(isset($_POST['missing_exam_no'])){
        $missing_exam_no = $_POST['missing_exam_no'];
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $paper_no = $_POST['paper_no'];
        $sql = $db_9->prepare('UPDATE marks SET mark ="0",status ="L",entered_by = "none",date_entered = "none"
                                                WHERE subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND exam_no =:exam_no
                                                AND marking_centre =:marking_centre_code AND province =:province_code');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':centre_code'=>$centre_code,
                ':exam_no'=>$missing_exam_no,
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':province_code'=>$_SESSION['province_code']
        ));

        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not update candidate to missing';
        }
}
if(isset($_POST['centre_code']) || isset($_POST['subject_code']) || isset($_POST['paper_no']) || isset($_POST['raw_mark'])){
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $paper_no = $_POST['paper_no'];
        $raw_mark = $_POST['raw_mark'];

        
        
        try{
        // $date_entered = date('Y-m-d H:i:s',strtotime($_POST['date_entered']));
        
        
        foreach($raw_mark as $exam_no => $mark){
                
                $status  = $_POST['status'][$exam_no];
                // $entered_by = $_POST['entered_by'][$exam_no];
                $date_entered =$_POST['date_entered'][$exam_no];
                if($mark != '' && $status != 'L'){


                $sql = $db_9->prepare('UPDATE marks SET mark =:mark,status =:status,entered_by = CASE WHEN status ="L" THEN "none" ELSE :entered_by END,date_entered = CASE WHEN status ="L" THEN "none" ELSE :date_entered END
                                        WHERE exam_no =:exam_no AND subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND marking_centre =:marking_centre_code AND province =:province_code');
                $sql->execute(array(
                        ':mark'=>$mark,
                        ':status'=>$status,
                        ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                        ':date_entered'=>$date_entered,
                        ':exam_no'=>$exam_no,
                        ':paper_no'=>$paper_no,
                        ':subject_code'=>$subject_code,
                        ':centre_code'=>$centre_code,
                        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                        ':province_code'=>$_SESSION['province_code']
                ));
               
              

        }
}
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Marks have been successfully saved.';

        $_SESSION['centre_code'] = $centre_code;
        $_SESSION['subject_code'] = $subject_code;
        $_SESSION['paper_no'] = $paper_no;
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
}
echo json_encode($data_array);
?>