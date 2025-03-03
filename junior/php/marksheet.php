<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_POST['centre']) && isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['status']) && isset($_POST['candidate_type'])){
        $school = $_POST['centre'];
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $status = $_POST['status'];
        $candidate_type = $_POST['candidate_type'];
        if(account_not_provided($db_9,'DEO',$_SESSION['username']) == 'true'){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'You need to provide further account details in the form as you visit the dashboard';
        }else{

        $sql =$db_9->prepare('SELECT s.subject_code AS subject_code, s.subject_name AS subject_name, sc.centre_code AS centre_code, sc.centre_name,
                                pa.paper_no AS paper_no,pa.max_mark AS max_mark, m.exam_no AS exam_no, m.first_name AS first_name,m.last_name AS last_name, CASE WHEN m.mark = 0 AND m.status ="L" THEN "" ELSE m.mark END AS mark,m.status AS status,
                                m.entered_by AS entered_by,m.date_entered AS date_entered
                                FROM school sc INNER JOIN marks m ON (sc.centre_code = m.centre_code)
                                INNER JOIN subjects s ON (m.subject_code = s.subject_code)
                                INNER JOIN paper pa ON (s.subject_code = pa.subject_code)
                                WHERE m.paper_no = pa.paper_no
                                AND m.subject_code = pa.subject_code
                                AND m.centre_code =:centre_code
                                AND m.subject_code =:subject_code
                                AND m.paper_no =:paper_no
                                AND m.status =:status
                                AND (m.entered_by =:username OR m.entered_by = "none")
                                AND m.marking_centre =:marking_centre_code
                                AND m.sen =:candidate_type
                                AND m.province =:province_code
                                ORDER BY m.exam_no ASC');
        $sql->execute(array(
                ':centre_code'=>$school,
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':status'=>$status,
                ':candidate_type'=>$candidate_type,
                ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':province_code'=>$_SESSION['province_code']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $i =0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array['subject_code'] = $row['subject_code'] ?? '';
                        $data_array['subject_name'] = $row['subject_name'] ?? '';
                        $data_array['centre_code'] = $row['centre_code'] ?? '';
                        $data_array['centre_name'] = $row['centre_name'] ?? '';
                        $data_array['paper_no'] = $row['paper_no'] ?? '';
                        $data_array['max_mark'] = $row['max_mark'] ?? '';
                        
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