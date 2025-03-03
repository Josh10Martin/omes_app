<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';

$data_array = array();

if(isset($_POST['marking_centre_code'])){
        $marking_centre_code = $_POST['marking_centre_code'];
        $apportion_id = apportionment_value($db_9,$_SESSION['province_code']);
        $_SESSION['apportion_id'] = $apportion_id;
        if($_SESSION['session_type'] == 'I'){
        
       
        try{
        $sql = $db_9->prepare('DELETE FROM marks_prep WHERE sen = 1 AND province =:province_code');
        $sql->execute(array(
                ':province_code'=>$_SESSION['province_code']
        ));
        $sql2 = $db_9->prepare('INSERT IGNORE INTO marks_prep(apportion_id,subject_code,sen,marking_centre,province)
                                SELECT :apportion_id, subject_code,1,:marking_centre_code,:province_code FROM subjects');
        $sql2->execute(array(
                ':apportion_id'=>$_SESSION['apportion_id'],
                ':marking_centre_code'=>$marking_centre_code,
                ':province_code'=>$_SESSION['province_code']
        ));

        $sql3 = $db_9->prepare('CALL insert_apportion_summary_sen(:apportion_id,:province_code,:session_type)');
                $sql3->execute(array(
                ':apportion_id'=>$_SESSION['apportion_id'],
                ':session_type'=>$_SESSION['session_type'],
                ':province_code'=>$_SESSION['province_code']
                ));
        if($sql3->rowCount() > 0){
           
                $data_array['status'] ='200';
                $data_array['marking_centre_code'] = $marking_centre_code;
        }else{
                $data_array['status'] ='400';
                $data_array['response_msg'] = 'There was a problem adding sen data to summary. '.$_SESSION['apportion_id'];
        }
        
}catch(PDOEXception $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
        }else{
                try{
                        $sql = $db_9->prepare('DELETE FROM marking_centre_centres WHERE sen = 1 AND province =:province_code');
                        $sql->execute(array(
                                ':province_code'=>$_SESSION['province_code']
                        ));
                        $sql2 = $db_9->prepare('INSERT IGNORE INTO marking_centre_centres(apportion_id,marking_centre,centre_code,sen,province)
                                                SELECT :apportion_id, :marking_centre_code, "none",1,:province_code');
                        $sql2->execute(array(
                                ':marking_centre_code'=>$marking_centre_code,
                                ':apportion_id'=>$_SESSION['apportion_id'],
                                ':province_code'=>$_SESSION['province_code']
                        ));
                        $data_array['status'] ='200';
                        $data_array['marking_centre_code'] = $marking_centre_code;
                }catch(PDOException $e){
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
                }
        }
        unset($_SESSION['apportion_id']);
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Marking centre parameter not set';
}
echo json_encode($data_array);
?>