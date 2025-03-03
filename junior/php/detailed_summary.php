<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT mp.id AS id, sc.centre_code AS centre_code, sc.centre_name AS centre_name, su.subject_name AS subject_name, d.d_name AS district,
                        ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name
                        FROM school sc INNER JOIN district d ON (sc.district = d.d_code)
                        INNER JOIN province p ON (d.p_code = p.p_code)
                        INNER JOIN centre ce ON (p.p_code = ce.province)
                        INNER JOIN marks_prep mp ON (ce.centre_code = mp.marking_centre)
                        INNER JOIN subjects su ON (mp.subject_code = su.subject_code)
                        WHERE sc.province = p.p_code
                        AND sc.province = mp.province
                        AND p.p_code = mp.province
                        AND sc.province = ce.province
                        AND mp.subject_code = su.subject_code
                        AND mp.province =:province_code
                        GROUP BY mp.id,sc.centre_code,sc.centre_name,su.subject_name,d.d_name,ce.centre_code,ce.name');
$sql->execute(array(
    ':province_code'=>$_SESSION['province_code']
));
if($sql->rowCount() > 0){
    $i=0;
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['id'] = $row['id'] ?? '';
        $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
        $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
        $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
        $data_array[$i]['marking_centre_code'] = $row['marking_centre_code'] ?? '';
        $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
        $data_array[$i]['district'] = $row['district'] ?? '';
        $i++;
    }
    
}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>