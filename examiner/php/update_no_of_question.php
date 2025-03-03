<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['id']) && isset($_POST['no_of_questions'])){
        $id = $_POST['id'];
        $no_of_questions = $_POST['no_of_questions'];
        try{
                $sql = $db_12_gce->prepare('UPDATE paper SET max_questions =:max_questions WHERE id =:id');
                $sql->execute(array(
                        ':max_questions'=>$no_of_questions,
                        ':id'=>$id
                ));
                $data_array['status'] = '200';
                $data_array['id'] = $id;
                $data_array['no_of_questions'] = $no_of_questions;
                $data_array['response_msg'] = 'Successfully updated maxmimum number of questions for subject';
        }catch(PDOException $e){
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
        }

}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Not All parameters are set';
}
echo json_encode($data_array);
?>