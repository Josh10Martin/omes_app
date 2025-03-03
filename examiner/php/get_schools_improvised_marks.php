<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

        $sql = $db_12_gce->prepare('SELECT centre_code, centre_name FROM school WHERE centre_type =:centre_type AND centre_code IN (SELECT centre_code FROM marks WHERE improvised_mark = 1 AND marking_centre =:marking_centre_code)');
        $sql->execute(array(
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':centre_type'=>$_SESSION['session_type']
        ));
        if($sql->rowCount() > 0){
                // $row = $sql->fetch(PDO::FETCH_ASSOC);
                $data_array['status'] = '200';
                // $data_array[0]['centre_code'] = $row['centre_code'];
                // $data_array[0]['centre_name'] = $row['centre_name'];
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                    $data_array[$i]['centre_code'] = $row['centre_code'];
                    $data_array[$i]['centre_name'] = $row['centre_name'];
                    $i++;
                }
               
        }else{
                $data_array['status'] = '400';
        }
echo json_encode($data_array);
?>