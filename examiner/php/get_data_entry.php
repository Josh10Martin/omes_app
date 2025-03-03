<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
$data_array = array();

$sql = $db_12_gce->prepare('SELECT id, examiner_number,first_name,last_name, CASE WHEN activation_status = 1 THEN "ACTIVE" ELSE "NOT ACTIVE" END AS active,
                            CASE WHEN login_status = 0 THEN "LOGGED OUT" ELSE "LOGGED IN" END AS login_status
                            FROM examiner WHERE marking_centre =:marking_centre_code AND role = "DATA ENTRY OFFICER" AND attendance = 1');
$sql->execute(array(
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
   $i=0;
   while( $row = $sql->fetch(PDO::FETCH_ASSOC)){
    $data_array[$i]['id'] = $row['id'] ?? '';
    $data_array[$i]['username'] = $row['examiner_number'] ?? '';
    $data_array[$i]['first_name'] = $row['first_name'] ?? '';
    $data_array[$i]['last_name'] = $row['last_name'] ?? '';
    $data_array[$i]['active'] = $row['active'] ?? '';
    $data_array[$i]['login_status'] = $row['login_status'] ?? '';
    $i++;
   }

}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>