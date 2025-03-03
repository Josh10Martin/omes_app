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

    try{
        $sql = $db_9->prepare('UPDATE centre SET name =:marking_centre_name,centre_type =:centre_type,province =:province_code
                                WHERE centre_code =:marking_centre_code');
        $sql->execute(array(
            ':marking_centre_name'=>$centre_name,
            ':centre_type'=>$centre_type,
            ':province_code'=>$province_code,
            ':marking_centre_code'=>$centre_code
        ));

        if($sql->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Marking centre successfully edited';
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not edit marking centre. Reload the page and try again';
        }
    }catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error editing marking centre: '.$e->getMessage();
    }

}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Centre code parameter not set';
}
echo json_encode($data_array);
?>