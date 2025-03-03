<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();

if(isset($_FILES['myFile']['name'])){
    $path = $_FILES['myFile']['tmp_name'];
    try{
    $sql = $db_12_gce->prepare('LOAD DATA LOCAL INFILE :path INTO TABLE marks
                            CHARACTER SET latin1
                            FIELDS TERMINATED BY ","
                            OPTIONALLY ENCLOSED BY \'"\'
                            ESCAPED BY \'"\'
                            LINES TERMINATED BY "\r\n"
                            (centre_code,exam_no,first_name,last_name,subject_code,paper_no,mark,status,sen)
                        ');

    $sql->execute(array(
        ':path'=>$path
    ));
    $data_array['status'] = '200';
    $data_array['response_msg'] = 'Marksheet sussessfully uploaded';
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