<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$sql = $db_9->prepare('SELECT sc.centre_code AS centre_code, sc.centre_name AS centre_name,p.p_name AS province_name, 
                        CASE WHEN sc.centre_type ="E" THEN "GRADE 9 EXTERNAL" WHEN sc.centre_type = "I" THEN "GRADE 9 INTERNAL" ELSE "[UNKNOWN]" END AS centre_type,
                        d.d_name AS district_name
                        FROM school sc INNER JOIN province p ON (sc.province = p.p_code)
                        INNER JOIN district d ON (p.p_code = d.p_code)
                        WHERE sc.district = d.d_code
                        ORDER BY sc.centre_code ASC');
$sql->execute();
if($sql->rowCount() > 0){
        // $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['status'] = '200';
        // $data_array[0]['centre_code'] = $row['centre_code'];
        // $data_array[0]['centre_name'] = $row['centre_name'];
        // $data_array[0]['province_name'] = $row['province_name'];
        // $data_array[0]['centre_type'] = $row['centre_type'];
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'];
                $data_array[$i]['centre_name'] = $row['centre_name'];
                $data_array[$i]['province_name'] = $row['province_name'];
                $data_array[$i]['district_name'] = $row['district_name'];
                $data_array[$i]['centre_type'] = $row['centre_type'];
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>