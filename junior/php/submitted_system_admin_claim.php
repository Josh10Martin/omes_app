<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ADMIN'){
$sql = $db_9->prepare('SELECT id, marking_centre_code,marking_centre_name,nrc,tpin,full_name,gross_pay,15_wht,net_pay,bank,branch, account_no 
                                FROM system_admin_claims WHERE marking_centre_code =:marking_centre_code AND username =:username
                       ');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':username'=>$_SESSION['username']
));
if($sql->rowCount() > 0){
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['full_name'] = $row['full_name'] ?? '';
                $data_array[$i]['marking_centre_code'] = $row['marking_centre_code'] ?? '';
                $data_array[$i]['marking_centre_name'] = $row['marking_centre_name'] ?? '';
                $data_array[$i]['gross_pay'] = "'".number_format((float)$row['gross_pay'],2,'.','') ?? '';
                $data_array[$i]['15_wht'] = "'".number_format((float)$row['15_wht'],2,'.','') ?? '';
                $data_array[$i]['net_pay'] = "'".number_format((float)$row['net_pay'],2,'.','') ?? '';
                $data_array[$i]['bank'] = $row['bank'] ?? '';
                $data_array[$i]['branch'] = $row['branch'] ?? '';
                $data_array[$i]['account_no'] = "'".$row['account_no'] ?? '';
                $i++;
        }

}else{
        $data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>