<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
 if(isset($_POST['subject_code']) && isset($_POST['paper'])){
        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];

        $sql = $db_12_gce->prepare('WITH cte AS(
        SELECT DISTINCT e.examiner_number AS examiner_number,e.nrc AS nrc,e.id AS id,e.first_name AS first_name,e.last_name AS last_name,e.role AS position,CASE WHEN e.belt_no IS NULL THEN "NOT BELTED" ELSE e.belt_no END AS belt_no
        FROM marking_centre mc INNER JOIN examiner e ON (mc.centre_code = e.marking_centre)
       
        WHERE e.marking_centre = mc.centre_code
        AND e.attendance = "1"
        AND e.role <> "DATA ENTRY OFFICER"
        AND e.marking_centre =:marking_centre_code
        AND e.subject_code = mc.subject
        AND e.paper_no = mc.paper
        AND mc.subject =:subject_code
        AND mc.paper =:paper)

        SELECT * FROM cte
        ORDER BY FIELD(belt_no, "NOT BELTED") DESC');
$sql->execute(array(
':marking_centre_code'=>$_SESSION['marking_centre_code'],
':subject_code'=>$subject_code,
':paper'=>$paper
));
if($sql->rowCount() > 0){
$data_array['status'] = '200';

$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
$data_array[$i]['examiner_number'] = $row['examiner_number'] ?? '';
$data_array[$i]['nrc'] = $row['nrc'] ?? '';
$data_array[$i]['id'] = $row['id'] ?? '';
$data_array[$i]['first_name'] = $row['first_name'] ?? '';
$data_array[$i]['last_name'] = $row['last_name'] ?? '';
$data_array[$i]['position'] = $row['position'] ?? '';
$data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
$data_array[$i]['belt'] = str_replace(' ','_',$row['belt_no']);
$data_array[$i]['belt2'] = $row['belt_no'] == "NOT BELTED" ? 'NOT_BELTED' : 'BELTED';
$i++;
}
}else{
$data_array['status'] = '400';
$data_array['marking_centre_code'] = $_SESSION['marking_centre_code'];
}
}
echo json_encode($data_array);
?>