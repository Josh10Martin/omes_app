<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'SESO'){
if($_SESSION['session_type'] == 'E'){
        $sql = $db_9->prepare('SELECT DISTINCT ce.centre_code AS centre_code, ce.name AS centre_name, mc.centre_code AS marking_centre_code,
                         COUNT(DISTINCT (CASE WHEN mcc.centre_code <> "none" THEN mcc.centre_code END)) AS no_of_centres, COUNT(DISTINCT(mc.subject)) AS no_of_subjects, MAX(mcc.sen) AS sen, 
                         mcc.valid AS valid
                        FROM centre ce LEFT OUTER JOIN marking_centre mc ON (ce.centre_code = mc.centre_code)
                        LEFT OUTER JOIN marking_centre_centres mcc ON (ce.centre_code = mcc.marking_centre)
                         WHERE ce.province =:province_code 
                         AND ce.centre_type =:centre_type
                         GROUP BY ce.centre_code,ce.name,mcc.valid');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':centre_type'=>$_SESSION['session_type']
));
if($sql->rowCount() > 0){
        $i=0;
        while( $row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                $data_array[$i]['no_of_centres'] = $row['no_of_centres'] ?? '0';
                $data_array[$i]['no_of_subjects'] = $row['no_of_subjects'] ?? '0';
                $data_array[$i]['activation_status'] = $row['centre_code'] == $row['marking_centre_code'] ? '1' : '0';
                $data_array[$i]['valid'] = $row['valid'] ?? '0';
                $data_array[$i]['sen'] = $row['sen'] == 1 ? '1' : '0';
                $i++;
        }
        
}
}else{
        $sql = $db_9->prepare('SELECT DISTINCT ce.centre_code AS centre_code, ce.name AS centre_name, mp.marking_centre AS marking_centre_code ,COUNT(DISTINCT(mp.centre_code)) AS no_of_centres,
                                (SELECT DISTINCT marking_centre FROM marks_prep WHERE sen = 1 AND province =:province_code) AS sen,
                                (SELECT valid FROM apportionment_summary WHERE province =:province_code AND subject_name = "ALL SEN SUBJECTS") AS chosen_sen
                        FROM centre ce LEFT OUTER JOIN marks_prep mp ON (ce.centre_code = mp.marking_centre)
                         WHERE ce.province =:province_code 
                         AND ce.centre_type =:centre_type
                         GROUP BY ce.centre_code,ce.name');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':centre_type'=>$_SESSION['session_type']
));
if($sql->rowCount() > 0){
        $i=0;
        while( $row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                $data_array[$i]['no_of_centres'] = $row['no_of_centres'] ?? '0';
                $data_array[$i]['no_of_subjects'] = $row['no_of_subjects'] ?? '0';
                $data_array[$i]['chosen_sen'] = $row['chosen_sen'] ?? '0';
                $data_array[$i]['sen'] = $row['sen'] == $row['centre_code'] ? '1' : '';
                $data_array[$i]['activation_status'] = $row['centre_code'] == $row['marking_centre_code'] ? '1' : '0';
                $i++;
        }
        
}
}
}else {
        if($_SESSION['session_type'] == 'E'){
        $sql = $db_9->prepare('SELECT DISTINCT ce.centre_code AS centre_code, ce.name AS centre_name, mc.centre_code AS marking_centre_code ,COUNT(DISTINCT(mcc.centre_code)) AS no_of_centres, COUNT(DISTINCT(mc.subject)) AS no_of_subjects
                        FROM centre ce LEFT OUTER JOIN marking_centre mc ON (ce.centre_code = mc.centre_code)
                        LEFT OUTER JOIN marking_centre_centres mcc ON (ce.centre_code = mcc.marking_centre)
                         WHERE ce.province =:province_code 
                         AND ce.centre_type =:centre_type
                         AND mc.centre_code =:marking_centre_code
                         GROUP BY ce.centre_code,ce.name');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':province_code'=>$_SESSION['province_code'],
        ':centre_type'=>$_SESSION['session_type']
));
if($sql->rowCount() > 0){
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
        $sql = $db_9->prepare('SELECT DISTINCT ce.centre_code AS centre_code, ce.name AS centre_name, mp.marking_centre AS marking_centre_code ,COUNT(DISTINCT(mp.centre_code)) AS no_of_centres, COUNT(DISTINCT(mp.subject_code)) AS no_of_subjects
                                
                                 FROM centre ce LEFT OUTER JOIN marks_prep mp ON (ce.centre_code = mp.marking_centre)
                                 WHERE ce.province =:province_code 
                                AND ce.centre_type =:centre_type
                                AND mp.marking_centre =:marking_centre_code
                                GROUP BY ce.centre_code,ce.name');
        $sql->execute(array(
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':province_code'=>$_SESSION['province_code'],
                ':centre_type'=>$_SESSION['session_type']
        ));
        if($sql->rowCount() > 0){
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