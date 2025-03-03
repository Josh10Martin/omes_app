<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if($_SESSION['session_type']=='I'){
        if(isset($_POST['id'])){
                $id = $_POST['id'];
                try{
                $sql = $db_9->prepare('DELETE FROM apportionment_summary WHERE apportion_id =:id AND province =:province_code');
                $sql->execute(array(
                        ':id'=>$id,
                        ':province_code'=>$_SESSION['province_code']
                ));
               
                $sql2 = $db_9->prepare('DELETE FROM marks_prep WHERE apportion_id =:id AND province =:province_code');
                $sql2->execute(array(
                        ':id'=>$id,
                        ':province_code'=>$_SESSION['province_code']
                ));
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'SUccessfully deleted script movement';
        }catch(PDOException $e){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
        }   
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Apportionment parameter id not set';
        }
}else{
        if(isset($_POST['id'])){
                $id = $_POST['id'];
                try{
                $sql = $db_9->prepare('DELETE FROM marking_centre_centres WHERE apportion_id =:id AND province =:province_code');
                $sql->execute(array(
                        ':id'=>$id,
                        ':province_code'=>$_SESSION['province_code']
                ));

                $data_array['status'] = '200';
                $data_array['response_msg'] = 'Successfully deleted the apportionments';
        }catch(PDOException $e){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
        }   
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Apportionment parameter id not set';
        }
}

echo json_encode($data_array);
?>