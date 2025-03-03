<?php
header("Access-Control-Allow-Origin: *"); 
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['subject_code']) && isset($_POST['paper'])){
        if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 'SESO' || $_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO')){

        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];

        $sql = $db_9->prepare('SELECT DISTINCT belt_no FROM group_apportion WHERE subject =:subject_code 
                                AND paper =:paper_no
                                AND province =:province_code
                                AND marking_centre =:marking_centre_code
                                ORDER BY belt_no ASC');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper,
                ':province_code'=>$_SESSION['province_code'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $i++;
                }
        }
}else{
        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];

        $sql = $db_9->prepare('SELECT DISTINCT belt_no FROM group_apportion WHERE subject =:subject_code 
                                AND paper =:paper_no
                                ORDER BY belt_no ASC');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $i++;
                }
        }
}
}
echo json_encode($data_array);