<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
// header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;

$session_type = $_SESSION['session_type'] == 'I' ? 'INTERNAL' : 'EXTERNAL';
if(isset($_SESSION['user_type']) =="DEO"){
        try{
                $sql = $db_9->prepare('REPLACE INTO data_entry_claims (marking_centre_code,marking_centre_name,nrc,tpin,full_name,position,phone_number,no_of_scripts,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,bank,branch,sortcode,account_no, username,session_name)
                        SELECT :marking_centre_code AS marking_centre_code,
                                :marking_centre_name AS marking_centre_name,
                                u.nrc AS nrc,
                                u.tpin AS tpin,
                                CONCAT(u.first_name," ", u.last_name) AS full_name,
                                u.user_type AS position,
                                u.phone AS phone,
                                SUM(m.status <> "L") AS no_of_scripts, 
                                mr.data_entry AS net_rate,
                                mr.data_entry * :rate_value AS grossed_up_rate,
                                SUM(m.status <> "L") * (mr.data_entry * :rate_value) AS gross_pay, 
                                ((SUM(m.status <> "L") * (mr.data_entry * :rate_value)) * :tax) AS 15_wht,
                                ((SUM(m.status <> "L") * (mr.data_entry * :rate_value)) - ((SUM(m.status <> "L") * (mr.data_entry * :rate_value)) * :tax)) AS net_pay, 
                                b.name AS bank,
                                br.name AS branch, 
                                br.sortcode AS sortcode, 
                                u.account_no AS account_no,
                                u.username AS username,
                                CONCAT(:session_year," ",:session_name," ",:session_type) AS session_name
                                FROM bank b INNER JOIN bankbranch br ON (b.id = br.bank_id)
                                INNER JOIN users u ON (br.id = u.branch)
                                INNER JOIN marks m ON (u.marking_centre = m.marking_centre)
                                INNER JOIN marking_rates mr ON (m.subject_code = mr.subject_code)
                                WHERE m.paper_no = mr.paper_no
                                AND u.province = m.province
                                AND m.marking_centre =:marking_centre_code
                                AND m.province =:province_code
                                AND u.username = LEFT(m.entered_by,LOCATE(" ",m.entered_by) -1)
                                AND m.entered_by =:username
                                GROUP BY u.first_name,u.last_name,b.name,u.tpin,u.user_type,br.sortcode,u.username,br.name,u.account_no,u.nrc,u.phone,mr.data_entry');
                $sql->execute(array(
                        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                        ':marking_centre_name'=>$_SESSION['marking_centre'],
                        ':session_year'=>$_SESSION['session_year'],
                        ':session_name'=>$_SESSION['session_name'],
                        ':session_type'=>$session_type,
                        ':tax'=>$tax,
                        ':rate_value'=>$rate_value,
                        ':province_code'=>$_SESSION['province_code'],
                        ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name']
                ));
                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $data_array['response_msg'] = 'Successfully submitted your claim';
                }else{
                        $data_array['status'] = '400';
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