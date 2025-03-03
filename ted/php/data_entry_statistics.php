<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;
$sql = $db_ted->prepare('SELECT SUM(m.status <> "L") AS no_of_scripts, 
SUM(m.status <> "L") * mr.data_entry * :rate_value AS gross_pay,
(SUM(m.status <> "L") * (mr.data_entry * :rate_value)) * :tax AS 15_wnt,
(SUM(m.status <> "L") * (mr.data_entry * :rate_value)) - ((SUM(m.status <> "L") * (mr.data_entry * :rate_value)) * :tax) AS net_pay,

mr.data_entry * :rate_value AS data_entry_rate
FROM examiner ex INNER JOIN marks m ON (ex.marking_centre = m.marking_centre)                            
CROSS JOIN marking_rates mr 
WHERE m.marking_centre =:marking_centre_code

AND ex.examiner_number = LEFT(m.entered_by,LOCATE(" ",m.entered_by) -1)
AND m.entered_by =:username
AND ex.examiner_number =:examiner_number
AND ex.role = "DATA ENTRY OFFICER"
GROUP BY mr.data_entry
');
$sql->execute(array(
      ':examiner_number'=>$_SESSION['username'],
      ':tax'=>$tax,
      ':rate_value'=>$rate_value,
      ':marking_centre_code'=>$_SESSION['marking_centre_code'],
      ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name']
  ));
  $row = $sql->fetch(PDO::FETCH_ASSOC);
  $data_array['script_count'] = $row['no_of_scripts'] ?? '0';
  $data_array['rate'] = $row['data_entry_rate'] ?? '0';
  $data_array['gross_pay'] = $row['gross_pay'] ?? '0';
  $data_array['wht'] = $row['15_wnt'] ?? '0';
  $data_array['net_pay'] = $row['net_pay'] ?? '0';

  echo json_encode($data_array);
?>