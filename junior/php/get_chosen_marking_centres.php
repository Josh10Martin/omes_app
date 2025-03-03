<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT s.subject_code AS subject_code, s.subject_name AS subject_name,pa.paper_no AS paper, c.name AS marking_centre_name
                        FROM centre c INNER JOIN marking_centre mc ON (c.centre_code = mc.centre_code)
                        RIGHT OUTER JOIN subjects s ON (mc.subject = s.subject_code)
                        INNER JOIN paper pa ON (s.subject_code = pa.subject_code)
                        ');
$sql->execute();
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
         $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                $data_array[$i]['paper'] = $row['paper'] ?? '';
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>