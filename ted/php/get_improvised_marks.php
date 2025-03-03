<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_ted->prepare('SELECT m.exam_no AS exam_no,m.centre_code AS centre_code, su.subject_code AS subject_code,m.mark AS mark, 
                        m.date_entered AS date_entered,m.belt_no AS belt_no
                        FROM marks m INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                        WHERE m.improvised_mark = 1
                        AND m.entered_by = :username
                        AND m.marking_centre =:marking_centre_code
                        AND m.session =:session
                        ORDER BY date_entered DESC');
$sql->execute(array(
    ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
    ':marking_centre_code'=>$_SESSION['marking_centre_code'],
    ':session'=>$_SESSION['session_year']
));
if($sql->rowCount() > 0){
    $i = 0;
    while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['exam_no'] = $row['exam_no'] ?? '';
        $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
        $data_array[$i]['subject_code'] = $row['subject_code'] ?? '';
        $data_array[$i]['paper_no'] = 2;
        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
        $data_array[$i]['mark'] = $row['mark'] ?? '';
        $data_array[$i]['date_entered'] = $row['date_entered'] ?? '';
        $i++;
    }
}else{
    $data_array['status'] = '400';
}
echo json_encode($data_array);
?>