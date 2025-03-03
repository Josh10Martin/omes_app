<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['school']) && isset($_POST['subject_code']) && isset($_POST['paper']) && isset($_POST['belt_no']) && isset($_POST['group_id'])){
        $school = $_POST['school'];
        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];
        $belt_no = $_POST['belt_no'];
        $group_id = $_POST['group_id'];
        
        $sql = $db_9->prepare('DELETE FROM apportionment WHERE school =:school
                                AND subject =:subject_code
                                AND paper =:paper
                                AND belt_no =:belt_no
                                AND group_id =:group_id
                                AND marking_centre =:marking_centre_code
                                AND province =:province_code
                                AND username =:username');
                $sql->execute(array(
                        ':school'=>$school,
                        ':subject_code'=>$subject_code,
                        ':paper'=>$paper,
                        ':belt_no'=>$belt_no,
                        ':group_id'=>$group_id,
                        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
                        ':province_code'=>$_SESSION['province_code'],
                        ':username'=>$_SESSION['username'].' - '.$_SESSION['first_name'].' '.$_SESSION['last_name']
                ));
                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        
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