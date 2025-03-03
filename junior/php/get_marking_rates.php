<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT mr.id AS id, s.subject_name AS subject_name,pa.paper_no AS paper_no,mr.chief_examiner AS chief_examiner,mr.deputy_c_examiner AS deputy_c_examiner,mr.t_leader AS t_leader, mr.examiner AS examiner,mr.data_entry AS data_entry
                FROM subjects s INNER JOIN marking_rates mr ON (s.subject_code = mr.subject_code)
                INNER JOIN paper pa ON (mr.paper_no = pa.paper_no)
                WHERE s.subject_code = pa.subject_code');
$sql->execute();
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                $data_array[$i]['chief_examiner'] = $row['chief_examiner'] ?? '';
                $data_array[$i]['deputy_c_examiner'] = $row['deputy_c_examiner'] ?? '';
                $data_array[$i]['t_leader'] = $row['t_leader'] ?? '';
                $data_array[$i]['examiner'] = $row['examiner'] ?? '';
                $data_array[$i]['data_entry_operator'] = $row['data_entry'] ?? '';
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>