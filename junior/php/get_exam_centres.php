<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_POST['district'])){
        $district = $_POST['district'];
        
                $sql = $db_9->prepare('SELECT centre_code, centre_name FROM school WHERE province =:province_code AND district =:district_code ORDER BY centre_code ASC');
                $sql->execute(array(
                        ':district_code'=>$district,
                        ':province_code'=>$_SESSION['province_code'],
                ));
                if($sql->rowCount() > 0){
                        $data_array['status'] = '200';
                        $i =0;
                        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                                $i++;
                        }
                }else{
                        $data_array['status'] = '400';
                }
        
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'District parameters not set';
}
echo json_encode($data_array);
?>