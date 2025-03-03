<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ADMIN'){
$sql = $db_ted->prepare('SELECT id, full_name,position,no_of_scripts,bank,branch,account_no,gross_pay,subject_name,paper_no,belt_no
                                FROM examiner_claim WHERE marking_centre_code =:marking_centre_code AND session =:session
                       ');
$sql->execute(array(
        ':session'=>$_SESSION['session_year'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
        $i =0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['position'] = $row['position'] ?? '';
                $data_array[$i]['full_name'] = $row['full_name'] ?? '';
                $data_array[$i]['account_no'] = "'".$row['account_no'] ?? '';
                $data_array[$i]['gross_pay'] = "'".number_format((float)$row['gross_pay'],2,'.','') ?? '';
                $data_array[$i]['bank'] = $row['bank'] ?? '';
                $data_array[$i]['branch'] = $row['branch'] ?? '';
                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                $data_array[$i]['paper_no'] = $row['paper_no'] ?? '';
                $data_array[$i]['no_of_scripts'] = $row['no_of_scripts'] ?? '';
                $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                $i++;
        }

}else{
        $data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>