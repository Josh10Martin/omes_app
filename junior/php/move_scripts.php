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
        $id = implode(', ',$id);
        try{
        $sql = $db_9->prepare("INSERT IGNORE INTO apportionment_temp SELECT * FROM apportionment WHERE id IN (".$id.")");
        $sql->execute();
        if($sql->rowCount() > 0){
           $sql2 = $db_9->prepare("DELETE FROM apportionment WHERE id IN (".$id.")");
           $sql2->execute();
           if($sql2->rowCount() > 0){
            $sql3 = $db_9->prepare("UPDATE apportionment_temp SET belt_no = ? ,group_id = CONCAT(REVERSE(SUBSTRING(REVERSE(group_id),INSTR(REVERSE(group_id),'_'))),?) WHERE id IN(".$id.")");
            $sql3->execute([$selected_belt,$selected_belt]);
            if($sql3->rowCount() > 0){
                $sql4 = $db_9->prepare("INSERT IGNORE INTO apportionment SELECT * FROM apportionment_temp WHERE id IN (".$id.")");
                $sql4->execute();
                if($sql4->rowCount() > 0){
                    $sql5 = $db_9->prepare("DELETE FROM apportionment_temp WHERE id IN(".$id.")");
                    $sql5->execute();
                    if($sql5->rowCount() > 0){
                        $data_array['status'] = '200';
                        $data_array['response_msg'] = 'SUccessfully Moved script(s) to belt '.$selected_belt;
                    }else{
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Script has been moved but couldnt be removed from temporary location';
                    }
                }else{
                    $data_array['status'] = '400';
                    $data_array['response_msg'] = 'Could not return script from temporary location';
                }
            }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Could not update belt in temporary location';
            }
           }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Could not insert into temporary location for movement';
           }
        }else{
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Could not insert into temporary location for movement';
        }
    }catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: '.$e->getMessage();
    }
   
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Choose centre to move';
    }
}else{
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Not all parameters set';
}
echo json_encode($data_array);
?>