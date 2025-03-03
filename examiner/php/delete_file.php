<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
if(isset($_POST['fileUrl'])){
    $fileUrl = $_POST['fileUrl'];
    $sql = $db_12_gce->prepare('DELETE FROM documents WHERE url =:url');
    $sql->execute(array(
        ':url'=>$fileUrl
    ));
if($sql->rowCount() > 0){
    unlink('../'.$fileUrl);
    $data_array['status'] = '200';
    $data_array['response_msg'] = 'File deletedt';
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'could not delete item';
}
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Delete parameters not set';
}
}
echo json_encode($data_array);

?>