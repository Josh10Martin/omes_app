<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['selected_belt']) && isset($_POST['id'])){
    $_POST=filter_var_array($_POST);
    $selected_belt = $_POST['selected_belt'];
    $id = $_POST['id'];
  
    
      if(count($id) > 0){

        $placeholders = implode(', ', array_fill(0, count($id), '?'));
        try{
        $sql = $db_12_gce->prepare("UPDATE marks SET belt_no = ?,   id_group = CONCAT(SUBSTRING_INDEX(id_group, '_', 5), '_', ?)
     WHERE id_group IN ($placeholders) 
                                        
                                        AND marking_centre = ?
                                        
                                        ");
        $params = array_merge([$selected_belt, $selected_belt], $id, [$_SESSION['marking_centre_code']]);
        $sql->execute($params);

    if($sql->rowCount() > 0){
        $data_array['status'] = '200';
        $data_array['response_msg'] = 'Script successfully moved to belt '.$selected_belt;

       $data_array['id_group'] = $id;
      
    }else{
         $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was a problem moving script';
    }
    }catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
    }
}else{
     $data_array['status'] = '400';
        $data_array['response_msg'] = 'You need to choose script(s) to move';
}
    
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Not all parameters set';
}
echo json_encode($data_array);
?>