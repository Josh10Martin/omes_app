<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();

if(isset($_POST['total_scripts_no'])){
      $total_scripts_no = $_POST['total_scripts_no'];
      if(!preg_match('/^\d+$/', $total_scripts_no)){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Error: Enter a digit';
      }else if($total_scripts_no == 0){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Enter a valid number';
      }else{
            $sql = $db_9->prepare('INSERT INTO transcriber_script_no (no_of_scripts,marking_centre) VALUES(:no_of_scripts,:marking_centre_code)
                                    ON DUPLICATE KEY UPDATE
                                    no_of_scripts = VALUES(no_of_scripts)
                                    ');
            $sql->execute(array(
                  ':no_of_scripts'=>$total_scripts_no,
                  ':marking_centre_code'=>$_SESSION['marking_centre_code']
            ));
            if($sql->rowCount() > 0){
                  $data_array['status'] = '200';
                  $data_array['response_msg'] = 'Value successfully set';
            }else{
                  $data_array['status'] = '400';
                  $data_array['response_msg'] = 'Could not set new value';
            }

      }

}else{
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Script number parameter not set';
}
echo json_encode($data_array);
?>