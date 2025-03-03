<?php
header("Access-Control-Allow-Origin: *");
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
        if(isset($_POST['subject_code']) && isset($_POST['marking_centre_code'])){
                $subject_code = $_POST['subject_code'];
                $marking_centre_code = $_POST['marking_centre_code'];

                $sql = $db_12_gce->prepare('SELECT subject_code,paper_no FROM paper WHERE subject_code =:subject_code AND paper_no IN (SELECT paper FROM marking_centre WHERE centre_code =:marking_centre_code AND subject =:subject_code)');
                $sql->execute(array(
                        ':subject_code'=>$subject_code,
                        ':marking_centre_code'=>$marking_centre_code
                ));
                // $row = $sql->fetch(PDO::FETCH_ASSOC);
                // $data_array[0]['subject_code'] = $row['subject_code'];
                // $data_array[0]['paper_no'] = $row['paper_no'];
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['subject_code'] = $row['subject_code'];
                        $data_array[$i]['paper_no'] = $row['paper_no'];
                        $i++;
                }
        }
}else{
if(isset($_POST['subject_code'])){
        $subject_code = $_POST['subject_code'];
        $marking_centre_code = isset($_POST['marking_centre_code']) ? $_POST['marking_centre_code'] : (isset($_SESSION['marking_centre_code']) ? $_SESSION['marking_centre_code'] : '');

        $sql = $db_12_gce->prepare('SELECT subject_code,paper_no FROM paper WHERE subject_code =:subject_code AND paper_no IN (SELECT paper FROM marking_centre WHERE centre_code =:marking_centre_code AND subject =:subject_code)');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':marking_centre_code'=>$marking_centre_code
        ));;
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['subject_code'] = $row['subject_code'];
                $data_array[$i]['paper_no'] = $row['paper_no'];
                $i++;
        }
}
}
echo json_encode($data_array);
?>