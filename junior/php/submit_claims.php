<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
// header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;
$session_type = $_SESSION['session_type'] == 'I' ? 'INTERNAL' : 'EXTERNAL';
if(isset($_SESSION['marking_centre_code'])){

        try{
        $sql = $db_9->prepare(' REPLACE INTO examiner_claim (marking_centre_code,marking_centre_name,nrc,tpin,full_name,address,province,position,no_of_scripts,sortcode,account_no,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,bank,branch,subject_code,subject_name,paper_no,belt_no,session_name)
        WITH highest_claim AS(
                SELECT COUNT(ex.nrc) AS no_of_examiners, ex.marking_centre AS marking_centre, ex.subject_code AS subject_code,ex.paper_no AS paper_no, ga.no_of_scripts AS no_of_scripts,ga.belt_no AS belt_no 
                FROM group_apportion ga
                INNER JOIN examiner ex ON (ga.subject = ex.subject_code)
                WHERE ga.paper = ex.paper_no
                AND ex.belt_no = ga.belt_no
                AND ga.marking_centre = ex.marking_centre
                AND ex.province =ga.province

                AND ga.marking_centre =:marking_centre_code
                AND ex.role IN (1, 3)
                GROUP BY ga.no_of_scripts,ga.belt_no,ex.subject_code,ex.paper_no,ex.marking_centre
                ),
                examiners_belt AS (
                       SELECT CASE WHEN g.no_of_scripts = 0 THEN 0 WHEN g.no_of_scripts < 100 THEN 100 ELSE g.no_of_scripts END AS no_of_scripts, COUNT(ex.nrc) AS no_of_examiners, ex.subject_code AS subject_code,ex.paper_no AS paper_no, ex.belt_no AS belt_no
             FROM group_apportion g
            INNER JOIN examiner ex ON (g.subject = ex.subject_code)
            WHERE g.paper = ex.paper_no
            AND g.marking_centre = ex.marking_centre
            AND g.belt_no = ex.belt_no

            AND ex.marking_centre =:marking_centre_code
            AND ex.role IN ("1","3")
            GROUP BY g.no_of_scripts,ex.subject_code,ex.paper_no,ex.belt_no
                        )
        
                        

                        SELECT ce.centre_code AS marking_centre_code, ce.name AS marking_centre_name,ex.nrc AS nrc, ex.tpin AS tpin,CONCAT(ex.first_name," ",ex.last_name) AS full_name,ex.address AS address,pr.p_name AS province,po.name AS position, (
                                
                                SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no
                                ORDER BY no_of_scripts_marked DESC LIMIT 1
                        ) AS no_of_scripts,
                        br.sortcode AS sortcode,ex.account_no AS account_no,CASE WHEN ex.role = 5 THEN mr.chief_examiner ELSE mr.deputy_c_examiner END AS net_rate,
                         CASE WHEN ex.role = 5 THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END AS grossed_up_rate,
                             (
                                SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no
                                ORDER BY no_of_scripts_marked DESC LIMIT 1
                             ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
                        ) AS gross_pay,
                        (
                                SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no
                                ORDER BY no_of_scripts_marked DESC LIMIT 1
                             ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
                        ) * :tax AS wht,
                        ((
                                SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no
                                ORDER BY no_of_scripts_marked DESC LIMIT 1
                             ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
                        )) - 
                        (
                                (
                                        SELECT no_of_scripts / no_of_examiners AS no_of_scripts_marked FROM highest_claim WHERE subject_code = ex.subject_code AND paper_no = ex.paper_no
                                        ORDER BY no_of_scripts_marked DESC LIMIT 1
                                     ) * (CASE WHEN ex.role = 5 THEN mr.chief_examiner * :rate_value ELSE mr.deputy_c_examiner * :rate_value END
                                ) * :tax
                        ) AS net_pay,

                        b.name AS bank,br.name AS branch,su.subject_code AS subject_code,su.subject_name AS subject_name,ex.paper_no AS paper_no,ex.belt_no AS belt_no,CONCAT(:session_year," ",:session_name," ",:session_type) AS session_name
                        FROM bank b INNER JOIN bankbranch br ON (b.id = br.bank_id)
                        INNER JOIN examiner ex ON (br.id = ex.branch)
			INNER JOIN centre ce ON (ex.marking_centre = ce.centre_code)
                        INNER JOIN province pr ON (ex.province = pr.p_code)
                        INNER JOIN position po ON (po.id = ex.role)
                        INNER JOIN marking_rates mr ON (ex.subject_code = mr.subject_code)
                        RIGHT OUTER JOIN group_apportion ga ON (mr.subject_code = ga.subject)
                        INNER JOIN subjects su ON (ga.subject = su.subject_code)
			INNER JOIN highest_claim hc ON (su.subject_code = hc.subject_code)
                        WHERE ex.subject_code = ga.subject
                        AND ex.paper_no = ga.paper
                        AND ex.paper_no = mr.paper_no
                        AND ex.subject_code = su.subject_code
                        AND su.subject_code = mr.subject_code
			AND ce.centre_code = ga.marking_centre
			
                        AND ga.paper = mr.paper_no
                        AND ex.marking_centre = ga.marking_centre
                        AND mr.paper_no = ga.paper
                        AND ex.province = ga.province
                        AND ex.marking_centre =:marking_centre_code
                        AND ex.attendance = 1
                        AND ex.role IN (4, 5)
                        GROUP BY ex.nrc,pr.p_name,po.name,ex.tpin,ex.role,ex.address,ex.first_name,ex.last_name,mr.chief_examiner,mr.deputy_c_examiner,ex.account_no,b.name,br.name,br.sortcode,ex.belt_no,ce.centre_code,ce.name,su.subject_code,su.subject_name,ex.paper_no
                       
                       UNION

                       SELECT ce.centre_code AS marking_centre_code, ce.name AS marking_centre_name,ex.nrc AS nrc, ex.tpin AS tpin,CONCAT(ex.first_name," ",ex.last_name) AS full_name,ex.address AS address,pr.p_name AS province,po.name AS position,eb.no_of_scripts AS no_of_scripts, 
                        br.sortcode AS sortcode, ex.account_no AS account_no,CASE WHEN ex.role = 1 THEN mr.examiner  WHEN ex.role = 2 THEN mr.checker ELSE mr.t_leader END AS net_rate,
                        CASE WHEN ex.role = 1 THEN mr.examiner * :rate_value WHEN ex.role = 2 THEN mr.checker * :rate_value ELSE mr.t_leader * :rate_value END AS grossed_up_rate,

                        (eb.no_of_scripts / eb.no_of_examiners) * (CASE WHEN ex.role = 1 THEN mr.examiner * :rate_value WHEN ex.role = 2 THEN mr.checker * :rate_value ELSE mr.t_leader * :rate_value END) AS gross_pay,

                        (eb.no_of_scripts / eb.no_of_examiners) * (CASE WHEN ex.role = 1 THEN mr.examiner * :rate_value WHEN ex.role = 2 THEN mr.checker * :rate_value ELSE mr.t_leader * :rate_value END) * :tax AS wht,
                        (eb.no_of_scripts / eb.no_of_examiners) * (CASE WHEN ex.role = 1 THEN mr.examiner * :rate_value WHEN ex.role = 2 THEN mr.checker * :rate_value ELSE mr.t_leader * :rate_value END) - (eb.no_of_scripts / eb.no_of_examiners) * (CASE WHEN ex.role = 1 THEN mr.examiner * :rate_value WHEN ex.role = 2 THEN mr.checker * :rate_value ELSE mr.t_leader * :rate_value END) * :tax AS net_pay,

                        b.name AS bank,br.name AS branch,ex.subject_code AS subject_code,su.subject_name AS subject_name,ex.paper_no AS paper_no,ex.belt_no AS belt_no,CONCAT(:session_year," ",:session_name) AS session_name
                        FROM bank b INNER JOIN bankbranch br ON (b.id = br.bank_id)
                        INNER JOIN examiner ex ON (br.id = ex.branch)
                        INNER JOIN province pr ON (ex.province = pr.p_code)
			INNER JOIN centre ce ON (ex.marking_centre = ce.centre_code)
                        INNER JOIN position po ON (po.id = ex.role)
                        INNER JOIN marking_rates mr ON (ex.subject_code = mr.subject_code)
                        INNER JOIN group_apportion ga ON (mr.subject_code = ga.subject)
			INNER JOIN subjects su ON (ga.subject = su.subject_code)
                        INNER JOIN examiners_belt eb ON (ga.subject = eb.subject_code)
                        WHERE eb.paper_no = ga.paper
			AND eb.belt_no = ga.belt_no
                        AND ex.subject_code = ga.subject
                        AND ex.paper_no = ga.paper
                        AND ga.belt_no = ex.belt_no
                        AND ex.paper_no = mr.paper_no
                        AND ga.paper = mr.paper_no
                        AND ex.marking_centre = ga.marking_centre
                        AND mr.paper_no = ga.paper
			AND su.subject_code = ex.subject_code
			AND su.subject_code = mr.subject_code

                        AND ex.province = ga.province
			AND ex.marking_centre =:marking_centre_code
                        AND ex.marking_centre =ce.centre_code
                        AND ex.attendance = 1
                        AND ex.role IN (1, 2, 3)
                        GROUP BY ex.nrc,pr.p_name,ex.tpin,po.name,ex.address, ex.first_name,ex.last_name,ex.role, mr.examiner,mr.t_leader,mr.checker, ex.account_no,b.name,br.name,br.sortcode,eb.no_of_scripts,eb.no_of_examiners,ex.belt_no,ce.centre_code, ce.name,su.subject_code,su.subject_name,ex.paper_no

                       ');
$sql->execute(array(
        
        ':session_name'=>$_SESSION['session_name'],
        ':session_year'=>$_SESSION['session_year'],
        ':session_type'=>$session_type,
        ':tax'=>$tax,
        ':rate_value'=>$rate_value,
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Successfully submitted claims';
       

}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem submittinmg claims';
      
}
        }catch(PDOException $e){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error2: '.$e->getMessage();
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Marking Centere not set not set';
}
echo json_encode($data_array);
?>