<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'DEO'){
$sql = $db_9->prepare('SELECT id, full_name,no_of_scripts,bank,branch,account_no,gross_pay
                                FROM data_entry_claims WHERE marking_centre_code =:marking_centre_code AND username =:username
                       ');
$sql->execute(array(
        ':username'=>$_SESSION['username'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['full_name'] = $row['full_name'] ?? '';
                $data_array[$i]['account_no'] = $row['account_no'] ?? '';
                $data_array[$i]['gross_pay'] = number_format((float)$row['gross_pay'],2,'.','') ?? '';
                $data_array[$i]['wht'] = number_format((float)$row['15_wht'],2,'.','') ?? '';
                $data_array[$i]['net_pay'] = number_format((float)$row['net_pay'],2,'.','') ?? '';
                $data_array[$i]['bank'] = $row['bank'] ?? '';
                $data_array[$i]['branch'] = $row['branch'] ?? '';
                $data_array[$i]['no_of_scripts'] = $row['no_of_scripts'] ?? '';
                $i++;
        }

}else{
        $data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>