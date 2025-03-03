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
        $date_entered = date('d/m/Y H:m:s');
       
        $sql = $db_ted->prepare('UPDATE marks SET mark ="0",status ="X",entered_by =:entered_by,date_entered =:date_entered
                                                WHERE subject_code =:subject_code AND centre_code =:centre_code AND exam_no =:exam_no AND session =:session ');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':centre_code'=>$centre_code,
                ':exam_no'=>$absent_exam_no,
                ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                ':date_entered'=>$date_entered,
                ':session'=>$_SESSION['session_year']
        ));

        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not update candidate to absent. Reload and try again.';
        }
      
}
if(isset($_POST['missing_exam_no'])){
        $missing_exam_no = $_POST['missing_exam_no'];
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];

       
        $sql = $db_ted->prepare('UPDATE marks SET mark ="0",status ="L",entered_by = "none",date_entered = "none"
                                                WHERE subject_code =:subject_code AND centre_code =:centre_code AND exam_no =:exam_no AND session =:session');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':centre_code'=>$centre_code,
                ':exam_no'=>$missing_exam_no,
                ':session'=>$_SESSION['session_year']
        ));

        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not update candidate to missing. Reload and try again.';
        }

}
if(isset($_POST['centre_code']) && isset($_POST['subject_code']) && isset($_POST['raw_mark']) && isset($_POST['sen']) && isset($_POST['belt_no'])){
        $centre_code = $_POST['centre_code'];
        $subject_code = $_POST['subject_code'];
        $raw_mark = $_POST['raw_mark'];
        $sen = $_POST['sen'];
        $belt_no = $_POST['belt_no'];
        // $date_entered = date('Y-m-d H:i:s',strtotime($_POST['date_entered']));
       
        try{ 
        foreach($raw_mark as $exam_no => $mark){
             

                $status  = $_POST['status'][$exam_no];
                // $entered_by = $_POST['entered_by'][$exam_no];
                $date_entered =$_POST['date_entered'][$exam_no];

                        if($mark != "" && $status != 'L'){
                                $sql0 = $db_ted->prepare('SELECT mark,status FROM marks WHERE exam_no = :exam_no AND subject_code = :subject_code AND centre_code = :centre_code AND marking_centre = :marking_centre_code');
                                $sql0->execute(array(
                                    ':exam_no' => $exam_no,
                                    ':subject_code' => $subject_code,
                                    ':centre_code' => $centre_code,
                                    ':marking_centre_code' => $_SESSION['marking_centre_code']
                                ));
                                $row = $sql0->fetch(PDO::FETCH_ASSOC);
                                $entered_mark = $row['mark'] ?? '';
                                $stored_status = $row['status'] ?? '';
                                if($mark != $entered_mark || ($mark == $entered_mark && $status != $stored_status)){
                                $sql = $db_ted->prepare('UPDATE marks SET mark = CASE WHEN :mark = "" THEN 0 ELSE :mark END,status =:status,belt_no =:belt_no,entered_by = CASE WHEN status ="L" THEN "none" ELSE :entered_by END,
                                                        date_entered = CASE WHEN status ="L" THEN "none" ELSE :date_entered END
                                                        WHERE exam_no =:exam_no AND subject_code =:subject_code AND centre_code =:centre_code AND marking_centre =:marking_centre_code AND session =:session ');
                                $sql->execute(array(
                                        ':mark'=>$mark,
                                        ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                                        ':status'=>$status,
                                        ':date_entered'=>$date_entered,
                                        ':exam_no'=>$exam_no,
                                        ':subject_code'=>$subject_code,
                                        ':centre_code'=>$centre_code,
                                        ':belt_no'=>$belt_no,
                                        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                                        ':session'=>$_SESSION['session_year']
                                ));
                        }
                
                
                
        }
}
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'Mark(s) saved.';
                $_SESSION['centre_code'] = $centre_code;
                $_SESSION['subject_code'] = $subject_code;
                $_SESSION['sen'] = $sen;
                
         ted_group_apportion($db_ted,$subject_code,$belt_no,$username,$_SESSION['marking_centre_code'],$_SESSION['session_year']);
          ted_add_in_apportionment($db_ted,$centre_code,$subject_code,$belt_no,$_SESSION['marking_centre_code']);
       
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
      
  
}


echo json_encode($data_array);
?>