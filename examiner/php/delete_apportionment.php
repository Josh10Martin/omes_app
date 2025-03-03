<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['school']) && isset($_POST['subject_code']) && isset($_POST['paper']) && isset($_POST['belt_no']) && isset($_POST['group_id']) && isset($_POST['sen'])){
        $school = $_POST['school'];
        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];
        $sen = $_POST['sen'];
        $belt_no = $_POST['belt_no'];
        $group_id = $_POST['group_id'];
        
        $sql = $db_12_gce->prepare('DELETE FROM apportionment WHERE school =:school
                                AND subject =:subject_code
                                AND paper =:paper
                                AND sen =:sen
                                AND belt_no =:belt_no
                                AND group_id =:group_id
                                AND marking_centre =:marking_centre_code
                                ');
                $sql->execute(array(
                        ':school'=>$school,
                        ':subject_code'=>$subject_code,
                        ':paper'=>$paper,
                        ':sen'=>$sen,
                        ':belt_no'=>$belt_no,
                        ':group_id'=>$group_id,
                        ':marking_centre_code'=>$_SESSION['marking_centre_code']
                        
                ));
                if($sql->rowCount() > 0){
                       
                        $sql2 = $db_12_gce->prepare('UPDATE marks SET mark = 0,status = "L",belt_no = 0, entered_by = "none",date_entered = "none", disable = 0 
                        WHERE centre_code =:centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND marking_centre =:marking_centre_code

                        ');
                         $sql2->execute(array(
                                ':centre_code'=>$school,
                                ':subject_code'=>$subject_code,
                                ':paper_no'=>$paper,
                                ':marking_centre_code'=>$_SESSION['marking_centre_code']
                                
                        ));

                        if($sql2->rowCount() > 0){
                                $data_array['status'] = '200';
                        }else{
                                $data_array['status'] = '400';
                                $data_array['response_msg'] = 'Could not reset marksheet. Please try again';
                        }
                        
                }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Could not delete centre. Please try again';
                }
        

}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters are set for deletion. Try again';
}
echo json_encode($data_array);
?>