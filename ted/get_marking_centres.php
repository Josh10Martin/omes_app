<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ' || $_SESSION['user_type'] == 'SESO'){
$sql = $db_ted->prepare('SELECT DISTINCT ce.centre_code AS centre_code, ce.name AS centre_name, mc.centre_code AS marking_centre_code , COUNT(DISTINCT(mc.subject)) AS no_of_subjects
                        FROM centre ce LEFT OUTER JOIN marking_centre mc ON (ce.centre_code = mc.centre_code)
                       
                         WHERE ce.centre_type =:centre_type
                         GROUP BY ce.centre_code,ce.name');
$sql->execute(array(
        ':centre_type'=>$_SESSION['session_type']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while( $row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                $data_array[$i]['no_of_centres'] = $row['no_of_centres'] ?? '0';
                $data_array[$i]['no_of_subjects'] = $row['no_of_subjects'] ?? '0';
                $data_array[$i]['activation_status'] = $row['centre_code'] == $row['marking_centre_code'] ? '1' : '0';
                $i++;
        }
        
}
}else{
        if($_SESSION['user_type'] == 'ADMIN'){
        $sql = $db_ted->prepare('SELECT DISTINCT ce.centre_code AS centre_code, ce.name AS centre_name, mc.centre_code AS marking_centre_code ,COUNT(DISTINCT(mc.subject)) AS no_of_subjects
                        FROM centre ce LEFT OUTER JOIN marking_centre mc ON (ce.centre_code = mc.centre_code)
                         WHERE ce.centre_type =:centre_type
                         AND mc.centre_code =:marking_centre_code
                         GROUP BY ce.centre_code,ce.name');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':centre_type'=>$_SESSION['session_type']
));
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $i=0;
        while( $row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                $data_array[$i]['no_of_centres'] = $row['no_of_centres'] ?? '0';
                $data_array[$i]['no_of_subjects'] = $row['no_of_subjects'] ?? '0';
                $data_array[$i]['activation_status'] = $row['centre_code'] == $row['marking_centre_code'] ? '1' : '0';
                $i++;
        }
        
}
        }
}
echo json_encode($data_array);
?>