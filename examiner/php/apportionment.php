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
        $id = $_POST['id'];
        // $school_added = school_added($db_9,$belt_no,$subject_code,$paper_no,$_SESSION['marking_centre_code'],$_SESSION['province_code']);
        
        $school = isset($_POST['centre_code']) && !empty($_POST['centre_code']) ? $_POST['centre_code'] : (isset($_POST['centre_code2']) && !empty($_POST['centre_code2']) ? $_POST['centre_code2'] : '0');
        $_SESSION['school'] = $_POST['centre_code'];
        $_SESSION['school2'] = $_POST['centre_code2'];
        $script_no = isset($_POST['script_no']) ? $_POST['script_no'] : '0';
        // $script_no = preg_match('/^[1-9][0-9]*$/',$script_no);
        // $centre_in_belt = centre_in_belt($db_9,$school,$subject_code,$paper_no,$_SESSION['marking_centre_code'],$_SESSION['province_code']);
        $centre_in_belt = centre_in_belt_g12_gce($db_12_gce,$subject_code,$paper_no,$school,$_SESSION['marking_centre_code'],$belt_no);
        
        if(!$belt_no){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Please enter a belt number';
}else if(!$script_no){
                $data_array['status'] = '400';
                $data_array['response_msg'] = "Please enter correct script number";
        }else if($centre_in_belt != 'false'){
                $data_array['status'] = '400';
                $data_array['response_msg'] = $centre_in_belt;

        }else if(school_exists($db_12_gce,$school) == 'false'){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Centre '.$school.' entered is not found';
        }else{
                try{
                $sql = $db_12_gce->prepare('INSERT IGNORE INTO apportionment(group_id,subject,paper,belt_no,script_no,school,marking_centre,username,date_apportioned)
                                        VALUES(:id,:subject_code,:paper_no,:belt_no,:script_no,:school,:marking_centre_code,:username,NOW())');
                $sql->execute(array(
                        ':subject_code'=>$subject_code,
                        ':paper_no'=>$paper_no,
                        ':belt_no'=>$belt_no,
                        ':id'=>$id,
                        ':school'=>$school,
                        ':script_no'=>$script_no,
                        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                        ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name']
                ));
                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
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