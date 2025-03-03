<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$sql = $db_12_gce->prepare('SELECT g.id AS id,g.belt_no AS belt_no,s.subject_code AS subject_code,s.subject_name AS subject_name,pa.paper_no AS paper,g.no_of_centres AS no_of_centres, g.no_of_scripts AS no_of_scripts
                        FROM group_apportion g INNER JOIN subjects s ON (g.subject = s.subject_code)
                        INNER JOIN paper pa ON (s.subject_code = pa.subject_code)
                        LEFT OUTER JOIN apportionment a ON (g.id = a.group_id)
                                                        AND g.subject = a.subject
                                                        AND pa.paper_no = a.paper
                        WHERE g.paper = pa.paper_no
                        AND g.marking_centre = :marking_centre_code
                        GROUP BY g.id,g.belt_no,s.subject_code,s.subject_name,pa.paper_no
                        ORDER BY CAST(g.belt_no AS UNSIGNED) ASC,g.subject,g.paper');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                $data_array[$i]['paper'] = $row['paper'] ?? '';
                $data_array[$i]['no_of_centres'] = $row['no_of_centres'] ?? '';
                $data_array[$i]['no_of_scripts'] = $row['no_of_scripts'] ?? '';
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>