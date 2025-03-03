<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['subject_code'])){
        $subject_code = $_POST['subject_code'];

        $sql = $db_ted->prepare('SELECT DISTINCT belt_no FROM apportionment WHERE subject =:subject_code 
                                AND session =:session
                                AND marking_centre =:marking_centre_code
                                ORDER BY belt_no ASC');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':session'=>$_SESSION['session_year'],
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
}
echo json_encode($data_array);