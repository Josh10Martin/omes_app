<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../../config.php';
$data_array = array();
if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'ADMIN'){
        $sql = $db_12_gce->prepare('SELECT marking_centre_name,examiner_number,nrc,tpin,full_name,address,province,district,position,no_of_scripts,bank,branch,sortcode,account_no,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,subject_code,subject_name,paper_no,belt_no,session_name
                                FROM examiner_claim WHERE marking_centre_code =:marking_centre_code
                       ');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['examiner_number'] = $row['examiner_number'] ?? '';
                $data_array[$i]['tpin'] = $row['tpin'] ?? '';
                $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                $data_array[$i]['position'] = $row['position'] ?? '';
                $data_array[$i]['province'] = $row['province'] ?? '';
                $data_array[$i]['district'] = $row['district'] ?? '';
                $data_array[$i]['payee_full_name'] = $row['full_name'] ?? '';
                $data_array[$i]['payee_address'] = $row['address'] ?? '';
                $data_array[$i]['sortcode'] = $row['sortcode'] ?? '';
                $data_array[$i]['account_no'] = $row['account_no'] ?? '';
                $data_array[$i]['net_rate'] = $row['net_rate'] ?? '';
                $data_array[$i]['grossed_up_rate'] = $row['grossed_up_rate'] ?? '';
                $data_array[$i]['gross_pay'] = number_format((float)$row['gross_pay'],2,'.','') ?? '';
                $data_array[$i]['15_wht'] = number_format((float)$row['15_wht'],2,'.','') ?? '';
                $data_array[$i]['net_pay'] = number_format((float)$row['net_pay'],2,'.','') ?? '';
                $data_array[$i]['bank'] = $row['bank'] ?? '';
                $data_array[$i]['branch'] = $row['branch'] ?? '';
                $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                $data_array[$i]['no_of_scripts'] = $row['no_of_scripts'] ?? '';
                $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                $data_array[$i]['session_name'] = $row['session_name'] ?? '';
                $i++;
        }

}else{
        $data_array['status'] = '400';
}
}else{
$sql = $db_12_gce->prepare('SELECT marking_centre_name,examiner_number,nrc,tpin,full_name,address,province,district,position,no_of_scripts,bank,branch,sortcode,account_no,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,subject_code,subject_name,paper_no,belt_no,session_name
                                FROM examiner_claim
                       ');
$sql->execute();
if($sql->rowCount() > 0){
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['examiner_number'] = $row['examiner_number'] ?? '';
                $data_array[$i]['tpin'] = $row['tpin'] ?? '';
                $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                $data_array[$i]['position'] = $row['position'] ?? '';
                $data_array[$i]['province'] = $row['province'] ?? '';
                $data_array[$i]['district'] = $row['district'] ?? '';
                $data_array[$i]['payee_full_name'] = $row['full_name'] ?? '';
                $data_array[$i]['payee_address'] = $row['address'] ?? '';
                $data_array[$i]['sortcode'] = $row['sortcode'] ?? '';
                $data_array[$i]['account_no'] = $row['account_no'] ?? '';
                $data_array[$i]['net_rate'] = $row['net_rate'] ?? '';
                $data_array[$i]['grossed_up_rate'] = $row['grossed_up_rate'] ?? '';
                $data_array[$i]['gross_pay'] = number_format((float)$row['gross_pay'],2,'.','') ?? '';
                $data_array[$i]['15_wht'] = number_format((float)$row['15_wht'],2,'.','') ?? '';
                $data_array[$i]['net_pay'] = number_format((float)$row['net_pay'],2,'.','') ?? '';
                $data_array[$i]['bank'] = $row['bank'] ?? '';
                $data_array[$i]['branch'] = $row['branch'] ?? '';
                $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                $data_array[$i]['no_of_scripts'] = $row['no_of_scripts'] ?? '';
                $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                $data_array[$i]['session_name'] = $row['session_name'] ?? '';
                $i++;
        }

}else{
        $data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>