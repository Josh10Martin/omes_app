<?php
session_start();
header('Content-Type:application/json; charset=utf-8;');
include '../../../config.php';
$data_array = array();

    $marking_centres = json_decode(file_get_contents('https://ems.exams-council.org.zm:8080/api/ted/courses/markingcentres/'),JSON_OBJECT_AS_ARRAY);
    $i = 0;
    foreach($marking_centres as $key => $row){
        if(isset($row['marking_centre'])){
    $marking_centre_code = md5(trim(strtoupper($row['marking_centre'])));
    $marking_centre_name = trim(strtoupper($row['marking_centre']));
    $course_code = trim($row['course_code']);
    $session = substr($row['session_name'],0,4);
    $sql = $db_ted->prepare('REPLACE INTO centre (centre_code,name,session) VALUES(:centre_code,:name,:session)');
    $sql->execute(array(
        ':centre_code'=>$marking_centre_code,
        ':name'=>$marking_centre_name,
        ':session'=>$session
    ));
    if($sql->rowCount() > 0){
        $sql2 = $db_ted->prepare('INSERT IGNORE INTO marking_centre (course,centre_code,session) VALUES(:course_code,:marking_centre_code,:session)
                                    ON DUPLICATE KEY UPDATE
                                    centre_code = VALUES(centre_code)
                                    ');
        $sql2->execute(array(
            ':course_code'=>$course_code,
            ':session'=>$session,
            ':marking_centre_code'=>$marking_centre_code
        ));
        $i++;
        if($sql2->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Successfully added  and aligned subjects to marking centre(s)';
        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Coulld not add subject to marking centre';
        }
        
        
    }
   
}

}

echo json_encode($data_array);
?>