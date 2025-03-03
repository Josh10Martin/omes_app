<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$sql = $db_9->prepare('SELECT ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name,ex.nrc AS nec,CONCAT(ex.title," ",ex.first_name," ",ex.last_name) AS full_name,null AS script_no,
                         CONCAT("\'",br.sortcode) AS sortcode, CONCAT("\'",ex.account_no) AS account_no,
                        
                        ((SELECT CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END AS no_of_scripts 
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject) 
                        WHERE e.subject_code =ex.subject_code
                        AND e.paper_no =ex.paper_no
                        AND e.marking_centre = ex.marking_centre
                        AND e.province = ex.province 
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1) * (CASE WHEN ex.role = "5" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END) /
                        (SELECT COUNT(DISTINCT(e.nrc))  AS no_of_examiners
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject) 
                        WHERE e.subject_code =ex.subject_code 
                        AND e.paper_no =ex.paper_no 
                        AND e.marking_centre =ex.marking_centre 
                        AND e.province = ex.province 
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1)) AS gross_pay,

                        (((SELECT CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END AS no_of_scripts 
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject) 
                        WHERE e.subject_code =ex.subject_code
                        AND e.paper_no =ex.paper_no
                        AND e.marking_centre = ex.marking_centre
                        AND e.province = ex.province 
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1) * (CASE WHEN ex.role = "5" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END) /
                        (SELECT COUNT(DISTINCT(e.nrc))  AS no_of_examiners
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject) 
                        WHERE e.subject_code =ex.subject_code 
                        AND e.paper_no =ex.paper_no 
                        AND e.marking_centre =ex.marking_centre 
                        AND e.province = ex.province 
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1)) * (15/100)) AS 15_wht,

                        ((SELECT CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END AS no_of_scripts 
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject) 
                        WHERE e.subject_code =ex.subject_code
                        AND e.paper_no =ex.paper_no
                        AND e.marking_centre = ex.marking_centre
                        AND e.province = ex.province 
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1) * (CASE WHEN ex.role = "5" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END) /
                        (SELECT COUNT(DISTINCT(e.nrc))  AS no_of_examiners
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject) 
                        WHERE e.subject_code =ex.subject_code 
                        AND e.paper_no =ex.paper_no 
                        AND e.marking_centre =ex.marking_centre 
                        AND e.province = ex.province 
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1)) - 

                        (((SELECT CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END AS no_of_scripts 
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject) 
                        WHERE e.subject_code =ex.subject_code
                        AND e.paper_no =ex.paper_no
                        AND e.marking_centre = ex.marking_centre
                        AND e.province = ex.province 
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1) * (CASE WHEN ex.role = "5" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END) /
                        (SELECT COUNT(DISTINCT(e.nrc))  AS no_of_examiners
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject) 
                        WHERE e.subject_code =ex.subject_code 
                        AND e.paper_no =ex.paper_no 
                        AND e.marking_centre =ex.marking_centre 
                        AND e.province = ex.province 
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1)) * (15/100)) AS net_pay,

                        b.name AS bank, br.name AS branch, su.subject_code AS subject_code, null AS subject_name, pa.paper_no AS paper_no,ex.belt_no AS belt_number, null AS belt_no
                        FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
                        INNER JOIN examiner ex ON (b.id = ex.bank)
                        INNER JOIN centre ce ON (ex.marking_centre = ce.centre_code)
                        INNER JOIN apportionment a ON (ce.centre_code = a.marking_centre)
                        INNER JOIN marking_rates mr ON (a.subject = mr.subject_code)
                        INNER JOIN subjects su ON (mr.subject_code = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        WHERE ex.branch = br.id
                        AND ex.paper_no = a.paper
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
                        AND ex.role IN ("4","5")
                        GROUP BY ce.centre_code, ce.centre_code,ce.name, ex.nrc,ex.title,ex.first_name,ex.last_name,ex.role,br.sortcode,ex.account_no,mr.chief_examiner,mr.deputy_c_examiner,b.name,br.name,su.subject_code,pa.paper_no,ex.belt_no,ex.province

                        UNION

                        SELECT ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name, ex.nrc AS nrc, CONCAT(ex.title," ",ex.first_name," ",ex.last_name) AS full_name,SUM(a.script_no) AS script_no,
                        CONCAT("\'",br.sortcode) AS sortcode, CONCAT("\'",ex.account_no) AS account_no,

                        ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (CASE WHEN ex.role = "3" THEN mr.t_leader ELSE mr.examiner END) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND province = ex.province AND role IN ("1","3"))) AS gross_pay,

                        ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (CASE WHEN ex.role = "3" THEN mr.t_leader ELSE mr.examiner END) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND province = ex.province AND role IN ("1","3")) * (15/100)) AS 15_wht, 
                        ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (CASE WHEN ex.role = "3" THEN mr.t_leader ELSE mr.examiner END) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND province = ex.province AND role IN ("1","3")) - (SUM(a.script_no) * (CASE WHEN ex.role = "3" THEN mr.t_leader ELSE mr.examiner END) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND province = ex.province AND role IN ("1","3"))) * (15/100)) AS net_pay,

                        b.name AS bank, br.name AS branch, su.subject_code AS subject_code, null AS subject_name, pa.paper_no AS paper_no,ex.belt_no AS belt_number, null AS belt_no
                        FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
                        INNER JOIN examiner ex ON (b.id = ex.bank)
                        INNER JOIN centre ce ON (ex.marking_centre = ce.centre_code)
                        INNER JOIN apportionment a ON (ce.centre_code = a.marking_centre)
                        INNER JOIN marking_rates mr ON (a.subject = mr.subject_code)
                        INNER JOIN subjects su ON (mr.subject_code = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        WHERE ex.branch = br.id
                        AND ex.paper_no = a.paper
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
                        AND ex.role IN ("1","3")
                        GROUP BY ce.centre_code, ce.centre_code,ce.name, ex.nrc,ex.title,ex.first_name,ex.last_name,ex.role,br.sortcode,ex.account_no,mr.t_leader,mr.examiner,b.name,br.name,su.subject_code,pa.paper_no,ex.belt_no,ex.province

                        UNION

                        SELECT ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name, ex.nrc AS nrc, CONCAT(ex.title," ",ex.first_name," ",ex.last_name) AS full_name,SUM(a.script_no) AS script_no,
                        CONCAT("\'",br.sortcode) AS sortcode, CONCAT("\'",ex.account_no) AS account_no,

                        ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (mr.checker)) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND province = ex.province AND role IN ("1","3")) AS gross_pay,

                       ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (mr.checker) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND province = ex.province AND role IN ("1","3")) * (15/100)) AS 15_wht, 

                        ((CASE WHEN SUM(a.script_no) = 0 THEN 0 WHEN SUM(a.script_no) < 100 THEN 100 ELSE SUM(a.script_no) END) * (mr.checker) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND province = ex.province AND role IN ("1","3"))) - (SUM(a.script_no) * (mr.checker) / (SELECT COUNT(*) FROM examiner WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no AND belt_no = ex.belt_no AND marking_centre = ex.marking_centre AND province = ex.province AND role IN ("1","3"))) * (15/100) AS net_pay,

                        b.name AS bank, br.name AS branch, su.subject_code AS subject_code, null AS subject_name, pa.paper_no AS paper_no,ex.belt_no AS belt_number, null AS belt_no
                        FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
                        INNER JOIN examiner ex ON (b.id = ex.bank)
                        INNER JOIN centre ce ON (ex.marking_centre = ce.centre_code)
                        INNER JOIN apportionment a ON (ce.centre_code = a.marking_centre)
                        INNER JOIN marking_rates mr ON (a.subject = mr.subject_code)
                        INNER JOIN subjects su ON (mr.subject_code = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        WHERE ex.branch = br.id
                        AND ex.paper_no = a.paper
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
                        AND ex.role = 2
                        GROUP BY ce.centre_code, ce.name, ex.nrc,ex.title,ex.first_name,ex.last_name,br.sortcode,ex.account_no,mr.checker,b.name,br.name,su.subject_code,pa.paper_no,ex.belt_no,ex.province
                       
                        UNION

                        
                        SELECT ce.centre_code AS marking_centre_code, ce.name AS marking_centre_name, u.nrc AS nrc, CONCAT(u.first_name," ",u.last_name) AS full_name, null AS script_no, CONCAT("\'",br.sortcode) AS sortcode, CONCAT("\'",u.account_no) AS account_no,
                        (((SELECT SUM(a.script_no) AS no_of_scripts
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject)
                        AND e.marking_centre =ex.marking_centre
                        AND e.province = ex.province
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1) * (mr.sys_admin)) /
                       (SELECT COUNT(DISTINCT(e.nrc))  AS no_of_examiners
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject)
                        AND e.marking_centre =ex.marking_centre
                        AND e.province = ex.province
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1)) AS gross_pay,

                        ((((SELECT SUM(a.script_no) AS no_of_scripts
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject)
                        AND e.marking_centre =ex.marking_centre
                        AND e.province = ex.province
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1) * (mr.sys_admin)) /
                       (SELECT COUNT(DISTINCT(e.nrc))  AS no_of_examiners
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject)
                        AND e.marking_centre =ex.marking_centre
                        AND e.province = ex.province
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1)) * (15/100)) AS 15_wht,

                        (((SELECT SUM(a.script_no) AS no_of_scripts
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject)
                        AND e.marking_centre =ex.marking_centre
                        AND e.province = ex.province
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1) * (mr.sys_admin)) /
                       (SELECT COUNT(DISTINCT(e.nrc))  AS no_of_examiners
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject)
                        AND e.marking_centre =ex.marking_centre
                        AND e.province = ex.province
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1)) -
                        (((((SELECT SUM(a.script_no) AS no_of_scripts
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject)
                        AND e.marking_centre =ex.marking_centre
                        AND e.province = ex.province
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1) * (mr.sys_admin)) /
                       (SELECT COUNT(DISTINCT(e.nrc))  AS no_of_examiners
                        FROM examiner e INNER JOIN apportionment a ON (e.subject_code = a.subject)
                        AND e.marking_centre =ex.marking_centre
                        AND e.province = ex.province
                        AND e.role IN ("1","3") 
                        AND e.paper_no = a.paper 
                        AND e.marking_centre = a.marking_centre 
                        AND e.province = a.province 
                        AND e.belt_no = a.belt_no
                        GROUP BY a.subject,a.paper,a.belt_no
                        ORDER BY SUM(a.script_no) DESC LIMIT 1)) * (15/100))) AS net_pay,

                        b.name AS bank,br.name AS branch, null AS subject_code,null AS subject_name,null AS paper_no, "S/ADMIN" AS belt_number,null AS belt_no
                        FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
                        INNER JOIN users u ON (b.id = u.bank)
                        INNER JOIN centre ce ON (u.marking_centre = ce.centre_code)
                        INNER JOIN apportionment a ON (ce.centre_code = a.marking_centre)
                        INNER JOIN marking_rates mr ON (a.subject = mr.subject_code)
                        INNER JOIN examiner ex ON (mr.subject_code = ex.subject_code)
                        WHERE a.paper = mr.paper_no
                        AND a.paper = ex.paper_no
                        AND a.subject = ex.subject_code
                        AND ex.marking_centre = ce.centre_code
                        AND u.branch = br.id
                        AND u.province = a.province
                        AND u.marking_centre = a.marking_centre
                        AND a.marking_centre = ex.marking_centre
                        AND a.province =ex.province
                        AND u.user_type = "ADMIN"
                        AND u.username = LEFT(a.username,LOCATE(" ",a.username) -1)
                        GROUP BY ce.centre_code, ce.name, u.first_name,u.last_name,b.name,br.name,br.sortcode,u.account_no,u.nrc,mr.sys_admin,ex.province
                        
                        UNION

                        SELECT ce.centre_code AS marking_centre_code, ce.name AS marking_centre_name, u.nrc AS nrc, CONCAT(u.first_name," ",u.last_name) AS full_name,SUM(m.status <> "L") AS script_no,  CONCAT("\'",br.sortcode) AS sortcode, CONCAT("\'",u.account_no) AS account_no, 
                        SUM(m.status <> "L") * mr.data_entry AS gross_pay, (SUM(m.status <> "L") * mr.data_entry) * (15/100) AS 15_wht, (SUM(m.status <> "L") * mr.data_entry) - (SUM(m.status <> "L") * mr.data_entry) * (15/100) AS net_pay, 
                        b.name AS bank,br.name AS branch, su.subject_code AS subject_code,su.subject_name AS subject_name,pa.paper_no AS paper_no, "D/E" AS belt_number,null AS belt_no
                        
                        FROM bankbranch br INNER JOIN bank b ON (br.bank_id = b.id)
                        INNER JOIN users u ON (b.id = u.bank)
                        INNER JOIN centre ce ON (u.marking_centre = ce.centre_code)
                        INNER JOIN marks m ON (ce.centre_code = m.marking_centre)
                        INNER JOIN marking_rates mr ON (m.subject_code = mr.subject_code)
                        INNER JOIN subjects su ON (mr.subject_code = su.subject_code)
                        INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                        WHERE m.paper_no = mr.paper_no
                        AND mr.paper_no = pa.paper_no
                        AND m.subject_code = su.subject_code
                        AND m.paper_no = pa.paper_no
                        AND m.marking_centre = u.marking_centre
                        AND u.branch = br.id
                        AND u.province = m.province
                        AND u.user_type = "DEO"
                        AND u.username = LEFT(m.entered_by,LOCATE(" ",m.entered_by) -1)
                        GROUP BY ce.centre_code, ce.name, u.first_name,u.last_name,b.name,br.name,br.sortcode,u.account_no,u.nrc,mr.data_entry,su.subject_code,su.subject_name,pa.paper_no
                        ');
$sql->execute();
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                $data_array[$i]['payee_full_name'] = $row['full_name'] ?? '';
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