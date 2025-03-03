<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['marking_centre']) && isset($_POST['dis_enable'])){
      $marking_centre_code = $_POST['marking_centre'];
      $dis_enable = $_POST['dis_enable'];
      $subject_code = isset($_POST['subject_code']) ? $_POST['subject_code'] : '';
      $paper_no = isset($_POST['paper_no']) ? $_POST['paper_no'] : '';
      $centre_code = isset($_POST['centre_code']) ? $_POST['centre_code'] : '';
      $sen = isset($_POST['sen']) ? $_POST['sen'] : '';

      $lock_status = $dis_enable == 1 ? 'locked' : 'disabled';

      if($marking_centre_code == 'all'){
            try{
            $sql = $db_12_gce->prepare('UPDATE marks SET disable = :dis_enable WHERE sen =:sen');
            $sql->execute(array(
                  ':dis_enable'=>$dis_enable,
                  ':sen'=>$sen
            ));
            if($sql->rowCount() > 0){
                  $data_array['status'] = '200';
                  $data_array['response_msg'] = 'Marksheet successfully '.$lock_status.' for selected parameters';
            }else{
                  $data_array['status'] = '400';
                  $data_array['response_msg'] = 'Could not carry out the task. Marksheet may already be '.$lock_status.' for selected parameters';
            }
      }catch(PDOException $e){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Error: '.$e->getMessage();
      }
      }else{
            if($subject_code == 'all'){
                  try{
                  $sql = $db_12_gce->prepare('UPDATE marks SET disable = :dis_enable WHERE marking_centre =:marking_centre_code AND sen =:sen');
                  $sql->execute(array(
                        ':dis_enable'=>$dis_enable,
                        ':sen'=>$sen,
                        ':marking_centre_code'=>$marking_centre_code
                  ));
                  if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $data_array['response_msg'] = 'Marksheet successfully '.$lock_status.' for selected parameters';
                  }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Could not carry out the task. Marksheet may already be '.$lock_status.' for selected parameters';
                  }
            }catch(PDOException $e){
                  $data_array['status'] = '400';
                  $data_array['response_msg'] = 'Error: '.$e->getMessage();
            }
            }else{
                  if($centre_code == 'all'){
                        try{
                        $sql = $db_12_gce->prepare('UPDATE marks SET disable = :dis_enable WHERE marking_centre =:marking_centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND sen =:sen');
                        $sql->execute(array(
                              ':dis_enable'=>$dis_enable,
                              ':sen'=>$sen,
                              ':subject_code'=>$subject_code,
                              ':paper_no'=>$paper_no,
                              ':marking_centre_code'=>$marking_centre_code
                        ));
                        if($sql->rowCount() > 0){
                              $data_array['status'] = '200';
                              $data_array['response_msg'] = 'Marksheet successfully '.$lock_status.' for selected parameters';
                        }else{
                              $data_array['status'] = '400';
                              $data_array['response_msg'] = 'Could not carry out the task. Marksheet may already be '.$lock_status.' for selected parameters';
                        }
                  }catch(PDOException $e){
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Error: '.$e->getMessage();
                  }
                  }else{
                        try{
                        $sql = $db_12_gce->prepare('UPDATE marks SET disable = :dis_enable WHERE marking_centre =:marking_centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND sen =:sen');
                        $sql->execute(array(
                              ':dis_enable'=>$dis_enable,
                              ':sen'=>$sen,
                              ':subject_code'=>$subject_code,
                              ':paper_no'=>$paper_no,
                              ':centre_code'=>$centre_code,
                              ':marking_centre_code'=>$marking_centre_code
                        ));
                        if($sql->rowCount() > 0){
                              $data_array['status'] = '200';
                              $data_array['response_msg'] = 'Marksheet successfully '.$lock_status.' for selected parameters';
                        }else{
                              $data_array['status'] = '400';
                              $data_array['response_msg'] = 'Could not carry out the task. Marksheet may already be '.$lock_status.' for selected parameters';
                        }
                  }catch(PDOException $e){
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Error: '.$e->getMessage();
                  }
                  }
            }
      }

}else{
      $data_array['status'] = '400';
      $data_array['response_msg'] = 'Not all parameters are set';
}
echo json_encode($data_array);
?>