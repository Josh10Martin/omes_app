<?php
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
$sql = $db_9->prepare('SELECT p_code AS province_code, p_name AS province FROM province ORDER BY p_name ASC');
$sql->execute();
$i=0;
while($row = $sql->fetch(PDO:: FETCH_ASSOC)){
        $data_array[$i]['province_code'] = $row['province_code'];
        $data_array[$i]['province'] = $row['province'];
        $i++;
}
}else{
        $sql = $db_9->prepare('SELECT p_code AS province_code, p_name AS province FROM province WHERE p_code =:province_code ORDER BY p_name ASC');
        $sql->execute(array(
                ':province_code'=>$_SESSION['province_code']
        ));
        $i=0;
        while($row = $sql->fetch(PDO:: FETCH_ASSOC)){
                $data_array[$i]['province_code'] = $row['province_code'];
                $data_array[$i]['province'] = $row['province'];
                $i++;
        }
}
echo json_encode($data_array);
?>