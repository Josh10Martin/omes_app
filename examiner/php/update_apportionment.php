<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['school']) && isset($_POST['script_no']) && isset($_POST['subject_code']) && isset($_POST['paper']) && isset($_POST['belt_no']) && isset($_POST['group_id']) && isset($_POST['sen'])){
        $school = $_POST['school'];
        $script_no = $_POST['script_no'];
        $subject_code = $_POST['subject_code'];
        $paper = $_POST['paper'];
        $sen = $_POST['sen'];
        $belt_no = $_POST['belt_no'];
        $group_id = $_POST['group_id'];
        // $script_no = preg_match('/^[1-9][0-9]*$/',$script_no);
        if(!$script_no){
                $data_array['status'] = '400';
                $data_array['response_msg'] = "Please enter correct script number";
        }else{
                $sql = $db_12_gce->prepare('UPDATE apportionment SET script_no =:script_no WHERE school =:school
                                                AND subject =:subject_code
                                                AND paper =:paper
                                                AND sen =:sen
                                                AND belt_no =:belt_no
                                                AND group_id =:group_id
                                                AND marking_centre =:marking_centre_code
                                                ');
                $sql->execute(array(
                        ':script_no'=>$script_no,
                        ':school'=>$school,
                        ':subject_code'=>$subject_code,
                        ':paper'=>$paper,
                        ':sen'=>$sen,
                        ':belt_no'=>$belt_no,
                        ':group_id'=>$group_id,
                        ':marking_centre_code'=>$_SESSION['marking_centre_code']
                ));
                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $data_array['script_no'] = $script_no;
                }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Could not update centre. Please try again';
                }
        }

}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not all parameters are set. Try again';
}
echo json_encode($data_array);
?>