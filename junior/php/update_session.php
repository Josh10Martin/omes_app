<?php
session_start();
header('Content-Type:application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['session_code'])){

    $type = $_POST['type'];
    $description = $_POST['description'];
    $year = $_POST['session_code'];
    $sql = $db_9->prepare('INSERT IGNORE INTO session (id,name, year, type) VALUES(:year,:description,:year,:type)
                            ON DUPLICATE KEY UPDATE
                            name = VALUES(name),
                            year = VALUES(year),
                            type = VALUES(type)
                            ');
    $sql->execute(array(
        ':description'=>$description,
        ':year'=>$year,
        ':type'=>$type
    ));
    if($sql->rowCount() > 0){
        // unset($_SESSION['session_name']);
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Session successfully set.';
        // $_SESSION['session_name'] = $description;
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Could not set session. Please try again';
    }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Session code / id not set';
}
echo json_encode($data_array);
?>