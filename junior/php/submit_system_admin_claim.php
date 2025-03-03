<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$session_type = $_SESSION['session_type'] == 'I' ? 'INTERNAL' : 'EXTERNAL';
$rate_value = 100/85;
$tax = 15/100;

if(isset($_SESSION['user_type'])){
        try{
                $sql = $db_9->prepare('REPLACE INTO system_admin_claims (marking_centre_code,marking_centre_name,nrc,tpin,username,full_name,position,phone_number,no_of_scripts,subject_code,subject_name,paper_no,belt_no,sortcode,account_no,gross_pay,15_wht,net_pay,net_rate,grossed_up_rate,bank,branch, session_name)
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
                                                
                                                
                    SELECT :marking_centre_code, :marking_centre_name,u.nrc AS nrc, u.tpin AS tpin,u.username AS username, CONCAT(u.first_name," ",u.last_name) AS full_name, u.user_type AS user_type,u.phone AS phone_number,
                    hsc.max_no_of_scripts AS max_no_of_scripts,hsc.subject_code AS subject_code,hsc.subject_name AS subject_name,hsc.paper_no AS paper_no,hsc.belt_no AS belt_no,br.sortcode AS sortcode, u.account_no AS account_no,
                ( 
                SELECT 
                (max_no_of_scripts * (mr.sys_admin * :rate_value)) / no_of_examiners
                FROM 
                highest_script_count
                ) AS gross_pay,
                (SELECT 
                (max_no_of_scripts * (mr.sys_admin * :rate_value)) / no_of_examiners
                FROM 
                highest_script_count) * :tax AS 15_wht,

                (SELECT 
                (max_no_of_scripts * (mr.sys_admin * :rate_value)) / no_of_examiners
                FROM 
                highest_script_count) - 
                (SELECT 
                (max_no_of_scripts * (mr.sys_admin * :rate_value)) / no_of_examiners
                FROM 
                highest_script_count) * :tax AS net_pay,


        mr.sys_admin AS net_rate,mr.sys_admin * :rate_value AS grossed_up_rate,b.name AS bank,br.name AS branch, CONCAT(:session_year," ",:session_name," ",:session_type) AS session_name
    FROM bank b INNER JOIN bankbranch br ON (b.id = br.bank_id)
    INNER JOIN users u ON (br.id = u.branch)
    INNER JOIN group_apportion g ON (u.marking_centre = g.marking_centre)
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
    GROUP BY u.first_name,u.last_name,u.tpin,u.username,u.user_type,u.phone,hsc.subject_code,hsc.subject_name,hsc.paper_no,hsc.max_no_of_scripts,hsc.belt_no,b.name,br.name,br.sortcode,u.account_no,u.nrc,u.phone,mr.sys_admin

');
                            
    $sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':session_year'=>$_SESSION['session_year'],
        ':session_name'=>$_SESSION['session_name'],
        ':session_type'=>$session_type,
        ':rate_value'=>$rate_value,
        ':tax'=>$tax,
        ':marking_centre_name'=>$_SESSION['marking_centre'],
        ':province_code'=>$_SESSION['province_code'],
        ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name']
    ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'Successfully submitted your claim';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was a problem submitting claim';
        }
        }catch(PDOException $e){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'User type not set';
}
echo json_encode($data_array);
?>