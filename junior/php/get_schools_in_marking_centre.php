<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
        if($_SESSION['user_type'] == 'ECZ'){
                if(isset($_POST['marking_centre_code'])){
                        $marking_centre_code =$_POST['marking_centre_code'];
                
                $sql = $db_9->prepare('SELECT centre_code, centre_name FROM school WHERE centre_type =:session_type
                                        AND centre_code IN (SELECT centre_code FROM marks WHERE marking_centre =:marking_centre_code)');
        $sql->execute(array(
                ':marking_centre_code'=>$_POST['marking_centre_code'],
                ':session_type'=>$_SESSION['session_type']
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
        }
        }else{
        $sql = $db_9->prepare('SELECT centre_code, centre_name FROM school WHERE province =:province_code AND centre_type =:session_type 
                                AND centre_code IN (SELECT centre_code FROM marks WHERE marking_centre =:marking_centre_code)');
        $sql->execute(array(
                ':session_type'=>$_SESSION['session_type'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                ':province_code'=>$_SESSION['province_code']
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
        }
echo json_encode($data_array);
?>