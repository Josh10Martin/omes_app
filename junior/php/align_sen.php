<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['session_type'] == 'I'){
    
    if($_SESSION['user_type'] == 'ECZ'){
        try{
$sql = $db_9->prepare('UPDATE marks m
                    INNER JOIN (SELECT subject_code,sen,marking_centre,province
                     FROM marks_prep) mp
                    ON (m.subject_code = mp.subject_code)
                    SET m.marking_centre = mp.marking_centre,m.province = mp.province
                    WHERE m.subject_code = mp.subject_code
                    AND m.centre_code IN (SELECT centre_code FROM school WHERE province = mp.province)
                    AND m.sen = mp.sen
                    AND m.sen = 1
                    AND m.marking_centre = "none"
                    AND m.province = "00"
                    ');
$sql->execute();
$data_array['status'] = '200';
$data_array['response_msg'] = 'Successfully aligned sen candidates';
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error aligning sen candidates: '.$e->getMessage();
}
    }else{
        try{
        $sql = $db_9->prepare('UPDATE marks m
                    INNER JOIN (SELECT subject_code,sen,marking_centre,province
                     FROM marks_prep) mp
                    ON (m.subject_code = mp.subject_code)
                    SET m.marking_centre = mp.marking_centre, m.province = mp.province
                    WHERE m.subject_code = mp.subject_code
                    AND m.sen = mp.sen
                    AND m.sen = 1
                    AND m.marking_centre = "none"
                    AND m.province = "00"
                    AND mp.province =:province_code
                    AND m.centre_code IN (SELECT centre_code FROM school WHERE province =:province_code)
                    ');
$sql->execute(array(
    ':province_code'=>$_SESSION['province_code']
));
$data_array['status'] = '200';
$data_array['response_msg'] = 'Successfully aligned sen';
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error aligning sen candidates: '.$e->getMessage();
}
    }
}else{
    
    if($_SESSION['user_type'] == 'ECZ'){
        try{
$sql = $db_9->prepare('UPDATE marks m
                    INNER JOIN (SELECT sen,marking_centre,province
                     FROM marking_centre_centres) mcc
                    ON (m.sen = mcc.sen)
                    SET m.marking_centre = mcc.marking_centre,m.province = mcc.province
                    WHERE m.centre_code IN (SELECT centre_code FROM school WHERE province = mcc.province AND centre_type =:session_type)
                    AND m.sen = mcc.sen
                    AND m.sen = 1
                    AND m.marking_centre = "none"
                    AND m.province = "00"
                    ');
$sql->execute(array(
    ':session_type'=>$_SESSION['session_type']
));
$data_array['status'] = '200';
$data_array['response_msg'] = 'Successfully aligned sen examination centres / candidates';
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error aligning sen candidates / examination centres: '.$e->getMessage();
}
    }else{
        try{
        $sql = $db_9->prepare('UPDATE marks m
                    INNER JOIN (SELECT sen,marking_centre,centre_code,province
                     FROM marking_centre_centres) mcc
                    ON (m.sen = mcc.sen)
                    SET m.marking_centre = mcc.marking_centre, m.province = mcc.province
                    WHERE m.sen = mcc.sen
                    AND m.sen = 1
                    AND m.marking_centre = "none"
                    AND m.province = "00"
                    AND mcc.province =:province_code
                    AND m.centre_code IN (SELECT centre_code FROM school WHERE province =:province_code) 
                    ');
$sql->execute(array(
    ':province_code'=>$_SESSION['province_code']
));
$data_array['status'] = '200';
$data_array['response_msg'] = 'Successfully aligned sen';
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error aligning sen candidates / examination centres: '.$e->getMessage();
}
    }
}

echo json_encode($data_array);
?>