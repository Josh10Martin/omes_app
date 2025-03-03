<?php

session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['centre_code']) && isset($_POST['marking_centre_code'])){
        $centre_codes = $_POST['centre_code'];
        $marking_centre_code = $_POST['marking_centre_code'];
        if(count($centre_codes) > 0){
                $i =0;
                foreach($centre_codes as $key => $centre_code){
                        $sql = $db_9->prepare('INSERT IGNORE INTO marking_centre_centres (marking_centre,centre_code,province) VALUES(:marking_centre_code,:centre_code,:province_code)');
                        $sql->execute(array(
                                ':marking_centre_code'=>$marking_centre_code,
                                ':centre_code'=>$centre_code,
                                ':province_code'=>$_SESSION['province_code']
                        ));
                       $i++;
                }
                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $data_array['response_msg'] =$i.' '.' Centre(s) successfully added';
                }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Could not add centres to marking centres';
                }
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Choose checkbox';
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Checkbox not set';
}
echo json_encode($data_array);
?>