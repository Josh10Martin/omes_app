<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$marks_content = json_decode(file_get_contents('update_marks_question.php'),JSON_OBJECT_AS_ARRAY);

try{
       
        $db_12_gce->beginTransaction();
        
        foreach($marks_content as $key => $row){
                if(isset($row['centre_code'])){
                        $centre_code = $row['centre_code'] ?? '';
                        $exam_no = $row['exam_no'] ?? '';
                        $subject_code = $row['subject_code'] ?? '';
                        $paper_no = $row['paper_no'] ?? '';
                        $mark = $row['total_mark'] ?? '';
                        $status = $row['status'] ?? '';
                        $entered_by = $row['entered_by'] ?? '';
                        $date_entered = $row['date_entered'] ?? '';
                        $marking_centre_code = $row['marking_centre_code'] ?? '';

                        $sql = $db_12_gce->prepare('UPDATE marks SET mark =:mark,status =:status,entered_by =:entered_by,date_entered =:date_entered 
                                                        WHERE centre_code =:centre_code AND exam_no =:exam_no AND subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code');
                        $sql->execute(array(
                                ':mark'=>$mark,
                                ':status'=>$status,
                                ':entered_by'=>$entered_by,
                                ':date_entered'=>$date_entered,
                                ':centre_code'=>$centre_code,
                                ':exam_no'=>$exam_no,
                                ':subject_code'=>$subject_code,
                                ':paper_no'=>$paper_no,
                                ':marking_centre_code'=>$marking_centre_code
                        ));
                }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Centre code was not set';
                        break;
        }
        }
        $db_12_gce->commit();
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Successfully save marks';

}catch(PDOEXception $e){
        $db_12_gce->rollBack();
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
echo json_encode($data_array);
?>