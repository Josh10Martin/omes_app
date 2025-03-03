<?php
session_start();
header('Content-Type:application/json; charset=utf-8;');
include '../../config.php';
$data_array = array();

    $_POST = json_decode(file_get_contents('php://input'),JSON_OBJECT_AS_ARRAY);
    
    $session = trim(strtoupper($_POST['session_name']));
    $position =strpos($session, ' ');
   

    $session_id = substr($session,0,4);
    $session_name = substr($session, $position + 1);


    $year = substr($session,0,4);
    $level = trim($_POST['level']);
try{
    $sql = $db_ted->prepare('INSERT IGNORE INTO session (id,name,year,level) VALUES(:session_id,:session_name,:year,:level)
                                                        ON DUPLICATE KEY UPDATE
                                                        name = VALUES(name)');
    $sql->execute(array(
        ':session_id'=>$session_id,
        ':session_name'=>$session_name,
        ':level'=>$level,
        ':year'=>$year
    ));
    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
         $data_array['response_msg'] = 'Session successfully updated';
    }else{
        $data_array['status'] = '400';
         $data_array['response_msg'] = 'Could not make new session.';
         
    }
}catch(PDOException $e){
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'There wan an error: '.$e->getMessage();
}

echo json_encode($data_array);
?>