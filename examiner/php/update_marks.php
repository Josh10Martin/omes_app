<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
$username = $_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'];
if(isset($_POST['absent_exam_no'])){
        $absent_exam_no = $_POST['absent_exam_no'];
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $paper_no = $_POST['paper_no'];
        $date_entered = date('d/m/Y H:m:s');
        // if(marrks_disabled($db_12_gce,$absent_exam_no,$centre_code,$subject_code,$paper_no,$username,$_SESSION['marking_centre_code']) == 'true'){
        //         $data_array['status'] = '400';
        //         $data_array['response_msg'] = 'You cannot add an absent. Refresh the page and get in touch with your Chief Examiner to allow edit';
        // }else{
        $sql = $db_12_gce->prepare('UPDATE marks SET mark ="0",status ="X",entered_by =:entered_by,date_entered =:date_entered, disable = 1
                                                WHERE subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND exam_no =:exam_no');
        $sql->execute(array(
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
                $data_array['response_msg'] = 'Could not update candidate to absent. Reload and try again.';
        }
        // }
}
if(isset($_POST['missing_exam_no'])){
        $missing_exam_no = $_POST['missing_exam_no'];
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $paper_no = $_POST['paper_no'];

        // if(marrks_disabled($db_12_gce,$missing_exam_no,$centre_code,$subject_code,$paper_no,$username,$_SESSION['marking_centre_code']) == 'true'){
        //         $data_array['status'] = '400';
        //         $data_array['response_msg'] = 'You cannot remove an absent. Refresh the page and get in touch with your Chief Examiner to allow edit';
        // }else{
        $sql = $db_12_gce->prepare('UPDATE marks SET mark ="0",status ="L",entered_by = "none",date_entered = "none", disable = 0
                                                WHERE subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND exam_no =:exam_no');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':centre_code'=>$centre_code,
                ':exam_no'=>$missing_exam_no
        ));

        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not update candidate to missing. Reload and try again.';
        }
// }
}
if(isset($_POST['centre_code']) && isset($_POST['subject_code']) && isset($_POST['paper_no']) && isset($_POST['raw_mark']) && isset($_POST['sen']) && isset($_POST['belt_no'])){
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $paper_no = $_POST['paper_no'];
        $raw_mark = $_POST['raw_mark'];
        $sen = $_POST['sen'];
        $belt_no = $_POST['belt_no'];
        // $date_entered = date('Y-m-d H:i:s',strtotime($_POST['date_entered']));
       
        try{ 
        foreach($raw_mark as $exam_no => $mark){
                // if(marrks_disabled($db_12_gce,$exam_no,$centre_code,$subject_code,$paper_no,$username,$_SESSION['marking_centre_code']) == 'true'){
                //         $data_array['status'] = '400';
                //         $data_array['response_msg'] = 'You cannot re-submit mark(s). Get in touch with your Chief Examiner to allow edit';
                // }else{

                $status  = $_POST['status'][$exam_no];
                // $entered_by = $_POST['entered_by'][$exam_no];
                $date_entered =$_POST['date_entered'][$exam_no];

                        if($mark != "" && ($status != 'L' && $status != "")){
                                $sql0 = $db_12_gce->prepare('SELECT mark,status FROM marks WHERE exam_no = :exam_no AND subject_code = :subject_code AND paper_no = :paper_no AND centre_code = :centre_code AND marking_centre = :marking_centre_code');
                                $sql0->execute(array(
                                    ':exam_no' => $exam_no,
                                    ':paper_no' => $paper_no,
                                    ':subject_code' => $subject_code,
                                    ':centre_code' => $centre_code,
                                    ':marking_centre_code' => $_SESSION['marking_centre_code']
                                ));
                                $row = $sql0->fetch(PDO::FETCH_ASSOC);
                                $entered_mark = $row['mark'] ?? '';
                                $stored_status = $row['status'] ?? '';
                                if($mark != $entered_mark || ($mark == $entered_mark && $status != $stored_status)){
                                $sql = $db_12_gce->prepare('UPDATE marks SET mark = CASE WHEN :mark = "" THEN 0 ELSE :mark END,status =:status,belt_no =:belt_no,entered_by = CASE WHEN status ="L" THEN "none" ELSE :entered_by END,
                                                        date_entered = CASE WHEN status ="L" THEN "none" ELSE :date_entered END, disable = CASE WHEN status = "L" THEN 0 ELSE 1 END
                                                        WHERE exam_no =:exam_no AND subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND marking_centre =:marking_centre_code AND disable = 0');
                                $sql->execute(array(
                                        ':mark'=>$mark,
                                        ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                                        ':status'=>$status,
                                        ':date_entered'=>$date_entered,
                                        ':exam_no'=>$exam_no,
                                        ':paper_no'=>$paper_no,
                                        ':subject_code'=>$subject_code,
                                        ':centre_code'=>$centre_code,
                                        ':belt_no'=>$belt_no,
                                        ':marking_centre_code'=>$_SESSION['marking_centre_code']
                                ));
                        }
                
                // }
                
        }
}
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'Authorised marks have been successfully saved';
                $_SESSION['centre_code'] = $centre_code;
                $_SESSION['subject_code'] = $subject_code;
                $_SESSION['paper_no'] = $paper_no;
                $_SESSION['sen'] = $sen;
                
         group_apportion($db_12_gce,$subject_code,$paper_no,$belt_no,$username,$_SESSION['marking_centre_code']);
          add_in_apportionment($db_12_gce,$centre_code,$subject_code,$paper_no,$sen,$belt_no,$_SESSION['marking_centre_code']);
       
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
      
  
}
// $sql2 = $db_12_gce->prepare('UPDATE marks 
//                              SET disable = 1 
//                              WHERE disable = 0 
//                              AND status <> "L"
//                              AND entered_by = :username 
//                              AND subject_code = :subject_code 
//                              AND paper_no = :paper_no 
//                              AND centre_code = :centre_code 
//                              AND marking_centre = :marking_centre_code');

// $sql2->execute(array(
//     ':username' => $username,
//     ':paper_no' => $paper_no,
//     ':subject_code' => $subject_code,
//     ':centre_code' => $centre_code,
//     ':marking_centre_code' => $_SESSION['marking_centre_code']
// ));

echo json_encode($data_array);
?>