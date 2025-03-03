<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT apportion_id,marking_centre AS marking_centre_code,marking_centre_name,subject_name AS subjects,d_name AS districts,no_of_centres,valid
                        FROM apportionment_summary WHERE province =:province_code
                        AND apportion_id IN (SELECT apportion_id FROM marks_prep WHERE province =:province_code)');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['marking_centre_code'] = $row['marking_centre_code'] ?? '';
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['apportion_id'] = $row['apportion_id'] ?? '';
                $data_array[$i]['subjects'] =  $row['subjects'] ?? '';
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