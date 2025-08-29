<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
// header("Access-Control-Allow-Origin: *"); 
include '../../config.php';
$data_array = array();
$rate_value = 100/85;
$tax = 15/100;

if(isset($_POST['subject']) && isset($_POST['paper']) && isset($_POST['apportioned_belt'])){

        $subject_code = explode(':',$_POST['subject'])[0];
        $subject_name = explode(':',$_POST['subject'])[1];
        $paper_no = $_POST['paper'];
        $belt_no = $_POST['apportioned_belt'];

        if($belt_no == 0){
                 try{
                $sql = $db_12_gce->prepare("CALL insert_chief_examiner_claim (?,?,?,?,?,?,?,?,?,?)");

              $sql->execute([
                $subject_code,
                $subject_name,
                $paper_no,
                $belt_no,
                $rate_value,
                $tax,
                $_SESSION['session_year'],
                $_SESSION['session_name'],
                $_SESSION['marking_centre_code'],
                $_SESSION['marking_centre']
                ]);

                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $data_array['response_msg'] = 'Successfully submitted claims';
                

                }else{
                        $data_array['status'] = '400';
                }

                }catch(PDOException $e){


                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
                }
                       
        }else{
                try{
                $sql = $db_12_gce->prepare('CALL insert_examiner_claims(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');

                $sql->execute(array(
                $subject_code,
                $subject_name,
                $paper_no,
                $belt_no,
                $rate_value,
                $tax,
                $_SESSION['session_year'],
                $_SESSION['session_name'],
                $_SESSION['marking_centre_code'],
                $_SESSION['marking_centre']
                ));

                 if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $data_array['response_msg'] = 'Successfully submitted claims for belt '.$belt_no;
                

                }else{
                        $data_array['status'] = '400';
                }
                }catch(PDOException $e){


                $data_array['status'] = '400';
                $data_array['response_msg'] = 'There was an error for examiners: '.$e->getMessage();
                }


        }
       
        
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Subject paper and belt not set';
}
echo json_encode($data_array);
?>