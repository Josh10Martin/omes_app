<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');

include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;
if($_SESSION['user_type'] == 'ADMIN'){
      $sql = $db_9->prepare('
      WITH highest_script_count AS (
          SELECT MAX(ga.no_of_scripts) AS max_no_of_scripts,COUNT(ex.nrc) AS no_of_examiners,ex.belt_no AS belt_no,ex.subject_code AS subject_code,su.subject_name AS subject_name,ex.paper_no AS paper_no FROM group_apportion ga
          INNER JOIN examiner ex ON (ga.marking_centre = ex.marking_centre)
          INNER JOIN subjects su ON (ex.subject_code = su.subject_code)
          WHERE ga.marking_centre = :marking_centre_code
          AND ga.subject = ex.subject_code
          AND ga.subject = su.subject_code
          AND ga.paper = ex.paper_no
          AND ga.belt_no = ex.belt_no
          AND ex.role IN ("1","3")
          GROUP BY ex.subject_code,ex.paper_no,ex.belt_no
          ORDER BY MAX(ga.no_of_scripts) DESC LIMIT 1
      )
      
      SELECT CONCAT(hsc.subject_name," PAPER ",hsc.paper_no) AS subject_paper,hsc.max_no_of_scripts AS max_no_of_scripts,hsc.belt_no AS belt_no,hsc.no_of_examiners AS no_of_examiners,

     
      ( 
      SELECT 
      (max_no_of_scripts * (mr.sys_admin * :rate_value)) / no_of_examiners
  FROM 
      highest_script_count
      ) AS gross_pay,
      (SELECT 
      (max_no_of_scripts * (mr.sys_admin * :rate_value)) / no_of_examiners
  FROM 
      highest_script_count) * (15/100) AS 15_wht,
      (SELECT 
      (max_no_of_scripts * (mr.sys_admin * :rate_value)) / no_of_examiners
  FROM 
      highest_script_count) - 
      (SELECT 
      (max_no_of_scripts * (mr.sys_admin * :rate_value)) / no_of_examiners
  FROM 
      highest_script_count) * (15/100) AS net_pay,
  
      mr.sys_admin * :rate_value AS system_admin_rate
      FROM users u INNER JOIN group_apportion g ON (u.marking_centre = g.marking_centre)
      INNER JOIN marking_rates mr ON (g.subject = mr.subject_code)
      INNER JOIN highest_script_count hsc ON hsc.subject_code = g.subject
      WHERE g.paper = mr.paper_no
      
      AND u.province = g.province
      AND g.marking_centre =:marking_centre_code
      AND g.province =:province_code
      AND u.username = LEFT(g.username,LOCATE(" ",g.username) -1)
      AND g.username =:username
      AND u.user_type = "ADMIN"
      AND hsc.paper_no = g.paper
      GROUP BY mr.sys_admin,hsc.subject_name,hsc.paper_no,hsc.max_no_of_scripts,hsc.belt_no,hsc.no_of_examiners');
      $sql->execute(array(
            ':marking_centre_code'=>$_SESSION['marking_centre_code'],
            ':province_code'=>$_SESSION['province_code'],
            ':rate_value'=>$rate_value,
            ':tax'=>$tax,
            ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name']
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array['highest_script_count'] = $row['max_no_of_scripts'] ?? '0';
        $data_array['subject_paper'] = $row['subject_paper'] ?? 'N/A';
        $data_array['belt_no'] = $row['belt_no'] ?? 'N/A';
        $data_array['no_of_examiners'] = $row['no_of_examiners'] ?? '0';
        $data_array['rate'] = $row['system_admin_rate'] ?? '0';
        $data_array['gross'] =  number_format((float)$row['gross_pay'],2,'.','') ?? '0';
        $data_array['wht'] = number_format((float)$row['15_wht'],2,'.','') ?? '0';
        $data_array['net'] =  number_format((float)$row['net_pay'],2,'.','') ?? '0';;
}

echo json_encode($data_array);
?>