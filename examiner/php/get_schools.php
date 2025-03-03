<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_SESSION['user_type'] == 'ECZ'){
        if(isset($_POST['subject_code']) && isset($_POST['paper_no'])){
                $subject_code = $_POST['subject_code'];
                $paper_no = $_POST['paper_no'];

                $sql = $db_12_gce->prepare('SELECT centre_code, centre_name FROM school WHERE centre_type =:session_type
                                                AND centre_code IN (SELECT centre_code FROM marks WHERE subject_code =:subject_code AND paper_no =:paper_no)');
                $sql->execute(array(
                        ':session_type'=>$_SESSION['session_type'],
                        ':subject_code'=>$subject_code,
                        ':paper_no'=>$paper_no
                ));
                if($sql->rowCount() > 0){
                        // $row = $sql->fetch(PDO::FETCH_ASSOC);
                        // $data_array['status'] = '200';
                        // $data_array[0]['centre_code'] = $row['centre_code'];
                        // $data_array[0]['centre_name'] = $row['centre_name'];
                        $i=0;
                        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                            $data_array[$i]['centre_code'] = $row['centre_code'];
                            $data_array[$i]['centre_name'] = $row['centre_name'];
                            $i++;
                        }
                       
                }else{
                        $data_array['status'] = '400';
                }
        }

}else{
        $sql = $db_12_gce->prepare('SELECT centre_code, centre_name FROM school WHERE centre_type =:session_type');
        $sql->execute(array(
                ':session_type'=>$_SESSION['session_type']
        ));
        if($sql->rowCount() > 0){
                // $row = $sql->fetch(PDO::FETCH_ASSOC);
                $data_array['status'] = '200';
                // $data_array[0]['centre_code'] = $row['centre_code'];
                // $data_array[0]['centre_name'] = $row['centre_name'];
                $i=0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                    $data_array[$i]['centre_code'] = $row['centre_code'];
                    $data_array[$i]['centre_name'] = $row['centre_name'];
                    $i++;
                }
               
        }else{
                $data_array['status'] = '400';
        }
}
        
echo json_encode($data_array);
?>