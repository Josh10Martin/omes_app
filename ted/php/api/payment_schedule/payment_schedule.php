<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$sql = $db_12_gce->prepare('SELECT ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name, ex.nrc AS nrc,ex.examiner_number AS examiner_number,ex.tpin AS tpin, CONCAT(ex.first_name," ",ex.last_name) AS full_name,ex.address AS address,ex.province AS province,ex.district AS district,ex.role AS position,SUM(a.script_no)  AS script_no,
                        CONCAT("\'",ex.sortcode) AS sortcode, CONCAT("\'",ex.account_no) AS account_no,

                        ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (CASE WHEN ex.role = "TEAM LEADER" THEN mr.t_leader  WHEN ex.role = "CHECKER" THEN mr.checker ELSE mr.examiner END) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND role IN ("EXAMINER","TEAM LEADER"))) AS gross_pay,

                        ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (CASE WHEN ex.role = "TEAM LEADER" THEN mr.t_leader  WHEN ex.role = "CHECKER" THEN mr.checker ELSE mr.examiner END) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND role IN ("EXAMINER","TEAM LEADER")) * (15/100)) AS 15_wht, 
                        ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (CASE WHEN ex.role = "TEAM LEADER" THEN mr.t_leader  WHEN ex.role = "CHECKER" THEN mr.checker ELSE mr.examiner END) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND role IN ("EXAMINER","TEAM LEADER")) - ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (CASE WHEN ex.role = "TEAM LEADER" THEN mr.t_leader  WHEN ex.role = "CHECKER" THEN mr.checker ELSE mr.examiner END) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND role IN ("EXAMINER","TEAM LEADER"))) * (15/100)) AS net_pay,

                        ex.bank AS bank, ex.branch AS branch, su.subject_code AS subject_code, null AS subject_name, pa.paper_no AS paper_no,ex.belt_no AS belt_number, null AS belt_no
                        FROM examiner ex INNER JOIN centre ce ON (ex.marking_centre = ce.centre_code)
                        INNER JOIN apportionment a ON (ce.centre_code = a.marking_centre)
                        INNER JOIN marking_rates mr ON (a.subject = mr.subject_code)
                        INNER JOIN subjects su ON (mr.subject_code = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        WHERE ex.paper_no = a.paper
                        AND ex.belt_no = a.belt_no
                        AND ex.subject_code = mr.subject_code
                        AND ex.paper_no = mr.paper_no
                        AND ex.subject_code = su.subject_code
                        AND ex.subject_code = pa.subject_code
                        AND ex.subject_code = a.subject
                        AND ex.paper_no = pa.paper_no
                        AND a.paper = mr.paper_no
                        AND a.subject = su.subject_code
                        AND a.subject = pa.subject_code
                        AND a.paper = pa.paper_no
                        AND mr.subject_code = pa.subject_code
                        AND mr.paper_no = pa.paper_no
                        AND ex.attendance = 1
                        AND ex.role IN ("EXAMINER","TEAM LEADER","CHECKER")
                        GROUP BY ce.centre_code, ce.centre_code,ce.name, ex.nrc,ex.examiner_number,ex.tpin,ex.first_name,ex.last_name,ex.role,ex.address,ex.province,ex.district,ex.sortcode,ex.account_no,mr.t_leader,mr.examiner,mr.checker,ex.bank,ex.branch,su.subject_code,pa.paper_no,ex.belt_no

                        
                        UNION
                        
                        SELECT ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name, ex.nrc AS nrc, ex.examiner_number AS examiner_number,ex.tpin AS tpin,CONCAT(ex.first_name," ",ex.last_name) AS full_name,ex.address AS address,ex.province AS province,ex.district AS district,ex.role AS position,SUM(m.status <> "L") AS script_no,  CONCAT("\'",ex.sortcode) AS sortcode, CONCAT("\'",ex.account_no) AS account_no, 
                        SUM(m.status <> "L") * mr.data_entry AS gross_pay, (SUM(m.status <> "L") * mr.data_entry) * (15/100) AS 15_wht, (SUM(m.status <> "L") * mr.data_entry) - (SUM(m.status <> "L") * mr.data_entry) * (15/100) AS net_pay, 
                        ex.bank AS bank,ex.branch AS branch, su.subject_code AS subject_code,su.subject_name AS subject_name,pa.paper_no AS paper_no, "D/E" AS belt_number,null AS belt_no
                        
                        FROM  examiner ex INNER JOIN centre ce ON (ex.marking_centre =ce.centre_code)
                        INNER JOIN marks m ON (ce.centre_code = m.marking_centre)
                        INNER JOIN marking_rates mr ON (m.subject_code = mr.subject_code)
                        INNER JOIN subjects su ON (mr.subject_code = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        WHERE m.paper_no = mr.paper_no
                        AND mr.paper_no = pa.paper_no
                        AND m.subject_code = su.subject_code
                        AND ex.marking_centre = m.marking_centre
                        AND m.paper_no = pa.paper_no
                        AND ex.role ="DATA ENTRY OPERATOR"
                        AND ex.examiner_number = LEFT(m.entered_by,LOCATE(" ",m.entered_by) -1)
                        GROUP BY ce.centre_code, ce.name, ex.examiner_number,ex.tpin,ex.first_name,ex.last_name,ex.address,ex.province,ex.district,ex.role,ex.bank,ex.branch,ex.sortcode,ex.account_no,ex.nrc,mr.data_entry,su.subject_code,su.subject_name,pa.paper_no
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
                $data_array[$i]['gross_pay'] = "'".number_format((float)$row['gross_pay'],2,'.','') ?? '';
                $data_array[$i]['15_wht'] = "'".number_format((float)$row['15_wht'],2,'.','') ?? '';
                $data_array[$i]['net_pay'] = "'".number_format((float)$row['net_pay'],2,'.','') ?? '';
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