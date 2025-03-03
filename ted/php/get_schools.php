<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

        $sql = $db_ted->prepare('SELECT centre_code, centre_name FROM school WHERE session =:session');
        $sql->execute(array(
                ':session'=>$_SESSION['session_year']
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
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