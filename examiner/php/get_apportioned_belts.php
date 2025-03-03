<?php
header("Access-Control-Allow-Origin: *");
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['subject_code']) && isset($_POST['paper'])){
        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];
        $marking_centre_code = isset($_POST['marking_centre_code']) ? $_POST['marking_centre_code'] : (isset($_SESSION['marking_centre_code']) ? $_SESSION['marking_centre_code'] : '');

        $sql = $db_12_gce->prepare('SELECT DISTINCT belt_no FROM apportionment WHERE subject =:subject_code 
                                AND paper =:paper_no
                                AND marking_centre =:marking_centre_code
                                ORDER BY belt_no ASC');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper,
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                // $row = $sql->fetch(PDO::FETCH_ASSOC);
                // $data_array[0]['belt_no'] = $row['belt_no'] ?? '';
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $i++;
                }
        }
}
echo json_encode($data_array);