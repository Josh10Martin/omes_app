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
        $sql = $db_12_gce->prepare('UPDATE marks_questions SET mark = 0,status ="X",entered_by =:entered_by,date_entered =:date_entered, disable = 1
                                                WHERE subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND exam_no =:exam_no');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':centre_code'=>$centre_code,
                ':exam_no'=>$absent_exam_no,
                ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                ':date_entered'=>$date_entered
        ));
        $sql2 = $db_12_gce->prepare('UPDATE marks SET mark = 0,status ="X",entered_by =:entered_by,date_entered =:date_entered
                                                WHERE subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND exam_no =:exam_no');
        $sql2->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':centre_code'=>$centre_code,
                ':exam_no'=>$absent_exam_no,
                ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                ':date_entered'=>$date_entered
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
        $sql = $db_12_gce->prepare('UPDATE marks_questions SET mark = 0,status ="L",entered_by = NULL,date_entered = NULL, disable = 0
                                                WHERE subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND exam_no =:exam_no');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':centre_code'=>$centre_code,
                ':exam_no'=>$missing_exam_no
        ));
        $sql2 = $db_12_gce->prepare('UPDATE marks SET mark = 0,status ="L",entered_by = NULL,date_entered = NULL
                                                WHERE subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND exam_no =:exam_no');
        $sql2->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':centre_code'=>$centre_code,
                ':exam_no'=>$missing_exam_no
        ));

        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not update candidate to missing';
        }
}
if(isset($_POST['centre_code']) && isset($_POST['subject_code']) && isset($_POST['paper_no']) && isset($_POST['raw_mark'])){
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $paper_no = $_POST['paper_no'];
        $raw_mark = $_POST['raw_mark'];
        
        
       
        // $date_entered = date('Y-m-d H:i:s',strtotime($_POST['date_entered']));
        
        try{
                // $db_12_gce->beginTransaction(); 

        foreach($raw_mark as $exam_no => $mark){

            foreach($mark as $key => $value){
                
                $status  = isset($_POST['status'][$exam_no]) ? $_POST['status'][$exam_no] : null;
                // $entered_by = $_POST['entered_by'][$exam_no];
                $date_entered =isset($_POST['date_entered'][$exam_no]) ? $_POST['date_entered'][$exam_no] : null;
                if(isset($status) && isset($date_entered)){

                $sql = $db_12_gce->prepare('UPDATE marks_questions SET mark =:mark,status =:status,entered_by = CASE WHEN status ="L" THEN NULL ELSE :entered_by END,date_entered = CASE WHEN status ="L" THEN NULL ELSE :date_entered END, disable = CASE WHEN status = "L" THEN 0 ELSE 1 END
                                        WHERE exam_no =:exam_no AND subject_code =:subject_code AND paper_no =:paper_no AND question =:question AND centre_code =:centre_code AND marking_centre =:marking_centre_code');
                $sql->execute(array(
                        ':mark'=>$value,
                        ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                        ':status'=>$status,
                        ':date_entered'=>$date_entered,
                        ':exam_no'=>$exam_no,
                        ':paper_no'=>$paper_no,
                        ':subject_code'=>$subject_code,
                        ':question'=>$key,
                        ':centre_code'=>$centre_code,
                        ':marking_centre_code'=>$_SESSION['marking_centre_code']
                ));
                       
                        
                }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Status and date params not set';
                }

        }
        $status  = isset($_POST['status'][$exam_no]) ? $_POST['status'][$exam_no] : null;
        $total_mark = $_POST['total_mark'][$exam_no];
        $date_entered =isset($_POST['date_entered'][$exam_no]) ? $_POST['date_entered'][$exam_no] : null;
        if(isset($status) && isset($date_entered)){
                $sql = $db_12_gce->prepare('UPDATE marks SET mark =:mark,status =:status,entered_by = CASE WHEN status ="L" THEN NULL ELSE :entered_by END,date_entered = CASE WHEN status ="L" THEN NULL ELSE :date_entered END
                WHERE exam_no =:exam_no AND subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND marking_centre =:marking_centre_code');
                $sql->execute(array(
                ':mark'=>$total_mark,        
                ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                ':status'=>$status,
                ':date_entered'=>$date_entered,
                ':exam_no'=>$exam_no,
                ':paper_no'=>$paper_no,
                ':subject_code'=>$subject_code,
                ':centre_code'=>$centre_code,
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
                ));
        }

    }
//     $db_12_gce->commit(); 
$data_array['status'] = '200';
$data_array['response_msg'] = 'Marks have been successfully saved';

}catch(PDOException $e){
        // $db_12_gce->rollBack(); 
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
}
echo json_encode($data_array);
?>