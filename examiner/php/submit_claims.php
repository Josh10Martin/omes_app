<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
// header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax =15/100;

if(isset($_POST['subject']) && isset($_POST['paper'])){

        $subject_code = explode(':',$_POST['subject'])[0];
        $subject_name = explode(':',$_POST['subject'])[1];
        $paper_no = $_POST['paper'];
        try{
        $sql = $db_12_gce->prepare(' REPLACE INTO examiner_claim (marking_centre_code,marking_centre_name,nrc,examiner_number,tpin,full_name,address,province,district,position,no_of_scripts,sortcode,account_no,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,bank,branch,subject_code,subject_name,paper_no,belt_no,session_name)
        WITH highest_claim AS(
                SELECT COUNT(ex.examiner_number) AS no_of_examiners, ga.no_of_scripts AS no_of_scripts,ga.belt_no AS belt_no FROM group_apportion ga
                INNER JOIN examiner ex ON (ga.subject = ex.subject_code)
                WHERE ga.paper = ex.paper_no
                AND ex.belt_no = ga.belt_no
                AND ex.attendance = 1
                AND ga.marking_centre = ex.marking_centre
                AND ga.subject =:subject_code 
                AND ga.paper =:paper_no
                AND ga.marking_centre =:marking_centre_code
                AND ex.role IN ("EXAMINER","TEAM LEADER")
                GROUP BY ga.no_of_scripts,ga.belt_no
                )
        
                        

                        SELECT :marking_centre_code AS marking_centre_code, :marking_centre_name AS marking_centre_name,ex.nrc AS nrc, ex.examiner_number AS examiner_number, ex.tpin AS tpin,CONCAT(ex.first_name," ",ex.last_name) AS full_name,ex.address AS address,ex.province AS province,ex.district AS district,ex.role AS position, (
                                
                                SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim
                                ORDER BY no_of_scripts_marked DESC LIMIT 1
                        ) AS no_of_scripts,
                        ex.sortcode AS sortcode,ex.account_no AS account_no, 
                        
                        CASE WHEN ex.role ="CHIEF EXAMINER" THEN mr.chief_examiner ELSE mr.deputy_c_examiner END AS net_rate,
                        CASE WHEN ex.role ="CHIEF EXAMINER" THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END AS grossed_up_rate,
                             (
                                SELECT (CASE WHEN no_of_scripts < 100 THEN 100 ELSE no_of_scripts END) / no_of_examiners AS no_of_scripts_marked FROM highest_claim
                                ORDER BY no_of_scripts_marked DESC LIMIT 1
                             ) * (CASE WHEN ex.role = "CHIEF EXAMINER" THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
                        ) AS gross_pay,
                        (
                                SELECT (CASE WHEN no_of_scripts < 100 THEN 100 ELSE no_of_scripts END) / no_of_examiners AS no_of_scripts_marked FROM highest_claim
                                ORDER BY no_of_scripts_marked DESC LIMIT 1
                             ) * (CASE WHEN ex.role = "CHIEF EXAMINER" THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
                        ) * :tax AS 15_wht,
                        ((
                                SELECT (CASE WHEN no_of_scripts < 100 THEN 100 ELSE no_of_scripts END) / no_of_examiners AS no_of_scripts_marked FROM highest_claim
                                ORDER BY no_of_scripts_marked DESC LIMIT 1
                             ) * (CASE WHEN ex.role = "CHIEF EXAMINER" THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
                        )) -
                        (
                                (
                                        SELECT (CASE WHEN no_of_scripts < 100 THEN 100 ELSE no_of_scripts END) / no_of_examiners AS no_of_scripts_marked FROM highest_claim
                                        ORDER BY no_of_scripts_marked DESC LIMIT 1
                                     ) * (CASE WHEN ex.role = "CHIEF EXAMINER" THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
                                ) * :tax
                        ) AS net_pay,

                        ex.bank AS bank,ex.branch AS branch,:subject_code AS subject_code,:subject_name AS subject_name,:paper_no AS paper_no,ex.belt_no AS belt_no,CONCAT(:session_year," ",:session_name) AS session_name
                        FROM examiner ex INNER JOIN marking_rates mr ON (ex.subject_code = mr.subject_code)
                        RIGHT OUTER JOIN group_apportion ga ON (mr.subject_code = ga.subject)
                        WHERE ex.subject_code = ga.subject
                        AND ex.paper_no = ga.paper
                        AND ex.paper_no = mr.paper_no
                        AND ga.paper = mr.paper_no
                        AND ex.marking_centre = ga.marking_centre
                        AND mr.paper_no = ga.paper
                        AND ex.subject_code =:subject_code
                        AND ex.paper_no =:paper_no
                        AND ex.marking_centre =:marking_centre_code
                        AND ex.attendance = 1
                        AND ex.role IN ("DEPUTY CHIEF EXAMINER","CHIEF EXAMINER")
                        GROUP BY ex.nrc,ex.examiner_number,ex.tpin,ex.role,ex.address,ex.district,ex.province, ex.first_name,ex.last_name,mr.chief_examiner,mr.deputy_c_examiner,ex.account_no,ex.bank,ex.branch,ex.sortcode
                       
                       UNION

                        SELECT :marking_centre_code AS marking_centre_code,:marking_centre_name AS marking_centre_name, ex.nrc AS nrc,ex.examiner_number AS examiner_number,ex.tpin AS tpin, CONCAT(ex.first_name," ",ex.last_name) AS full_name,ex.address AS address,ex.province AS province,ex.district AS district,ex.role AS position,ga.no_of_scripts AS script_no,
                        ex.sortcode AS sortcode, ex.account_no AS account_no,
                        
                        CASE WHEN ex.role ="TEAM LEADER" THEN mr.t_leader WHEN ex.role ="CHECKER" THEN mr.checker ELSE mr.examiner END AS net_rate,
                        CASE WHEN ex.role ="TEAM LEADER" THEN mr.t_leader * :rate_value WHEN ex.role ="CHECKER" THEN mr.checker * :rate_value ELSE mr.examiner * :rate_value END AS grossed_up_rate,

                        ((CASE WHEN ga.no_of_scripts = 0 THEN 0 WHEN ga.no_of_scripts < 100 THEN 100 ELSE ga.no_of_scripts END) * (CASE WHEN ex.role = "TEAM LEADER" THEN mr.t_leader * :rate_value  WHEN ex.role = "CHECKER" THEN mr.checker * :rate_value ELSE mr.examiner * :rate_value END) / (SELECT COUNT(*) FROM examiner WHERE subject_code =:subject_code AND paper_no =:paper_no AND belt_no = ex.belt_no AND marking_centre =:marking_centre_code AND attendance = 1 AND role IN ("EXAMINER","TEAM LEADER"))) AS gross_pay,

                        ((CASE WHEN ga.no_of_scripts = 0 THEN 0 WHEN ga.no_of_scripts < 100 THEN 100 ELSE ga.no_of_scripts END) * (CASE WHEN ex.role = "TEAM LEADER" THEN mr.t_leader * :rate_value  WHEN ex.role = "CHECKER" THEN mr.checker * :rate_value ELSE mr.examiner * :rate_value END) / (SELECT COUNT(*) FROM examiner WHERE subject_code =:subject_code AND paper_no =:paper_no AND belt_no = ex.belt_no AND marking_centre =:marking_centre_code AND attendance = 1 AND role IN ("EXAMINER","TEAM LEADER")) * :tax) AS 15_wht, 
                        ((CASE WHEN ga.no_of_scripts = 0 THEN 0 WHEN ga.no_of_scripts < 100 THEN 100 ELSE ga.no_of_scripts END) * (CASE WHEN ex.role = "TEAM LEADER" THEN mr.t_leader * :rate_value  WHEN ex.role = "CHECKER" THEN mr.checker * :rate_value ELSE mr.examiner * :rate_value END) / (SELECT COUNT(*) FROM examiner WHERE subject_code =:subject_code AND paper_no =:paper_no AND belt_no = ex.belt_no AND marking_centre =:marking_centre_code AND attendance = 1 AND role IN ("EXAMINER","TEAM LEADER")) - ((CASE WHEN ga.no_of_scripts = 0 THEN 0 WHEN ga.no_of_scripts < 100 THEN 100 ELSE ga.no_of_scripts END) * (CASE WHEN ex.role = "TEAM LEADER" THEN mr.t_leader * :rate_value  WHEN ex.role = "CHECKER" THEN mr.checker * :rate_value ELSE mr.examiner * :rate_value END) / (SELECT COUNT(*) FROM examiner WHERE subject_code =:subject_code AND paper_no =:paper_no AND belt_no = ex.belt_no AND marking_centre =:marking_centre_code AND attendance = 1 AND role IN ("EXAMINER","TEAM LEADER"))) * :tax) AS net_pay,

                        ex.bank AS bank, ex.branch AS branch, :subject_code AS subject_code, :subject_name AS subject_name, :paper_no AS paper_no,ex.belt_no AS belt_number,CONCAT(:session_year," ",:session_name) AS session_name
                        FROM examiner ex INNER JOIN group_apportion ga ON (ex.subject_code = ga.subject)
                        INNER JOIN marking_rates mr ON (ga.subject = mr.subject_code)
                        WHERE ex.paper_no = ga.paper
                        AND ex.belt_no = ga.belt_no
                        AND ex.subject_code = mr.subject_code
                        AND ex.paper_no = mr.paper_no
                        AND ex.marking_centre = ga.marking_centre
                        AND ga.paper = mr.paper_no
                        AND ex.subject_code =:subject_code
                        AND ex.paper_no =:paper_no
                        AND ex.marking_centre =:marking_centre_code
                        AND ex.attendance = 1
                        AND ex.role IN ("EXAMINER","TEAM LEADER","CHECKER")
                        GROUP BY ex.nrc,ex.examiner_number,ex.tpin,ex.first_name,ex.last_name,ex.role,ex.address,ga.no_of_scripts,ex.province,ex.district,ex.sortcode,ex.account_no,mr.t_leader,mr.examiner,mr.checker,ex.bank,ex.branch,ex.belt_no

                       ');
$sql->execute(array(
        ':subject_code'=>$subject_code,
        ':subject_name'=>$subject_name,
        ':paper_no'=>$paper_no,
        ':rate_value'=>$rate_value,
        ':tax'=>$tax,
        ':session_year'=>$_SESSION['session_year'],
        ':session_name'=>$_SESSION['session_name'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':marking_centre_name'=>$_SESSION['marking_centre']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Successfully submitted claims';
       

}else{
        $data_array['status'] = '400';
}
        }catch(PDOException $e){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Subject and paper not set';
}
echo json_encode($data_array);
?>