<?php
session_start();
header('Content-Type:application/json; charset=utf-8;');
include '../../config.php';
$data_array = array();
// if(isset($row['marking_centre_code']) && isset($row['marking_centre_name']) && isset($row['centre_type']) && isset($row['subject_code']) && isset($row['paper_no'])){
    $marking_centres = json_decode(file_get_contents('https://ems.exams-council.org.zm:8080/api/marking-centers/api-ems/'),JSON_OBJECT_AS_ARRAY);
    $i = 0;
    foreach($marking_centres as $key => $row){
        if(isset($row['marking_centre_name'])){
    $marking_centre_code = md5(trim(strtoupper($row['marking_centre_name'] ?? '')));
    $marking_centre_name = trim(strtoupper($row['marking_centre_name'] ?? ''));
    $centre_type = trim(strtoupper($row['centre_type'] ?? ''));
    $subject_code = trim($row['subject_code'] ?? '');
    $paper_no = trim($row['paper_no'] ?? '');
    $sql = $db_12_gce->prepare('REPLACE INTO centre (centre_code,name,centre_type) VALUES(:centre_code,:name,:centre_type)');
    $sql->execute(array(
        ':centre_code'=>$marking_centre_code,
        ':name'=>$marking_centre_name,
        ':centre_type'=>$centre_type
    ));
    if($sql->rowCount() > 0){
        $sql2 = $db_12_gce->prepare('INSERT IGNORE INTO marking_centre (subject,paper,centre_code) VALUES(:subject_code,:paper_no,:centre_code)');
        $sql2->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':centre_code'=>$marking_centre_code
        ));
        $i++;
        if($sql2->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Successfully added '.$i.' marking centre(s)';
        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Coulld not add subject to marking centre';
        }
        
        
    }
    // else{
    //     $data_array['status'] = '400';
    //     $data_array['response_msg'] = 'Could not add marking centres';
    // }
}

}

// }else{
//     $data_array['status'] = '400';
//     $data_array['response_msg'] = 'Not all marking centre parameters are set';
// }
echo json_encode($data_array);
?>