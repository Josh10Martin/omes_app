<?php
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

$sql = $db_12_gce->prepare('UPDATE marks SET valid = 1 WHERE valid = 0');
$sql->execute();
if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Marksheet has been successfully loaded';
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not finalize loading of marksheet. It could be that this marksheet is loaded';
}
echo json_encode($data_array);
?>