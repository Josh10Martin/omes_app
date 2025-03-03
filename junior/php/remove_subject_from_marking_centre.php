<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();
if(isset($_POST['marking_centre_code']) && isset($_POST['subject_code'])){
        $marking_centre_code = $_POST['marking_centre_code'];
        $subject = $_POST['subject_code'];
        $i=0;
        if(count($subject) > 0){
        try{
        foreach($subject as $subject_code){
                $sql = $db_9->prepare('DELETE FROM marking_centre WHERE province =:province_code AND subject =:subject_code AND centre_code =:marking_centre_code');
                $sql->execute(array(
                        ':province_code'=>$_SESSION['province_code'],
                        ':subject_code'=>$subject_code,
                        ':marking_centre_code'=>$marking_centre_code
                ));
                $data_array[$i]['subject_code'] = $subject_code;
                $data_array[$i]['subject_name'] = subject_name($db_9,$subject_code);
                $i++;
        }
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was a problem removinng subjects from marking centre';
        }
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'You need to choose the subjects to remove';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters are set to remove subjects';
}
echo json_encode($data_array);

?>