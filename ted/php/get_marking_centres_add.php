<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();

$sql = $db_9->prepare('SELECT centre_code, name FROM centre WHERE province =:province_code AND centre_type =:centre_type');
$sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':centre_type'=>$_SESSION['session_type']
));
if($sql->rowCount() > 0){
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $data_array[0]['centre_code'] = $row['centre_code'];
        $data_array[0]['centre_name'] = $row['name'];
        $i=1;
        while( $row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'];
                $data_array[$i]['centre_name'] = $row['name'];
                $i++;
        }
}
echo json_encode($data_array);
?>