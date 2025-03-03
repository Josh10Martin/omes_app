<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
// header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;
$session_type = $_SESSION['session_type'] == 'I' ? 'INTERNAL' : 'EXTERNAL';
try{
$sql = $db_9->prepare('REPLACE INTO examiner_claim (marking_centre_code,marking_centre_name,nrc,tpin,full_name,address,province,position,no_of_scripts,sortcode,account_no,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,bank,branch,subject_code,subject_name,paper_no,belt_no,session_name) 
            WITH brail_transcriber AS (
                        SELECT tsn.no_of_scripts AS no_of_scripts, COUNT(DISTINCT(t.nrc)) AS no_of_examiners, t.marking_centre AS marking_centre_code, mr.transcriber AS transcriber_rate
                        FROM transcriber t INNER JOIN transcriber_script_no tsn ON (t.marking_centre = tsn.marking_centre)
                        CROSS JOIN marking_rates mr
                        WHERE t.marking_centre =:marking_centre_code
                        GROUP BY tsn.no_of_scripts,t.marking_centre,mr.transcriber
            )

            SELECT marking_centre_code AS marking_centre_code,:marking_centre_name AS marking_centre_name,t.nrc AS nrc,t.tpin AS tpin,CONCAT(t.first_name ," ",t.last_name) AS full_name,t.address AS address,pr.p_name AS province,t.role AS position,
            bt.no_of_scripts AS no_of_scripts,br.sortcode AS sortcode,t.account_no AS account_no,bt.transcriber_rate AS net_rate,bt.transcriber_rate * :rate_value AS grossed_up_rate,
            bt.no_of_scripts * (bt.transcriber_rate * :rate_value) / bt.no_of_examiners AS gross_pay,
            (bt.no_of_scripts * (bt.transcriber_rate * :rate_value) / bt.no_of_examiners) * :tax AS 15_wht,
            (bt.no_of_scripts * (bt.transcriber_rate * :rate_value) / bt.no_of_examiners) - ((bt.no_of_scripts * (bt.transcriber_rate * :rate_value) / bt.no_of_examiners) * :tax) AS net_pay,
            b.name AS bank,br.name AS branch, "NULL","NULL",0,0, CONCAT(:session_year," ",:session_name," ",:session_type) AS session_name

            FROM bank b INNER JOIN bankbranch br ON (b.id = br.bank_id)
            INNER JOIN transcriber t ON (br.id = t.branch)
            INNER JOIN transcriber_script_no tsn ON (t.marking_centre = tsn.marking_centre)
            INNER JOIN brail_transcriber bt ON (t.marking_centre = bt.marking_centre_code)
            INNER JOIN province pr ON (t.province = pr.p_code)
            WHERE t.marking_centre =:marking_centre_code
            GROUP BY t.nrc,t.tpin,t.first_name,t.last_name,t.address,pr.p_name,t.role,bt.no_of_scripts,br.sortcode,t.account_no,bt.transcriber_rate,bt.no_of_examiners,b.name,br.name
');
$sql->execute(array(
      ':rate_value'=>$rate_value,
      ':tax'=>$tax,
      ':session_name'=>$_SESSION['session_name'],
      ':session_year'=>$_SESSION['session_year'],
      ':session_type'=>$session_type,
      ':marking_centre_code'=>$_SESSION['marking_centre_code'],
      ':marking_centre_name'=>$_SESSION['marking_centre']
));

if($sql->rowCount() > 0){
      $data_array['status'] = '200';
      $data_array['response_msg'] = 'Successfully submitted transcriber claims';
     

}else{
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Could not submit transcriber claims';
}
      }catch(PDOException $e){
              $data_array['status'] = '400';
              $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
      }
echo json_encode($data_array);
?>