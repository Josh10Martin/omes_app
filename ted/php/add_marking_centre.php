<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();
if(isset($_POST['centre_code'])){

$centre_code = $_POST['centre_code'];
$centre_name = $_POST['centre_name'];
$centre_type = $_POST['centre_type'];
$province_code = explode(':',$_POST['province'] ?? '')[0];

if(marking_centre_exists($db_ted,$centre_code) != 'false'){
$data_array['status'] = '400';
$data_array['response_msg'] = 'Centre code '.marking_centre_exists($db_ted,$centre_code).' is already in us. use another code';
}else{
try{
        $sql = $db_ted->prepare('INSERT IGNORE INTO centre(centre_code,name,centre_type,province)
                                VALUES (:centre_code,:centre_name,:centre_type,:province_code)');
        $sql->execute(array(
                ':centre_code'=>$centre_code,
                ':centre_name'=>$centre_name,
                ':centre_type'=>$centre_type,
                ':province_code'=>$province_code
        ));
        if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $data_array['response_msg'] = 'Marking centre successfully registered';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not add marking centre. Reload the page and try again';
        }
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}

}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Centre code parameter not set';
}
echo json_encode($data_array);
?>