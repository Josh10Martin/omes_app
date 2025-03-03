<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../../config.php';
$data_array = array();
$sql = $db_12_gce->prepare('SELECT DISTINCT(ex.nrc) AS nrc, ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name, ex.examiner_number AS examiner_number, ex.tpin AS tpin,ex.role AS position, CONCAT(ex.first_name," ",ex.last_name) AS full_name, SUM(a.script_no) AS script_no,
                        ex.account_no AS account_no, CASE WHEN ex.role = "CHIEF EXAMINER" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END AS paper_rate, 
                        (
                                SELECT no_of_scripts FROM group_apportion
                                WHERE subject =e.subject_code AND paper =e.paper_no
                                AND marking_centre =e.marking_centre
                                ORDER BY no_of_scripts DESC LIMIT 1
                                ) * (CASE WHEN ex.role = "CHIEF EXAMINER" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END) / 

                                (
                                SELECT COUNT(*) FROM examiner
                                WHERE subject_code =e.subject_code AND paper_no =e.paper_no
                                AND marking_centre =e.marking_centre
                                AND role IN ("EXAMINER","TEAM LEADER")
                                AND belt_no = (SELECT belt_no FROM group_apportion
                                WHERE subject =e.subject_code AND paper =e.paper_no 
                                AND marking_centre =e.marking_centre
                                ORDER BY no_of_scripts DESC LIMIT 1
                                )
                        ) AS gross_pay,
                        (
                                SELECT no_of_scripts FROM group_apportion
                                WHERE subject =e.subject_code AND paper =e.paper_no
                                AND marking_centre =e.marking_centre
                                ORDER BY no_of_scripts DESC LIMIT 1
                                ) * (CASE WHEN ex.role = "CHIEF EXAMINER" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END) / 

                                (
                                SELECT COUNT(*) FROM examiner
                                WHERE subject_code =e.subject_code AND paper_no =e.paper_no
                                AND marking_centre =e.marking_centre
                                AND role IN ("EXAMINER","TEAM LEADER")
                                AND belt_no = (SELECT belt_no FROM group_apportion
                                WHERE subject =e.subject_code AND paper =e.paper_no 
                                AND marking_centre =e.marking_centre
                                ORDER BY no_of_scripts DESC LIMIT 1
                                )
                        ) * (15/100) AS 15_wht,
                        (
                                SELECT no_of_scripts FROM group_apportion
                                WHERE subject =e.subject_code AND paper =e.paper_no
                                AND marking_centre =e.marking_centre
                                ORDER BY no_of_scripts DESC LIMIT 1
                                ) * (CASE WHEN ex.role = "CHIEF EXAMINER" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END) / 

                                (
                                SELECT COUNT(*) FROM examiner
                                WHERE subject_code =e.subject_code AND paper_no =e.paper_no
                                AND marking_centre =e.marking_centre
                                AND role IN ("EXAMINER","TEAM LEADER")
                                AND belt_no = (SELECT belt_no FROM group_apportion
                                WHERE subject =e.subject_code AND paper =e.paper_no 
                                AND marking_centre =e.marking_centre
                                ORDER BY no_of_scripts DESC LIMIT 1
                                )
                        ) - 
                        (
                                (
                                SELECT no_of_scripts FROM group_apportion
                                WHERE subject =e.subject_code AND paper =e.paper_no
                                AND marking_centre =e.marking_centre
                                ORDER BY no_of_scripts DESC LIMIT 1
                                ) * (CASE WHEN ex.role = "CHIEF EXAMINER" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END) / 

                                (
                                SELECT COUNT(*) FROM examiner
                                WHERE subject_code =e.subject_code AND paper_no =e.paper_no
                                AND marking_centre =e.marking_centre
                                AND role IN ("EXAMINER","TEAM LEADER")
                                AND belt_no = (SELECT belt_no FROM group_apportion
                                WHERE subject =e.subject_code AND paper =e.paper_no 
                                AND marking_centre =e.marking_centre
                                ORDER BY no_of_scripts DESC LIMIT 1
                                )
                        ) * (15/100)
                        ) AS net_pay,

                        ex.bank AS bank,ex.branch AS branch
                        FROM centre ce INNER JOIN examiner ex ON (ce.centre_code = ex.marking_centre)
                        INNER JOIN marking_rates mr ON (ex.subject_code = mr.subject_code)
                        INNER JOIN subjects su ON (mr.subject_code = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        RIGHT OUTER JOIN apportionment a ON (pa.paper_no = a.paper)
                        WHERE ex.subject_code = a.subject
                        AND ex.paper_no = a.paper
                        AND ex.paper_no = mr.paper_no
                        AND a.paper = mr.paper_no
                        AND ex.marking_centre = a.marking_centre
                        AND mr.paper_no = pa.paper_no
                        AND mr.subject_code = a.subject
                        AND mr.paper_no = a.paper
                        AND ex.attendance = "1"
                        AND a.subject = su.subject_code
                        AND a.paper =pa.paper_no
                        AND ex.role IN ("DEPUTY CHIEF EXAMINER","CHIEF EXAMINER")
                        AND a.marking_centre = ex.marking_centre
                        GROUP BY ce.centre_code,ce.name,ex.nrc,ex.examiner_number,ex.tpin,ex.role,ex.district,ex.province, ex.first_name,ex.last_name,mr.chief_examiner,ex.role,mr.deputy_c_examiner,ex.subject_code,ex.paper_no,ex.nrc,ex.account_no,ex.bank,ex.branch
                       ');
$sql->execute();
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['examiner_number'] = $row['examiner_number'] ?? '';
                $data_array[$i]['tpin'] = $row['tpin'] ?? '';
                $data_array[$i]['position'] = $row['position'] ?? '';
                $data_array[$i]['province'] = $row['province'] ?? '';
                $data_array[$i]['district'] = $row['district'] ?? '';
                $data_array[$i]['payee_full_name'] = $row['full_name'] ?? '';
                $data_array[$i]['payee_address'] = $row['address'] ?? '';
                $data_array[$i]['sortcode'] = $row['sortcode'] ?? '';
                $data_array[$i]['account_no'] = $row['account_no'] ?? '';
                $data_array[$i]['gross_pay'] = number_format((float)$row['gross_pay'],2,'.','') ?? '';
                $data_array[$i]['15_wht'] = number_format((float)$row['15_wht'],2,'.','') ?? '';
                $data_array[$i]['net_pay'] = number_format((float)$row['net_pay'],2,'.','') ?? '';
                $data_array[$i]['bank'] = $row['bank'] ?? '';
                $data_array[$i]['branch'] = $row['branch'] ?? '';
                $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                $data_array[$i]['belt_no'] = $row['belt_number'] ?? '';
                $i++;
        }

}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>