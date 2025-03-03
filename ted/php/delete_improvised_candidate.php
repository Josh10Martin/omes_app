<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();

if(isset($_POST['exam_no']) && isset($_POST['subject_code']) && isset($_POST['centre_code'])){
        $exam_no = $_POST['exam_no'];
        $subject_code = $_POST['subject_code'];
        $centre_code = $_POST['centre_code'];

        $sql = $db_ted->prepare('DELETE FROM marks WHERE exam_no =:exam_no AND subject_code =:subject_code AND improvised_mark = 1 AND session =:session');
        $sql->execute(array(
                ':exam_no'=>$exam_no,
                ':subject_code'=>$subject_code,
                ':session'=>$_SESSION['session_year'],
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                ted_deduct_improvised_script($db_ted,$centre_code,$subject_code,$_SESSION['marking_centre_code'],$_SESSION['session_year']);
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not delete candidate';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters are set for deleting';
}
echo json_encode($data_array);
?>