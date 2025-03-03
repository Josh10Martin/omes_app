<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$sql = $db_12_gce->prepare('SELECT centre_code ,centre_name , CASE WHEN centre_type ="E" THEN "G.C.E" WHEN centre_type = "I" THEN "GRADE 12" ELSE "[UNKNOWN]" END AS centre_type
                        FROM school 
                        ORDER BY centre_code ASC');
$sql->execute();
if($sql->rowCount() > 0){
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['status'] = '200';
        $data_array[0]['centre_code'] = $row['centre_code'];
        $data_array[0]['centre_name'] = $row['centre_name'];
        $data_array[0]['centre_type'] = $row['centre_type'];
        $i=1;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'];
                $data_array[$i]['centre_name'] = $row['centre_name'];
                $data_array[$i]['centre_type'] = $row['centre_type'];
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>