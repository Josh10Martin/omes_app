<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if($_SESSION['session_type']=='I'){
        if(isset($_POST['apportioned_id'])){
                $apportioned_id = $_POST['apportioned_id'];
        
                $sql = $db_9->prepare('SELECT sc.centre_code AS centre_code, sc.centre_name AS centre_name FROM school sc INNER JOIN marks_prep mp ON (sc.centre_code = mp.centre_code)
                                        WHERE mp.apportion_id =:apportioned_id AND mp.province =:province_code AND mp.province = sc.province');
                $sql->execute(array(
                        ':apportioned_id'=>$apportioned_id,
                        ':province_code'=>$_SESSION['province_code']
                ));
                if($sql->rowCount() > 0){
                        // $data_array['status'] = '200';
                        $i = 0;
                        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                                $i++;
                        }
                }else{
                        $data_array['status'] = '400';
                         $data_array['response_msg'] = 'No centres found';
                }
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'apportioned id parameter nor set';
        }
}else{
        if(isset($_POST['apportioned_id'])){
                $apportioned_id = $_POST['apportioned_id'];
        
                $sql = $db_9->prepare('SELECT sc.centre_code AS centre_code, sc.centre_name AS centre_name 
                                        FROM school sc 
                                        INNER JOIN marking_centre_centres mcc ON (sc.centre_code = mcc.centre_code)
                                        WHERE mcc.apportion_id =:apportioned_id AND sc.province =:province_code 
                                        ');
                $sql->execute(array(
                        ':apportioned_id'=>$apportioned_id,
                        ':province_code'=>$_SESSION['province_code']
                ));
                if($sql->rowCount() > 0){
                        // $data_array['status'] = '200';
                        $i = 0;
                        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                                $i++;
                        }
                }else{
                        $data_array['status'] = '400';
                         $data_array['response_msg'] = 'No centres found';
                }
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'apportioned id parameter nor set';
        }
}
echo json_encode($data_array);
?>