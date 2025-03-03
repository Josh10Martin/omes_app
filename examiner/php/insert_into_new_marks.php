<?php
header('COntent-Type: application/json;charset=utf-8');

include '../../config.php';
$data_array = array();
$candidates = json_decode(file_get_contents('php://input'),JSON_OBJECT_AS_ARRAY);
// $totalCount = count($candidates);
$currentCount = 0;
try{
$db_12_gce->beginTransaction();
foreach ($candidates as $key => $row){
        if(isset($row['centre_code'])){

                $centre_code = $row['centre_code'] ?? '';
                $exam_no = $row['exam_no'] ?? '';
                $first_name = $row['first_name'] ?? '';
                $last_name = $row['last_name'] ?? '';
                $subject_code = $row['subject_code'] ?? '';
                $paper_no = $row['paper_no'] ?? '';
                $mark = $row['mark'] ?? '';
                $question = $row['question'] ?? '';
                $status = $row['status'] ?? '';
                $sen = $row['sen'] ?? '';
                $improvised_mark = $row['improvised_mark'] ?? '';
                $entered_by = $row['entered_by'] ?? '';
                $date_entered = $row['date_entered'] ?? '';
                $marking_centre = $row['marking_centre'] ?? '';
               
                                               
                $sql = $db_12_gce->prepare('INSERT IGNORE INTO marks_questions(centre_code,exam_no,first_name,last_name,subject_code,paper_no,question,mark,status,sen,improvised_mark,entered_by,date_entered,marking_centre)
                                                VALUES (:centre_code,:exam_no,:first_name,:last_name,:subject_code,:paper_no,:question,:mark,:status,:sen,:improvised_mark,:entered_by,:date_entered,:marking_centre)');

                $result = $sql->execute(array(
                        ':centre_code'=>$centre_code,
                        ':exam_no'=>$exam_no,
                        ':exam_no'=>$exam_no,
                        ':first_name'=>$first_name,
                        ':last_name'=>$last_name,
                        ':subject_code'=>$subject_code,
                        ':paper_no'=>$paper_no,
                        ':question'=>$question,
                        ':mark'=>$mark,
                        ':status'=>$status,
                        ':sen'=>$sen,
                        ':improvised_mark'=>$improvised_mark,
                        ':entered_by'=>$entered_by,
                        ':date_entered'=>$date_entered,
                        ':marking_centre'=>$marking_centre
                ));
                if($result){
                        $currentCount++;
                }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Could not insert data';
                }
                      
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'centre code not set';
        }
        
        
}

$db_12_gce->commit();
$data_array['status'] = '200';
$data_array['response_msg'] = 'successfully imported into new markdheet. '.$currentCount.' row(s) inserted';

}catch(PDOEXception $e){
        $db_12_gce->rollBack();
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
       
}
echo json_encode($data_array);
?>