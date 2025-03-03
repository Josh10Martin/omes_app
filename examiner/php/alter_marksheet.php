<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['marking_centre']) && isset($_POST['sen']) && isset($_POST['marking_centre2'])){
      $marking_centre_code = $_POST['marking_centre'];
      $marking_centre_code2 = $_POST['marking_centre2'];
      $sen = $_POST['sen'];
      $subject_code = isset($_POST['subject_code']) ? $_POST['subject_code'] : '';
      $paper_no = isset($_POST['paper_no']) ? $_POST['paper_no'] : '';
      $centre_code = isset($_POST['centre_code']) ? $_POST['centre_code'] : '';

      if($marking_centre_code == 'all'){
            if($sen == 'all'){
                  try{
                        $sql = $db_12_gce->prepare('UPDATE marks SET marking_centre =:marking_centre_code2 WHERE status = "L"');
                        $sql->execute(array(
                         ':marking_centre_code2'=>$marking_centre_code2
                        ));
                        if($sql->rowCount() > 0){
                              $data_array['status'] = '200';
                              $data_array['response_msg'] = 'Marksheet successfuly altered for missing marks';
                        }else{
                              $data_array['status'] = '400';
                              $data_array['response_msg'] = 'Could nt alter marksheet. Search the marksheet and try again';
                        }
                   }catch(PDOException $e){
                         $data_array['status'] = '400';
                         $data_array['response_msg'] = 'Error: '.$e->getMessage();
                   }
            }else{
                  try{
                        $sql = $db_12_gce->prepare('UPDATE marks SET marking_centre =:marking_centre_code2 WHERE status = "L" AND sen =:sen');
                        $sql->execute(array(
                         ':marking_centre_code2'=>$marking_centre_code2,
                         ':sen'=>$sen
                        ));
                        if($sql->rowCount() > 0){
                              $data_array['status'] = '200';
                              $data_array['response_msg'] = 'Marksheet successfuly altered for missing marks';
                        }else{
                              $data_array['status'] = '400';
                              $data_array['response_msg'] = 'Could nt alter marksheet. Search the marksheet and try again';
                        }
                   }catch(PDOException $e){
                         $data_array['status'] = '400';
                         $data_array['response_msg'] = 'Error: '.$e->getMessage();
                   }
            }
      }else{
            if($subject_code == 'all'){
                  if($sen == 'all'){
                        try{
                              $sql = $db_12_gce->prepare('UPDATE marks SET marking_centre =:marking_centre_code2 WHERE status = "L" AND marking_centre =:marking_centre_code');
                              $sql->execute(array(
                               ':marking_centre_code2'=>$marking_centre_code2,
                               ':marking_centre_code'=>$marking_centre_code
                              ));
                              if($sql->rowCount() > 0){
                                    $data_array['status'] = '200';
                                    $data_array['response_msg'] = 'Marksheet successfuly altered for missing marks';
                              }else{
                                    $data_array['status'] = '400';
                                    $data_array['response_msg'] = 'Could nt alter marksheet. Search the marksheet and try again';
                              }
                         }catch(PDOException $e){
                               $data_array['status'] = '400';
                               $data_array['response_msg'] = 'Error: '.$e->getMessage();
                         }
                  }else{
                        try{
                        $sql = $db_12_gce->prepare('UPDATE marks SET marking_centre =:marking_centre_code2 WHERE status = "L" AND marking_centre =:marking_centre_code AND sen =:sen');
                              $sql->execute(array(
                               ':marking_centre_code2'=>$marking_centre_code2,
                               ':marking_centre_code'=>$marking_centre_code,
                               ':sen'=>$sen
                              ));
                              if($sql->rowCount() > 0){
                                    $data_array['status'] = '200';
                                    $data_array['response_msg'] = 'Marksheet successfuly altered for missing marks';
                              }else{
                                    $data_array['status'] = '400';
                                    $data_array['response_msg'] = 'Could nt alter marksheet. Search the marksheet and try again';
                              }
                         }catch(PDOException $e){
                               $data_array['status'] = '400';
                               $data_array['response_msg'] = 'Error: '.$e->getMessage();
                         }
                  }
            }else{
                  if($centre_code == 'all'){
                        if($sen == 'all'){
                              try{
                                    $sql = $db_12_gce->prepare('UPDATE marks SET marking_centre =:marking_centre_code2 WHERE status = "L" AND marking_centre =:marking_centre_code AND subject_code =:subject_code AND paper_no =:paper_no');
                                          $sql->execute(array(
                                           ':marking_centre_code2'=>$marking_centre_code2,
                                           ':marking_centre_code'=>$marking_centre_code,
                                           ':subject_code'=>$subject_code,
                                           ':paper_no'=>$paper_no
                                          ));
                                          if($sql->rowCount() > 0){
                                                $data_array['status'] = '200';
                                                $data_array['response_msg'] = 'Marksheet successfuly altered for missing marks';
                                          }else{
                                                $data_array['status'] = '400';
                                                $data_array['response_msg'] = 'Could nt alter marksheet. Search the marksheet and try again';
                                          }
                                     }catch(PDOException $e){
                                           $data_array['status'] = '400';
                                           $data_array['response_msg'] = 'Error: '.$e->getMessage();
                                     }
                        }else{
                              try{
                                    $sql = $db_12_gce->prepare('UPDATE marks SET marking_centre =:marking_centre_code2 WHERE status = "L" AND marking_centre =:marking_centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND sen =:sen');
                                          $sql->execute(array(
                                           ':marking_centre_code2'=>$marking_centre_code2,
                                           ':marking_centre_code'=>$marking_centre_code,
                                           ':subject_code'=>$subject_code,
                                           ':paper_no'=>$paper_no,
                                           ':sen'=>$sen
                                          ));
                                          if($sql->rowCount() > 0){
                                                $data_array['status'] = '200';
                                                $data_array['response_msg'] = 'Marksheet successfuly altered for missing marks';
                                          }else{
                                                $data_array['status'] = '400';
                                                $data_array['response_msg'] = 'Could nt alter marksheet. Search the marksheet and try again';
                                          }
                                     }catch(PDOException $e){
                                           $data_array['status'] = '400';
                                           $data_array['response_msg'] = 'Error: '.$e->getMessage();
                                     }
                        }
                  }else{
                        if($sen == 'all'){
                              try{
                                    $sql = $db_12_gce->prepare('UPDATE marks SET marking_centre =:marking_centre_code2 WHERE status = "L" AND marking_centre =:marking_centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code');
                                          $sql->execute(array(
                                           ':marking_centre_code2'=>$marking_centre_code2,
                                           ':marking_centre_code'=>$marking_centre_code,
                                           ':subject_code'=>$subject_code,
                                           ':paper_no'=>$paper_no,
                                           ':centre_code'=>$centre_code
                                          ));
                                          if($sql->rowCount() > 0){
                                                $data_array['status'] = '200';
                                                $data_array['response_msg'] = 'Marksheet successfuly altered for missing marks';
                                          }else{
                                                $data_array['status'] = '400';
                                                $data_array['response_msg'] = 'Could nt alter marksheet. Search the marksheet and try again';
                                          }
                                     }catch(PDOException $e){
                                           $data_array['status'] = '400';
                                           $data_array['response_msg'] = 'Error: '.$e->getMessage();
                                     }
                        }else{
                              try{
                                    $sql = $db_12_gce->prepare('UPDATE marks SET marking_centre =:marking_centre_code2 WHERE status = "L" AND marking_centre =:marking_centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND centre_code =:centre_code AND sen =:sen');
                                          $sql->execute(array(
                                           ':marking_centre_code2'=>$marking_centre_code2,
                                           ':marking_centre_code'=>$marking_centre_code,
                                           ':subject_code'=>$subject_code,
                                           ':paper_no'=>$paper_no,
                                           ':centre_code'=>$centre_code,
                                           ':sen'=>$sen
                                          ));
                                          if($sql->rowCount() > 0){
                                                $data_array['status'] = '200';
                                                $data_array['response_msg'] = 'Marksheet successfuly altered for missing marks';
                                          }else{
                                                $data_array['status'] = '400';
                                                $data_array['response_msg'] = 'Could nt alter marksheet. Search the marksheet and try again';
                                          }
                                     }catch(PDOException $e){
                                           $data_array['status'] = '400';
                                           $data_array['response_msg'] = 'Error: '.$e->getMessage();
                                     }
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