<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
$username = $_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'];
if(isset($_POST['centre']) && isset($_POST['subject']) && isset($_POST['belt_no']) && isset($_POST['status']) && isset($_POST['candidate_type'])){
        $school = $_POST['centre'];
        $subject_code = explode(':',$_POST['subject'])[0];
        $candidate_type = $_POST['candidate_type'];
        $status = $_POST['status'];
        $belt_no = $_POST['belt_no'];
        if($status == 'L' && ($belt_no == 0 || $belt_no == '')){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Enter a belt number. Not 0';
        }elseif($status == 'L' && ted_centre_already_entered($db_ted,$subject_code,$school,$belt_no,$_SESSION['marking_centre_code'], $_SESSION['session_year']) != 'true'){
                $data_array['status'] = '400';
                $data_array['response_msg'] = ted_centre_already_entered($db_ted,$subject_code,$school,$belt_no,$_SESSION['marking_centre_code'], $_SESSION['session_year']);
        }else{

        $sql =$db_ted->prepare('SELECT s.subject_code AS subject_code, s.subject_name AS subject_name, sc.centre_code AS centre_code, sc.centre_name,
                                s.max_mark AS max_mark, m.exam_no AS exam_no, m.first_name AS first_name,m.last_name AS last_name, 
                                CASE WHEN m.mark = 0 AND m.status ="L" THEN "" ELSE m.mark END AS mark,m.status AS status,m.sen AS sen,m.belt_no AS belt_no,
                                m.entered_by AS entered_by,m.date_entered AS date_entered
                                FROM school sc INNER JOIN marks m ON (sc.centre_code = m.centre_code)
                                INNER JOIN subjects s ON (m.subject_code = s.subject_code)
                                WHERE m.centre_code =:centre_code
                                AND m.subject_code =:subject_code
                                AND m.status =:status
                                AND improvised_mark = 0
                                AND (m.entered_by =:entered_by OR m.entered_by = "none")
                                AND m.marking_centre =:marking_centre_code
                                AND m.sen =:candidate_type
                                AND m.session =:session
                                ORDER BY m.exam_no ASC');
        $sql->execute(array(
                ':centre_code'=>$school,
                ':subject_code'=>$subject_code,
                ':status'=>$status,
                ':candidate_type'=>$candidate_type,
                ':entered_by'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':session'=>$_SESSION['session_year']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                // $row = $sql->fetch(PDO::FETCH_ASSOC);
                
                // $data_array['candidate'][0]['exam_no'] = $row['exam_no'] ?? '';
                // $data_array['candidate'][0]['first_name'] = $row['first_name'] ?? '';
                // $data_array['candidate'][0]['last_name'] = $row['last_name'] ?? '';
                // $data_array['candidate'][0]['last_name'] = $row['last_name'] ?? '';
                // $data_array['candidate'][0]['mark'] = $row['mark'] ?? '';
                // $data_array['candidate'][0]['status'] = $row['status'] ?? '';
                // $data_array['candidate'][0]['entered_by'] = $row['entered_by'] ?? '';
                // $data_array['candidate'][0]['date_entered'] = $row['date_entered'] ?? '';
                // $data_array['candidate'][0]['max_mark'] = $row['max_mark'] ?? '';
                $i =0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array['subject_code'] = $row['subject_code'] ?? '';
                        $data_array['subject_name'] = $row['subject_name'] ?? '';
                        $data_array['centre_code'] = $row['centre_code'] ?? '';
                        $data_array['centre_name'] = $row['centre_name'] ?? '';
                        $data_array['max_mark'] = $row['max_mark'] ?? '';
                        $data_array['sen'] = $row['sen'] ?? '';
                        $data_array['belt_number'] = $row['belt_no'] == 0 ? $belt_no : $row['belt_no'];
                        $data_array['record_count'] = $sql->rowCount();
                        $data_array['candidate'][$i]['exam_no'] = $row['exam_no'] ?? '';
                        $data_array['candidate'][$i]['first_name'] = $row['first_name'] ?? '';
                        $data_array['candidate'][$i]['last_name'] = $row['last_name'] ?? '';
                        $data_array['candidate'][$i]['last_name'] = $row['last_name'] ?? '';
                        $data_array['candidate'][$i]['mark'] = $row['mark'] ?? '';
                        $data_array['candidate'][$i]['status'] = $row['status'] ?? '';
                        $data_array['candidate'][$i]['entered_by'] = $row['entered_by'] ?? '';
                        $data_array['candidate'][$i]['date_entered'] = $row['date_entered'] ?? '';
                        $data_array['candidate'][$i]['max_mark'] = $row['max_mark'] ?? '';
                        $i++;
                }
                
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Marksheet not found';

        }
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all marksheet parameters set. Try again';
}
echo json_encode($data_array);
?>