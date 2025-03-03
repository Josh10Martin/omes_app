<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
include '../../functions.php';
$data_array = array();

if(isset($_POST['subject_id'])){
        $subject_id = $_POST['subject_id'];
        $che = $_POST['che'];
        $dche = $_POST['dche'];
        $tl = $_POST['tl'];
        $ex = $_POST['ex'];
        $deo = $_POST['deo'];
try{
        $sql = $db_9->prepare('UPDATE marking_rates SET chief_examiner =:che,deputy_c_examiner=:dche, t_leader =:tl,examiner =:ex,data_entry =:deo
                                WHERE id =:subject_id');
        $sql->execute(array(
                ':che'=>$che,
                ':dche'=>$dche,
                ':tl'=>$tl,
                ':ex'=>$ex,
                ':deo'=>$deo,
                ':subject_id'=>$subject_id
        ));
                $data_array['status'] = '200';
                $data_array['che'] = $che;
                $data_array['dche'] = $dche;
                $data_array['tl'] = $tl;
                $data_array['ex'] = $ex;
                $data_array['deo'] = $deo;
                $data_array['subject_id'] = $subject_id;
                $data_array['response_msg'] = 'Marking rates updated for subject';

        
}catch(PDOException $e){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error updating: '.$e->getMessage();
}

}else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Subject id not set';
}
echo json_encode($data_array);
?>