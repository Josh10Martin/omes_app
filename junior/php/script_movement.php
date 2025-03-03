<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if($_SESSION['session_type'] == 'E'){
     // Prepare and execute the first UPDATE statement
     $in_centre_code = implode(',', array_fill(0, count($_SESSION['centre_codes']), '?'));
 try{
    $sql1 = $db_9->prepare('
        UPDATE marks
        SET marking_centre = ?,mark="0",status ="L", entered_by = "none", date_entered = "none"
        WHERE centre_code IN (' . $in_centre_code . ')
        AND marking_centre <> ?
        AND province = ?
    ');

    $params1 = array_merge([$_SESSION['marking_centre_code']], $_SESSION['centre_codes'], [$_SESSION['marking_centre_code'], $_SESSION['province_code']]);
    $sql1->execute($params1);

    // Prepare and execute the second UPDATE statement
    $sql2 = $db_9->prepare('
        UPDATE marking_centre_centres
        SET marking_centre = ?, apportion_id = ?
        WHERE centre_code IN (' .$in_centre_code . ')
        AND marking_centre <> ?
        AND province = ?
    ');

    $params2 = array_merge([$_SESSION['in_centre_code'], $_SESSION['apportion_id']], $_SESSION['centre_codes'], [$_SESSION['marking_centre_code'], $_SESSION['province_code']]);
    $sql2->execute($params2);
    $data_array['status'] = '200';
    $data_array['response_msg'] = 'successfully moved scriptsn';

    unset($_SESSION['in_centre_code']);
    unset($_SESSION['centre_codes']);
    unset($_SESSION['marking_centre_code']);
    unset($_SESSION['apportion_id']);

}catch(PDOException $e)   {
$data_array['status'] = '400';
$data_array['response_msg'] = 'There was an error moving scripts: '.$e->getMessage();
}  
}else{
    try{
        $in_centre_code = implode(', ',array_fill('0',count($_SESSION['centre_code']),'?'));
        $in_subject_code = implode(', ',array_fill('0',count($_SESSION['subject_code']),'?'));

    $sql1 = $db_9->prepare('UPDATE marks SET marking_centre = ?,entered_by ="none",date_entered="none", status ="L",mark = "0" WHERE centre_code IN('.$in_centre_code.') AND subject_code IN ('.$in_subject_code.') AND marking_centre <> ? AND sen =0 AND province = ?');
    $sql1->execute(array_merge([$_SESSION['marking_centre_code']],$_SESSION['centre_code'],$_SESSION['subject_code'],[$_SESSION['marking_centre_code'],$_SESSION['province_code']]));

    $sql2 = $db_9->prepare('UPDATE marks_prep SET marking_centre = ? WHERE centre_code IN('.$in_centre_code.') AND subject_code IN ('.$in_subject_code.') AND marking_centre <> ? AND sen =0 AND province = ?');
    $sql2->execute(array_merge([$_SESSION['marking_centre_code']],$_SESSION['centre_code'],$_SESSION['subject_code'],[$_SESSION['marking_centre_code'],$_SESSION['province_code']]));


    $sql3 = $db_9->prepare('DELETE FROM apportionment_summary WHERE province =:province_code');
    $sql3->execute(array(
    ':province_code'=>$_SESSION['province_code']
    ));

    $sql4 = $db_9->prepare('CALL insert_apportion_summary_update(:province_code,:session_type)');
    $sql4->execute(array(
    ':session_type'=>$_SESSION['session_type'],
    ':province_code'=>$_SESSION['province_code']
    ));

    unset($_SESSION['marking_centre_code']);
    unset($_SESSION['centre_code']);
    unset($_SESSION['subject_code']);

    $data_array['status'] = '200';
    $data_array['response_msg'] = 'Actioned!';
}catch(PDOException $e)   {
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There was an error moving scripts: '.$e->getMessage();
    } 
}
echo json_encode($data_array);
?>