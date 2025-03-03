<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['marking_centre_code'])){
        $marking_centre_code = $_POST['marking_centre_code'];
$sql= $db_9->prepare('SELECT subject_code,subject_name FROM subjects
                       WHERE subject_code NOT IN (SELECT subject FROM marking_centre WHERE province =:province_code)
                       ');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code']
));
if($sql->rowCount() > 0){

$data_array['status'] = '200';
$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['subject_code'] = $row['subject_code'];
        $data_array[$i]['subject_name'] = $row['subject_name'];
        $i++;
}
}else{
        $data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>