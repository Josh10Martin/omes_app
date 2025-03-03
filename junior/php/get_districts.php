<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT d_code, d_name FROM district WHERE p_code =:province_code ORDER BY d_name ASC');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['district_code'] = $row['d_code'] ?? '';
                $data_array[$i]['district_name'] = $row['d_name'] ?? '';
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>