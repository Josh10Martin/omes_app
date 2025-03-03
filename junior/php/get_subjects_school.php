<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$sql = $db_9->prepare('SELECT DISTINCT su.subject_code AS subject_code, su.subject_name AS subject_name
                        FROM subjects su INNER JOIN school_subject ss ON (su.subject_code = ss.subject_code)
                        WHERE ss.centre_code IN (SELECT centre_code FROM school WHERE province =:province_code)
                        ORDER BY subject_name ASC');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                $i++;
        }
}else{
        $data_array['status'] = '400';
}

echo json_encode($data_array);
?>