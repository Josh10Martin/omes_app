<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
// header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;
if(isset($_SESSION['user_type'])){
        try{
                $sql = $db_ted->prepare('REPLACE INTO data_entry_claims (marking_centre_code,marking_centre_name,examiner_number,nrc,tpin,full_name,phone_number,address,station,district,province,position,no_of_scripts,sortcode,account_no,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,bank,branch,belt_no,date_claimed,session,session_name)
                                                SELECT :marking_centre_code AS marking_centre_code, :marking_centre_name AS marking_centre_name,ex.examiner_number AS examiner_number,ex.nrc AS nrc, ex.tpin AS tpin,CONCAT(ex.first_name," ",ex.last_name) AS full_name, 
                                                         ex.phone_number,ex.address AS address,ex.station AS station, ex.district AS district, ex.province AS province, ex.role AS position,SUM(m.status <> "L") AS no_of_scripts,ex.sortcode AS sortcode,ex.account_no AS account_no, mr.data_entry AS net_rate, mr.data_entry * :rate_value AS grossed_up_rate,
                                                         SUM(m.status <> "L") * (mr.data_entry * :rate_value) AS gross_pay,
                                                         (SUM(m.status <> "L") * (mr.data_entry * :rate_value)) * :tax AS 15_wht, 
                                                         (SUM(m.status <> "L") * (mr.data_entry * :rate_value)) - ((SUM(m.status <> "L") * (mr.data_entry * :rate_value)) * :tax) AS net_pay,
                                                        ex.bank AS bank, ex.branch AS branch, "D/E",DATE(NOW()),ex.session, CONCAT(:session," ",:session_name) AS session_name
                                                        
                                                        FROM  examiner ex INNER JOIN marks m ON (ex.marking_centre = m.marking_centre)                            
                                                        CROSS JOIN marking_rates mr 
                                                
                                                        WHERE m.marking_centre =:marking_centre_code
                                                        AND ex.examiner_number = LEFT(m.entered_by,LOCATE(" ",m.entered_by) -1)
                                                        AND ex.examiner_number =:examiner_number
                                                        AND m.entered_by =:username
                                                        AND ex.role = "DATA ENTRY OFFICER"
                                                        AND ex.session =:session
                                                        AND mr.session =:session
                                                        GROUP BY ex.first_name,ex.last_name,ex.examiner_number, ex.bank, ex.branch,ex.sortcode,ex.account_no,ex.tpin,ex.nrc,ex.phone_number,ex.address,ex.station,ex.district,ex.province,ex.role,mr.data_entry
                ');
                $sql->execute(array(
                        ':examiner_number'=>$_SESSION['username'],
                        ':rate_value'=>$rate_value,
                        ':tax'=>$tax,
                        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                        ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                        ':session'=>$_SESSION['session_year'],
                        ':session_name'=>$_SESSION['session_name'],
                        ':marking_centre_name'=>$_SESSION['marking_centre']
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