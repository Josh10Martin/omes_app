<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT ce.centre_code AS marking_centre_code, ce.name AS marking_centre_name, GROUP_CONCAT( DISTINCT d.d_name SEPARATOR ", ") AS districts, mcc.apportion_id AS apportion_id, mcc.valid as valid,
                        COUNT(DISTINCT(CASE WHEN mcc.centre_code <> "none" THEN mcc.centre_code END)) AS no_of_centres
                        FROM centre ce 
                        INNER JOIN marking_centre_centres mcc ON (ce.centre_code = mcc.marking_centre)
                        INNER JOIN school sc ON (mcc.centre_code = sc.centre_code)
                        INNER JOIN district d ON (sc.district = d.d_code)
                        WHERE ce.province = sc.province AND ce.province = mcc.province
                        AND ce.province = :province_code
                        AND ce.centre_type = :session_type 
                        AND ce.centre_type = sc.centre_type
                        GROUP BY ce.centre_code, ce.name, mcc.valid, mcc.apportion_id
');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':session_type'=>$_SESSION['session_type']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['marking_centre_code'] = $row['marking_centre_code'] ?? '';
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['apportion_id'] = $row['apportion_id'] ?? '';                
                $data_array[$i]['districts'] = $row['districts'] ?? '';
                $data_array[$i]['no_of_centres'] = $row['no_of_centres'] ?? '';
                $data_array[$i]['valid'] = $row['valid'] ?? '';
                $i++;
        }

}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>