<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['nrc_no'])){
    $nrc_no = $_POST['nrc_no'];
    $sql = $db_9->prepare('SELECT nrc FROM examiner WHERE nrc =:nrc AND marking_centre IS NULL');
    $sql->execute(array(
        ':nrc'=>$nrc_no
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $_SESSION['nrc'] = $nrc_no;
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Examiner not found';
    }

}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'nrc number not set';
}
echo json_encode($data_array);
?>