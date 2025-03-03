<?php
header("Access-Control-Allow-Origin: *"); 
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_SESSION['user_type']) && ($_SESSION['user_type'] == 'ADMIN' || $_SESSION['user_type'] == 'DEO')){
        if($_SESSION['session_type'] == 'E'){

      
$sql= $db_9->prepare('SELECT s.subject_code AS subject_code,s.subject_name AS subject_name FROM subjects s
                        INNER JOIN marking_centre mc ON (s.subject_code = mc.subject)
                        WHERE mc.province =:province_code
                        AND mc.centre_code =:marking_centre_code');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));

$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['subject_code'] = $row['subject_code'];
        $data_array[$i]['subject_name'] = $row['subject_name'];
        $i++;
}
}else{
        $sql = $db_9->prepare('SELECT DISTINCT s.subject_code AS subject_code, s.subject_name AS subject_name FROM subjects s
                                INNER JOIN marks_prep mp ON (s.subject_code = mp.subject_code)
                                WHERE mp.province =:province_code
                                AND mp.marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':province_code'=>$_SESSION['province_code'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['subject_code'] = $row['subject_code'];
        $data_array[$i]['subject_name'] = $row['subject_name'];
        $i++;
}
}
}else{
        $sql= $db_9->prepare('SELECT subject_code,subject_name FROM subjects ');
$sql->execute();
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['subject_code'] = $row['subject_code'];
        $data_array[$i]['subject_name'] = $row['subject_name'];
        $i++;
}
}
echo json_encode($data_array);
?>