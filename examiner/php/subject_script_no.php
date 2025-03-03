<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$no_of_scripts = '';
$subject_code = '';
if($_SESSION['user_type'] == 'ECZ'){
    $sql = $db_12_gce->prepare('SELECT SUM(a.script_no) AS no_of_scripts,su.subject_code AS subject_code,pa.paper_no AS paper_no
                            FROM apportionment a LEFT OUTER JOIN subjects su ON (a.subject = su.subject_code)
                            INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
                            WHERE a.paper = pa.paper_no
                            GROUP BY su.subject_code,pa.paper_no
                            ORDER BY subject_code,paper_no');
    $sql->execute();
    $row = $sql->fetch(PDO::FETCH_ASSOC);
    $data_array[0]['no_of_scripts'] =  $row['no_of_scripts'] ?? '0';
    $data_array[0]['subject_code'] = $row['subject_code'].'/'.$row['paper_no'] ?? '';
    $i =1;
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['no_of_scripts'] =  $row['no_of_scripts'] ?? '0';
        $data_array[$i]['subject_code'] = $row['subject_code'].'/'.$row['paper_no'] ?? '';
        $i++;
      
    }   

}else{
    $sql = $db_12_gce->prepare('SELECT SUM(a.script_no) AS no_of_scripts,su.subject_code AS subject_code,pa.paper_no AS paper_no
    FROM apportionment a LEFT OUTER JOIN subjects su ON (a.subject = su.subject_code)
    INNER JOIN paper pa ON (su.subject_code = pa.subject_code)
    WHERE a.paper = pa.paper_no
    AND marking_centre =:marking_centre_code
    GROUP BY su.subject_code,pa.paper_no
    ORDER BY subject_code,paper_no');
$sql->execute(array(
    
    ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
$row = $sql->fetch(PDO::FETCH_ASSOC);
    $data_array[0]['no_of_scripts'] =  $row['no_of_scripts'] ?? '0';
    $data_array[0]['subject_code'] = $row['subject_code'].'/'.$row['paper_no'] ?? '';
    $i =1;
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['no_of_scripts'] =  $row['no_of_scripts'] ?? '0';
        $data_array[$i]['subject_code'] = $row['subject_code'].'/'.$row['paper_no'] ?? '';
        $i++;
      
    }
}
echo json_encode($data_array);
?>