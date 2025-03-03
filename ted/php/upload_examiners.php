<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_FILES['myFile']['name'])){
    
    $path = $_FILES['myFile']['tmp_name'];
    try{
    $sql = $db_ted->prepare('LOAD DATA LOCAL INFILE :path INTO TABLE examiner
                            CHARACTER SET latin1
                            FIELDS TERMINATED BY ","
                            OPTIONALLY ENCLOSED BY \'"\'
                            ESCAPED BY \'"\'
                            LINES TERMINATED BY "\r\n"
                            (nrc,tpin,first_name,last_name,phone_number,email,address)
                        ');

    $sql->execute(array(
        ':path'=>$path
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Examiner list has been successfully uploaded';
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem uploading Examiner list. Check file and try again';
    }
}catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
}
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'File name not set. Reload and try again';
}
echo json_encode($data_array);
?>