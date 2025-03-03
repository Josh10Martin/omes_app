<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['province_code'])){
        $province_code = $_POST['province_code'];
$sql= $db_9->prepare('SELECT centre_code,name FROM centre 
                        WHERE province=:province_code AND centre_type =:session_type');
$sql->execute(array(
        ':province_code'=>$_POST['province_code'],
        ':session_type'=>$_SESSION['session_type']
));
if($sql->rowCount() > 0){

$i=0;
while($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $data_array[$i]['marking_centre_code'] = $row['centre_code'];
        $data_array[$i]['marking_centre_name'] = $row['name'];
        $i++;
}
}else{
        $data_array['status'] = '400';
}
}
echo json_encode($data_array);
?>