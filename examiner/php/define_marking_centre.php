<?php
session_start();
header('Content-Type:application/json; charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['subject_code'])){
    $subject_code = $_POST['subject_code'];
    $subject_name = $_POST['subject_name'];
    $paper_no = $_POST['paper'];
    $marking_centre_code = $_POST['marking_centre_code'];
    $marking_centre_name = $_POST['marking_centre_name'];
try{
    $sql = $db_9->prepare('INSERT IGNORE INTO marking_centre(province,subject,centre_code)
                        VALUES(:province_code,:subject_code,:centre_code)');
    $sql->execute(array(
        ':province_code'=>$_SESSION['province_code'],
        ':subject_code'=>$subject_code,
        ':centre_code'=>$marking_centre_code
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = $subject_name.' paper '.$paper_no.' has been attached to '.$marking_centre_name;
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem in attaching '.$subject_name.' to '.$marking_centre_name.'. Please try again';
    }
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Parameters not set. Reload the page and try again';
}
echo json_encode($data_array);

?>