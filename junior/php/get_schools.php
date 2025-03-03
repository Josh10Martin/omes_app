<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

// if($_SESSION['province_code'] == 11){
//         $sql = $db_9->prepare('SELECT centre_code, centre_name FROM school WHERE centre_type =:session_type');
//         $sql->execute(array(
//                 ':session_type'=>$_SESSION['session_type']
//         ));
//         if($sql->rowCount() > 0){
//                 $i=0;
//                 while($row = $sql->fetch(PDO::FETCH_ASSOC)){
//                     $data_array[$i]['centre_code'] = $row['centre_code'];
//                     $data_array[$i]['centre_name'] = $row['centre_name'];
//                     $i++;
//                 }
               
//         }else{
//                 $data_array['status'] = '400';
//         }
// }else{

        $sql = $db_9->prepare('SELECT centre_code, centre_name FROM school WHERE province =:province_code AND centre_type =:session_type');
        $sql->execute(array(
                ':session_type'=>$_SESSION['session_type'],
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
// }
echo json_encode($data_array);
?>