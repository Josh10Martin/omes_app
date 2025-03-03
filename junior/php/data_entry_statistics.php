<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');

include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;
if($_SESSION['user_type'] == 'DEO'){
      $sql = $db_9->prepare('SELECT  SUM(m.status <> "L") AS script_no_entered, SUM(m.status <> "L") * (mr.data_entry * :rate_value) AS gross_pay,
                              (SUM(m.status <> "L") * (mr.data_entry * :rate_value)) * (15/100) AS 15_wht, 
                              (SUM(m.status <> "L") * (mr.data_entry * :rate_value)) - ((SUM(m.status <> "L") * (mr.data_entry * :rate_value)) * :tax) AS net_pay,
                              
                              mr.data_entry * :rate_value AS data_entry_rate
                              FROM  users u INNER JOIN marks m ON (u.marking_centre = m.marking_centre)
                              INNER JOIN marking_rates mr ON (m.subject_code = mr.subject_code)
                              WHERE m.paper_no = mr.paper_no
                              AND u.province = m.province
                              AND m.marking_centre =:marking_centre_code
                              AND m.province =:province_code
                              AND u.username = LEFT(m.entered_by,LOCATE(" ",m.entered_by) -1)
                              AND m.entered_by =:username
                              GROUP BY mr.data_entry');
      $sql->execute(array(
            ':marking_centre_code'=>$_SESSION['marking_centre_code'],
            ':province_code'=>$_SESSION['province_code'],
            ':rate_value'=>$rate_value,
            ':tax'=>$tax,
            ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name']
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['script_no_entered'] = $row['script_no_entered'] ?? '0';
       
        $data_array['data_entry_rate'] = $row['data_entry_rate'] ?? '0';
        $data_array['gross_pay'] =  number_format((float)$row['gross_pay'],2,'.','') ?? '0';
        $data_array['wht'] =  number_format((float)$row['15_wht'],2,'.','') ?? '0';
        $data_array['net_pay'] = number_format((float)$row['net_pay'],2,'.','') ?? '0';
}

echo json_encode($data_array);
?>