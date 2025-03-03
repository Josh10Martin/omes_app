<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../../config.php';
$data_array = array();
$sql = $db_9->prepare('SELECT marking_centre_name,nrc,tpin,full_name,position,no_of_scripts,bank,branch,sortcode,account_no,gross_pay,15_wht,net_pay
                                FROM system_admin_claims
                       ');
$sql->execute();
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                $data_array[$i]['tpin'] = $row['tpin'] ?? '';
                $data_array[$i]['position'] = $row['position'] ?? '';
                $data_array[$i]['payee_full_name'] = $row['full_name'] ?? '';
                $data_array[$i]['sortcode'] = $row['sortcode'] ?? '';
                $data_array[$i]['no_of_scripts'] = $row['no_of_scripts'] ?? '';
                $data_array[$i]['account_no'] = $row['account_no'] ?? '';
                $data_array[$i]['gross_pay'] = number_format((float)$row['gross_pay'],2,'.','') ?? '';
                $data_array[$i]['15_wht'] = number_format((float)$row['15_wht'],2,'.','') ?? '';
                $data_array[$i]['net_pay'] = number_format((float)$row['net_pay'],2,'.','') ?? '';
                $data_array[$i]['bank'] = $row['bank'] ?? '';
                $data_array[$i]['branch'] = $row['branch'] ?? '';

                $i++;
        }

}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>