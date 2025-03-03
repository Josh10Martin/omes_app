<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
        if(isset($_POST['province_code'])){
                $province_code = $_POST['province_code'];
        
        $sql = $db_ted->prepare('SELECT centre_code, centre_name FROM school WHERE province =:province_code AND centre_type =:session_type 
                                AND centre_code IN (SELECT centre_code FROM marks)');
        $sql->execute(array(
                ':session_type'=>$_SESSION['session_type'],
                ':province_code'=>$province_code
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $data_array['status'] = '200';
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