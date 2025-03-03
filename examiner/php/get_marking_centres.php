<?php
header("Access-Control-Allow-Origin: *"); 
session_start();
header("Content-Type: application/json; charset=utf-8");
include '../../config.php';
$data_array = array();
if((isset($_SESSION['user_type']) && isset($_SESSION['session_type'])) && $_SESSION['user_type'] != 'ECZ'){
$sql = $db_12_gce->prepare('SELECT DISTINCT ce.centre_code AS centre_code, ce.name AS centre_name
                        FROM centre ce INNER JOIN marking_centre mc ON (ce.centre_code = mc.centre_code)
                         WHERE  ce.centre_type =:centre_type AND ce.centre_code =:marking_centre_code');
$sql->execute(array(
        ':centre_type'=>$_SESSION['session_type'],
        ':marking_centre_code'=>$_SESSION['marking_centre_code']
));
if($sql->rowCount() > 0){
        $i=0;
        while( $row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'];
                $data_array[$i]['centre_name'] = $row['centre_name'];
                $data_array[$i]['activation_status'] = $row['centre_code'] != '' ? '1' : '0';
                $i++;
        }
}else{
        $data_array['status'] = '400';

}
}else{
        $sql = $db_12_gce->prepare('SELECT DISTINCT ce.centre_code AS centre_code, ce.name AS centre_name
                        FROM centre ce INNER JOIN marking_centre mc ON (ce.centre_code = mc.centre_code)
                        ');
$sql->execute();
if($sql->rowCount() > 0){
        $i=0;
        while( $row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'];
                $data_array[$i]['centre_name'] = $row['centre_name'];
                $data_array[$i]['activation_status'] = $row['centre_code'] != '' ? '1' : '0';
                $i++;
        }
}else{
        $data_array['status'] = '400';

}
}
echo json_encode($data_array);
?>