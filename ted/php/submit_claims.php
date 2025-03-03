<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
// header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;
if(isset($_SESSION['marking_centre_code'])){

       
        try{
        $sql = $db_ted->prepare('  REPLACE INTO examiner_claim (marking_centre_code,marking_centre_name,nrc,tpin,examiner_number,full_name,address,station,district,province,position,no_of_scripts,sortcode,account_no,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,bank,branch,group_code,group_name,course_code,course_name,belt_no,session,session_name)
        WITH examiners_claim AS (
    SELECT 
    COUNT(ex.nrc) AS no_of_examiners, 
    ga.no_of_scripts AS no_of_scripts,  
    ga.belt_no AS belt_no,
	ga.group_code AS group_code,
	ga.session AS session 
    FROM group_apportion ga
    INNER JOIN course_group cg ON ga.group_code = cg.group_code
    INNER JOIN course co ON cg.group_code = co.group_id
    INNER JOIN examiner ex ON co.course_code = ex.course_code
    WHERE ex.belt_no = ga.belt_no
    AND ga.marking_centre = ex.marking_centre
    AND ex.marking_centre =:marking_centre_code
    AND ex.session = ga.session
     AND ex.session =:session
    AND ex.role IN ("EXAMINER", "TEAM LEADER")
    GROUP BY ga.no_of_scripts,ga.group_code, ga.belt_no
)

SELECT 
    ce.centre_code AS marking_centre_code,
    ce.name AS marking_centre_name,
    ex.nrc AS nrc,
    ex.tpin AS tpin,
    ex.examiner_number AS examiner_number,
    CONCAT(ex.first_name, " ", ex.last_name) AS full_name,
    ex.address AS address,
    ex.station AS station,
    ex.district AS district,
    ex.province AS province,
    ex.role AS position,
    ga.no_of_scripts AS script_no,
    ex.sortcode AS sortcode,
    ex.account_no AS account_no,
    CASE 
        WHEN ex.role = "EXAMINER" THEN mr.examiner
        ELSE mr.t_leader
    END AS net_rate,
    CASE 
        WHEN ex.role = "EXAMINER" THEN mr.examiner * :rate_value
        ELSE mr.t_leader * :rate_value
    END AS grossed_up_rate,

    -- Calculate gross pay
    (
        CASE
            WHEN ec.no_of_scripts / ec.no_of_examiners = 0 THEN 0
            WHEN ec.no_of_scripts / ec.no_of_examiners < 100 THEN 100
            ELSE ec.no_of_scripts / ec.no_of_examiners
        END
    ) * (
        CASE 
            WHEN ex.role = "EXAMINER" THEN mr.examiner * :rate_value
            ELSE mr.t_leader * :rate_value
        END
    ) AS gross_pay,

    -- Calculate 15% withholding tax
    (
        CASE
            WHEN ec.no_of_scripts / ec.no_of_examiners = 0 THEN 0
            WHEN ec.no_of_scripts / ec.no_of_examiners < 100 THEN 100
            ELSE ec.no_of_scripts / ec.no_of_examiners
        END
    ) * (
        CASE 
            WHEN ex.role = "EXAMINER" THEN mr.examiner * :rate_value
            ELSE mr.t_leader * :rate_value
        END
    ) * (15 / 100) AS 15_wht,

    -- Calculate net pay
    (
        (
            CASE
                WHEN ec.no_of_scripts / ec.no_of_examiners = 0 THEN 0
                WHEN ec.no_of_scripts / ec.no_of_examiners < 100 THEN 100
                ELSE ec.no_of_scripts / ec.no_of_examiners
            END
        ) * (
            CASE 
                WHEN ex.role = "EXAMINER" THEN mr.examiner * :rate_value
                ELSE mr.t_leader * :rate_value
            END
        ) - (
            CASE
                WHEN ec.no_of_scripts / ec.no_of_examiners = 0 THEN 0
                WHEN ec.no_of_scripts / ec.no_of_examiners < 100 THEN 100
                ELSE ec.no_of_scripts / ec.no_of_examiners
            END
        ) * (
            CASE 
                WHEN ex.role = "EXAMINER" THEN mr.examiner * :rate_value
                ELSE mr.t_leader * :rate_value
            END
        ) * (15 / 100)
    ) AS net_pay,

    ex.bank AS bank,
    ex.branch AS branch,
    cg.group_code AS group_code,
    cg.group_name AS group_name,
    co.course_code AS course_code,
    co.course_name AS course_name,
    ex.belt_no AS belt_number,
    ex.session AS session,
    CONCAT (:session," ",:session_name) AS session_name

FROM 
    centre ce
    INNER JOIN examiner ex ON ce.centre_code = ex.marking_centre
    INNER JOIN course co ON ex.course_code = co.course_code
    INNER JOIN course_group cg ON co.group_id = cg.group_code
    INNER JOIN group_apportion ga ON cg.group_code = ga.group_code
    INNER JOIN examiners_claim ec ON ga.belt_no = ec.belt_no  -- Join with the CTE
    CROSS JOIN marking_rates mr

WHERE 
    ex.belt_no = ga.belt_no
    AND ex.belt_no = ec.belt_no
     AND ec.group_code = ga.group_code
    AND ex.marking_centre = ga.marking_centre
    AND ex.marking_centre =:marking_centre_code
    AND ex.session = ga.session
    AND ex.session = ec.session
    AND ex.session =:session
    AND mr.session =:session
    AND ex.attendance = 1
    AND ex.role IN ("EXAMINER", "TEAM LEADER") 

GROUP BY 
    ex.nrc, ce.centre_code, ce.name, ex.bank, ex.branch, ex.tpin, 
    ex.first_name, ex.last_name, ex.address, ex.station,ex.district,ex.province,
    ga.no_of_scripts, 
    ex.sortcode, ex.account_no, mr.t_leader, mr.examiner, 
    ex.role, ex.belt_no, co.course_name, co.course_code, 
    cg.group_code, cg.group_name, ex.session


                       ');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':rate_value'=>$rate_value,
        ':tax'=>$tax,
        ':session_name'=>$_SESSION['session_name'],
        ':session'=>$_SESSION['session_year']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Successfully submitted claims';
        

}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not submit examiners claim';
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