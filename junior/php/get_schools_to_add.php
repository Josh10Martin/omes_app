<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

        $sql = $db_9->prepare('SELECT centre_code, centre_name FROM school WHERE province =:province_code AND centre_code NOT IN (SELECT centre_code FROM marking_centre_centres) ORDER BY centre_code ASC');
        $sql->execute(array(
                ':province_code'=>$_SESSION['province_code']
        ));
        if($sql->rowCount() > 0){
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