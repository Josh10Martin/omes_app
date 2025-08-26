<?php
header('Content-Type:application/json ; charset=utf-8');
session_start();
include '../../config.php';
$data_array = array();

$sql = $db_12_gce->prepare('SELECT 
                    ex.id AS id, 
                    ex.examiner_number AS examiner_number,
                    ex.first_name AS first_name,
                    ex.last_name AS last_name, 
                    CASE WHEN ex.activation_status = 1 THEN "ACTIVE" ELSE "NOT ACTIVE" END AS active,
                    CASE WHEN ex.login_status = 0 THEN "LOGGED OUT" ELSE "LOGGED IN" END AS login_status,
                    SUM(m.status <> "L") AS no_of_entered_marks
                FROM examiner ex
                LEFT OUTER JOIN marks m 
                    ON ex.examiner_number = TRIM(SUBSTRING_INDEX(m.entered_by, "-", 1))
                WHERE ex.marking_centre = :marking_centre_code
                AND ex.role = "DATA ENTRY OFFICER"
                AND ex.attendance = 1
                GROUP BY ex.id, ex.examiner_number, ex.first_name, ex.last_name, ex.activation_status, ex.login_status
');
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
    $data_array[$i]['no_of_entered_marks'] = $row['no_of_entered_marks'] ?? '0';
    $data_array[$i]['active'] = $row['active'] ?? '';
    $data_array[$i]['login_status'] = $row['login_status'] ?? '';
    $i++;
   }

}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>