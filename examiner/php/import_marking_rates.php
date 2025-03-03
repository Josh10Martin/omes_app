<?php
header('Content-Type:application/json ; charset=utf-8');
include '../../config.php';
$data_array = array();

$data = json_decode(file_get_contents('php://input'),JSON_OBJECT_AS_ARRAY);
$i =0;

foreach($data as $key => $row){
    if(isset($row['subject_code'])){
        $subject_code = $row['subject_code'] ?? '';
        $paper_no = $row['paper_no'] ?? '';
        $chief_examiner = $row['chief_examiner'] ?? '';
        $deputy_chief_examiner = $row['deputy_c_examiner'] ?? '';
        $team_leader = $row['t_leader'] ?? '';
        $examiner = $row['examiner'] ?? '';
        $checker = $row['checker'] ?? '';
        $data_entry_officer = $row['data_entry'] ?? '';
        try{
        $sql =$db_12_gce->prepare('INSERT INTO marking_rates(subject_code,paper_no,chief_examiner,deputy_c_examiner,t_leader,examiner,checker,data_entry)
                                    VALUES(:subject_code,:paper_no,:chief_examiner,:deputy_c_examiner,:t_leader,:examiner,:checker,:data_entry)
                                    ON DUPLICATE KEY UPDATE
                                    chief_examiner = VALUES(chief_examiner),
                                    deputy_c_examiner = VALUES(deputy_c_examiner),
                                    t_leader = VALUES(t_leader),
                                    examiner = VALUES(examiner),
                                    checker = VALUES(checker),
                                    data_entry = VALUES(data_entry)
                                    ');

        $sql->execute(array(
            ':subject_code'=>$subject_code,
            ':paper_no'=>$paper_no,
            ':chief_examiner'=>$chief_examiner,
            ':deputy_c_examiner'=>$deputy_chief_examiner,
            ':t_leader'=>$team_leader,
            ':examiner'=>$examiner,
            ':checker'=>$checker,
            ':data_entry'=>$data_entry_officer
        ));
        $i++;
        if($sql->rowCount() == $i){
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Marking rates added / updated';
        }
        
    }catch(PDOException $e){
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Error: '.$e->getMessage();
    }

    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'subject_code not set';
    }
}

echo json_encode($data_array);
?>