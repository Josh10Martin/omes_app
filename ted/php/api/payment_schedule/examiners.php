<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../../../config.php';
$data_array = array();
if(isset($_SESSION['user_type'] ) && $_SESSION['user_type'] == 'ADMIN'){
        $sql = $db_ted->prepare('SELECT id,marking_centre_code,marking_centre_name,nrc,tpin,examiner_number,full_name,address,station,district,province,position,no_of_scripts,sortcode,account_no,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,bank,branch,group_code,group_name,course_code,course_name,belt_no,session,session_name
                                FROM examiner_claim WHERE marking_centre_code =:marking_centre_code AND session =:session
                       ');
$sql->execute(array(
        ':session'=>$_SESSION['session_year'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
}else{
$sql = $db_ted->prepare('SELECT id,marking_centre_code,marking_centre_name,nrc,tpin,examiner_number,full_name,address,station,district,province,position,no_of_scripts,sortcode,account_no,net_rate,grossed_up_rate,gross_pay,15_wht,net_pay,bank,branch,group_code,group_name,course_code,course_name,belt_no,session,session_name
                                FROM examiner_claim
                       ');
$sql->execute();
}
if($sql->rowCount() > 0){
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['marking_centre_code'] = $row['marking_centre_code'] ?? '';
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                $data_array[$i]['tpin'] = $row['tpin'] ?? '';
                $data_array[$i]['examiner_number'] = $row['examiner_number'] ?? '';
                $data_array[$i]['position'] = $row['position'] ?? '';
                $data_array[$i]['payee_full_name'] = $row['full_name'] ?? '';
                $data_array[$i]['payee_address'] = $row['address'] ?? '';
                $data_array[$i]['district'] = $row['district'] ?? '';
                $data_array[$i]['station'] = $row['station'] ?? '';
                $data_array[$i]['province'] = $row['province'] ?? '';
                $data_array[$i]['sortcode'] = $row['sortcode'] ??  '';
                $data_array[$i]['account_no'] = $row['account_no'] ?? '';
                $data_array[$i]['net_rate'] = $row['net_rate'] ?? '';
                $data_array[$i]['grossed_up_rate'] = $row['grossed_up_rate'] ?? '';
                $data_array[$i]['gross_pay'] = number_format((float)$row['gross_pay'],2,'.','') ?? '';
                $data_array[$i]['fifteen_wht'] = number_format((float)$row['15_wht'],2,'.','') ?? '';
                $data_array[$i]['net_pay'] = number_format((float)$row['net_pay'],2,'.','') ?? '';
                $data_array[$i]['bank'] = $row['bank'] ?? '';
                $data_array[$i]['branch'] = $row['branch'] ?? '';
                $data_array[$i]['group_code'] = $row['group_code'] ?? '';
                $data_array[$i]['group_name'] = $row['group_name'] ?? '';
                $data_array[$i]['course_code'] = $row['course_code'] ?? '';
                $data_array[$i]['course_name'] = $row['course_name'] ?? '';
                $data_array[$i]['no_of_scripts'] = $row['no_of_scripts'] ?? '';
                $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                $data_array[$i]['session'] = $row['session'] ?? '';
                $data_array[$i]['session_name'] = $row['session_name'] ?? '';
                $i++;
        }

}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>