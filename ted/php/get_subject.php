<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO'){
$sql= $db_ted->prepare('SELECT s.subject_code AS subject_code,s.subject_name AS subject_name FROM subjects s
                        INNER JOIN course c ON (s.course_id = c.course_code)
                        INNER JOIN marking_centre mc ON (c.course_code = mc.course)
                        WHERE s.session = mc.session
                        AND mc.session =:session_year
                        AND mc.centre_code =:marking_centre_code
                        ORDER BY s.subject_code ASC
                        ');
$sql->execute(array(
        ':session_year'=>$_SESSION['session_year'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['subject_code'] = $row['subject_code'];
        $data_array[$i]['subject_name'] = $row['subject_name'];
        $i++;
}
}else{
        $sql= $db_ted->prepare('SELECT subject_code,subject_name FROM subjects WHERE session =:session_year ORDER BY subject_code ASC');
$sql->execute(array(
        ':session_year'=>$_SESSION['session_year']
));
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['subject_code'] = $row['subject_code'];
        $data_array[$i]['subject_name'] = $row['subject_name'];
        $i++;
}
}
echo json_encode($data_array);
?>