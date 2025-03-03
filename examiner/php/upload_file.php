<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if($_FILES['myfile']['name'] && isset($_POST['file_desc'])){
    $name = $_FILES['myfile']['name'];
    $temp = $_FILES['myfile']['tmp_name'];
    $data = explode('.',$_FILES['myfile']['name']);
    $extension = $data[1];
    $file_desc = $_POST['file_desc'];
    $file_name = str_replace(' ','_',$file_desc).'_'.rand(10000,99000).'.'.$extension;

    $path = '/var/www/ocrs/html/omes/examiner/documents/'.$file_name;
    if(move_uploaded_file($temp,$path)){
        $sql = $db_12_gce->prepare('INSERT IGNORE INTO documents(description,url,date_uploaded)VALUES(:description,:path,NOW())');
        $sql->execute(array(
            ':description'=>$file_desc,
            ':path'=>$path
        ));
        if($sql->rowCount() > 0){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'File successfully imported';
        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Could not insert file information';
        }
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not upload file';
    }


}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'not all parameters set';
}
echo json_encode($data_array);
?>