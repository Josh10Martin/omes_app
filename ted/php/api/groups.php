<?php
header('Content-Type:application/json ; charset=utf-8');
include '../../../config.php';
$data_array = array();

$data = json_decode(file_get_contents('https://ems.exams-council.org.zm:8080/api/ted/subject/groups/'),JSON_OBJECT_AS_ARRAY);
$i =0;

foreach($data as $key => $row){
      if(isset($row['group_name'])){
            $group_code = $row['id'] ?? '';
            $group_name = $row['group_name'] ?? ''; 
            $session = substr($row['session_name'],0,4);

            try{
                  
            $sql = $db_ted->prepare('INSERT IGNORE INTO course_group (group_code,group_name) VALUES(:group_code,:group_name)
                                    ON DUPLICATE KEY UPDATE
                                    group_name = VALUES(group_name)
                                    ');
            $sql ->execute(array(
                  ':group_code'=>$group_code,
                  ':group_name'=>$group_name
            ));

            foreach($row['courses'] as $key =>$course){
                  $course_code = $course['course_code'] ?? '';
                  $course_name = $course['course_name'] ?? '';
                  // $group_code = $row['id'] ?? '';

                  $sql2 = $db_ted->prepare('INSERT IGNORE INTO course (course_code,course_name,group_id)VALUES(:course_code,:course_name,:group_code)
                                    ON DUPLICATE KEY UPDATE
                                    course_name = VALUES(course_name)
                                    ');
            $sql2->execute(array(
                  ':course_code'=>$course_code,
                  ':course_name'=>$course_name,
                  ':group_code'=>$group_code
            ));
            foreach($course['subjects'] as $key => $subject){
                  $subject_code = $subject['subject_code'] ?? '';
                  $subject_name = $subject['subject_name'] ?? '';
                  $maximum_mark = $subject['max_mark'] ?? '';

                  $sql3 = $db_ted->prepare('INSERT IGNORE INTO subjects (subject_code,subject_name,max_mark,course_id,session)VALUES(:subject_code,:subject_name,:max_mark,:course_code,:session)
                                    ON DUPLICATE KEY UPDATE
                                    subject_name = VALUES(subject_name),
                                    max_mark = VALUES(max_mark),
                                    session = VALUES(session)
                                    ');
                  $sql3->execute(array(
                        ':subject_code'=>$subject_code,
                        ':subject_name'=>$subject_name,
                        ':max_mark'=>$maximum_mark,
                        ':course_code'=>$course_code,
                        ':session'=>$session
                  ));
                  $i++;
                  if($sql3->rowCount() == $i){
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Successfully added groups, courses and subjects';
                  }
            }

            }

            
            

      }catch(PDOException $e){
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'Error: '.$e->getMessage();
      }
      }
}

echo json_encode($data_array);
?>