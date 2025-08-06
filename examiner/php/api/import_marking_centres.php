<?php
session_start();
header('Content-Type:application/json; charset=utf-8;');
include '../../../config.php';
$data_array = array();

    $marking_centres = json_decode(file_get_contents('php://input'),JSON_OBJECT_AS_ARRAY);
    $i = 0;
    foreach($marking_centres as $key => $row){
        if(isset($row['marking_centre_name'])){
    $marking_centre_code = md5(trim(strtoupper($row['marking_centre_name'])));
    $marking_centre_name = trim(strtoupper($row['marking_centre_name']));
    $centre_type = trim(strtoupper($row['centre_type']));
    $subject_code = trim($row['subject_code']);
    $paper_no = trim($row['paper_no']);
    $sen = trim($row['sen']);
    try{
    $sql = $db_12_gce->prepare('INSERT IGNORE INTO centre (centre_code,name,centre_type) VALUES(:centre_code,:name,:centre_type)');
    $sql->execute(array(
        ':centre_code'=>$marking_centre_code,
        ':name'=>$marking_centre_name,
        ':centre_type'=>$centre_type
    ));
    
        $sql2 = $db_12_gce->prepare('INSERT INTO marking_centre (sen,subject,paper,centre_code) VALUES(:sen,:subject_code,:paper_no,:centre_code)
                                    ON DUPLICATE KEY UPDATE
                                    centre_code = VALUES(centre_code)
                                    ');
        $sql2->execute(array(
            ':sen'=>$sen,
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':centre_code'=>$marking_centre_code
        ));
        $i++;
         
    }catch(PDOException $e){
         $data_array['status'] = '400';
        $data_array['response_msg'] = 'Erroe: '.$e->getMessage();
    }
      
        
}

}
if( $i > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Successfully added  and aligned subjects to marking centre(s)';
}else{
     $data_array['status'] = '400';
    $data_array['response_msg'] = 'No marking centres were successfully processed.';
}
echo json_encode($data_array);
?>