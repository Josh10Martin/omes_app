<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');

include '../../config.php';
include '../../functions.php';
$data_array = array();

// function apportionment_value($db,$province_code){
//         $sql = $db->prepare('SELECT MAX(apportion_id) AS marking_centre_serial FROM apportionment_summary WHERE province =:province_code');
//         $sql->execute(array(
//                 ':province_code'=>$province_code
//         ));
//         $row = $sql->fetch(PDO::FETCH_ASSOC);
//         if($sql->rowCount() > 0){
//                 $marking_centre_serial = $row['marking_centre_serial'];
//                 return $marking_centre_serial + 1;
//         }else{
//                 $marking_centre_serial = 1;
//                 return $marking_centre_serial;
//         }

// }

if($_SESSION['session_type']=='I'){
        if(isset($_POST['marking_centre_code']) && isset($_POST['centre_code']) && isset($_POST['subject_code'])){
                $marking_centre_code = $_POST['marking_centre_code'];
                $centre_codes = $_POST['centre_code'];
                $subject_codes = $_POST['subject_code'];
                $sen = isset($_POST['sen']) ? '1' : '0';
                $apportion_id = apportionment_value($db_9,$_SESSION['province_code']);
                $_SESSION['apportion_id'] = $apportion_id;
                // $apportion_ids = $_SESSION['province_code'].'_'.$apportion_id;
                if(count($centre_codes) > 0 && count($subject_codes) > 0){
                        
                        try{
                                $i=0;
                        foreach($centre_codes as $centre_code){
                                foreach($subject_codes as $subject_code){
                               
                                $sql = $db_9->prepare('INSERT IGNORE INTO marks_prep (apportion_id,centre_code,subject_code,sen,marking_centre,province) VALUES(:apportion_id,:centre_code,:subject_code,:sen,:marking_centre_code,:province_code)');
                                $sql->execute(array(
                                        ':apportion_id'=>$_SESSION['apportion_id'],
                                        ':centre_code'=>$centre_code,
                                        ':subject_code'=>$subject_code,
                                        ':sen'=>$sen,
                                        ':marking_centre_code'=>$marking_centre_code,
                                        ':province_code'=>$_SESSION['province_code']
                                ));
                        }
                      $i++;
                }
                        
                        
                        $sql2 = $db_9->prepare('CALL insert_apportion_summary(:apportion_id,:province_code,:session_type)');
                        $sql2->execute(array(
                        ':apportion_id'=>$_SESSION['apportion_id'],
                        ':session_type'=>$_SESSION['session_type'],
                        ':province_code'=>$_SESSION['province_code']
                        ));
                if($sql2->rowCount() > 0){
                        unset($_SESSION['apportion_id']);
                        $data_array['status'] ='200';
                        $data_array['response_msg'] = 'Successfully apportioned subjects';
                }else{
                        $data_array['status'] ='400';
                        $data_array['response_msg'] = 'There was a problem adding some data to summary as some have subjects have already been apportioned to centres. Check summary for details';
                }
        
                        
                        
                }catch(PDOException $e){
                        $data_array['status'] ='400';
                        $data_array['response_msg'] ='There was an error: '.$e->getMessage();
                }
                }else{
                        $data_array['status'] ='400';
                        $data_array['response_msg'] ='Centres and subjects must be chosen';
                }
        }else{
                $data_array['status'] ='400';
                $data_array['response_msg'] ='Not all parameters are set';
        }
        
}else{

        if(isset($_POST['marking_centre_code']) && isset($_POST['centre_code']) && isset($_POST['subject_code'])){
                $marking_centre_code = $_POST['marking_centre_code'];
                $centre_codes = $_POST['centre_code'];
                $subject_codes = $_POST['subject_code'];
                $sen = isset($_POST['sen']) ? '1' : '0';
                $apportion_id = apportionment_value_external($db_9,$_SESSION['province_code']);
                $_SESSION['apportion_id'] = $apportion_id;
                // $apportion_ids = $_SESSION['province_code'].'_'.$apportion_id;
                if(count($centre_codes) > 0 && count($subject_codes) > 0){
                        
                try{
                        $i=0;
                        foreach($centre_codes as $centre_code){
                                foreach($subject_codes as $subject_code){
                                $sql = $db_9->prepare('INSERT IGNORE INTO marking_centre_centres (apportion_id,centre_code,subject_code,sen,marking_centre,province) VALUES(:apportion_id,:centre_code,:subject_code,:sen,:marking_centre_code,:province_code)');
                                $sql->execute(array(
                                        ':apportion_id'=>$_SESSION['apportion_id'],
                                        ':centre_code'=>$centre_code,
                                        ':subject_code'=>$subject_code,
                                        ':sen'=>$sen,
                                        ':marking_centre_code'=>$marking_centre_code,
                                        ':province_code'=>$_SESSION['province_code']
                                ));
                        
                      $i++;
                        }
                }
                        

                
                unset($_SESSION['apportion_id']);
                $data_array['status'] ='200';
                $data_array['response_msg'] = 'Successfully apportioned Centres';
                
                
                }catch(PDOException $e){
                        $data_array['status'] ='400';
                        $data_array['response_msg'] ='There was an error: '.$e->getMessage();
                }
                }else{
                        $data_array['status'] ='400';
                        $data_array['response_msg'] ='Centres and subjects must be chosen';
                }
        }else{
                $data_array['status'] ='400';
                $data_array['response_msg'] ='Not all parameters are set';
        }
        
}

echo json_encode($data_array);
?>