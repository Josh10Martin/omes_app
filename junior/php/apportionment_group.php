<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();

if(isset($_POST['belt_no'])){
        $belt_no = $_POST['belt_no'];
        $subject_code = $_POST['subject'];
        $paper_no = $_POST['paper'];
        $id = $_SESSION['province_code'].'_'.$_SESSION['marking_centre_code'].'_'.$subject_code.'_'.$paper_no.'_'.$belt_no;
        $belt = belt_added($db_9,$belt_no,$subject_code,$paper_no,$_SESSION['marking_centre_code'],$_SESSION['province_code']);
        
        // $school = isset($_POST['centre_code']) ? $_POST['centre_code'] : '0';
        // $script_no = isset($_POST['script_no']) ? $_POST['script_no'] : '0';
        // $script_no = preg_match('/[\d]+/',$school);
        // $centre_in_belt = centre_in_belt($db_9,$school,$subject_code,$paper_no,$_SESSION['marking_centre_code'],$_SESSION['province_code']);
        
        if(!$belt_no){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Please enter a belt number';
}else if($belt != 'false'){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Belt number '.$belt_no.' is already created for this particular subject and paper';

        }else{
                try{
                $sql = $db_9->prepare('INSERT IGNORE INTO group_apportion(id,subject,paper,belt_no,marking_centre,province,username,date_created)
                                        VALUES(:id,:subject_code,:paper_no,:belt_no,:marking_centre_code,:province_code,:username,NOW())');
                $sql->execute(array(
                        ':subject_code'=>$subject_code,
                        ':paper_no'=>$paper_no,
                        ':belt_no'=>$belt_no,
                        ':id'=>$id,
                        ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name'],
                        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                        ':province_code'=>$_SESSION['province_code']
                ));
                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $data_array['id'] = $id;
                }else{
                        $data_array['status'] = '400';
                        $data_array['try'] = 'true';
                         $data_array['response_msg'] = 'There was a problem creating belt. Please try again ';
                }
        }catch(PDOEXCEPTION $e){
                $data_array['status'] = '400';
                 $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
        }
        }
        
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Belt parameter not set. Try again';
}
echo json_encode($data_array);
?>