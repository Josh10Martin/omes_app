<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
if(isset($_POST['group_code'])){
        $group_code = $_POST['group_code'];
        $sql = $db_ted->prepare('WITH exm AS(
                                SELECT ex.id AS id, ex.nrc AS nrc,ex.examiner_number AS examiner_number, ex.last_name AS last_name,ex.first_name AS first_name, ex.role AS position,
                                CASE WHEN ex.belt_no IS NULL THEN "NOT BELTED" ELSE ex.belt_no END AS belt_no
                                FROM examiner ex INNER JOIN marking_centre mc ON (ex.course_code = mc.course)
                                INNER JOIN course c ON (mc.course = c.course_code)
                                INNER JOIN course_group course_groupcg ON (c.group_id = course_groupcg.group_code)
                                WHERE ex.attendance = 1
                                AND ex.role <> "DATA ENTRY OFFICER"
                                AND ex.session = mc.session
                                AND ex.session =:session_year
                                AND ex.marking_centre =:marking_centre_code
                                AND course_groupcg.group_code =:group_code
                                )
                                SELECT * FROM exm
                                ORDER BY FIELD(belt_no,"NOT BELTED") DESC
                                ');
        $sql->execute(array(
                ':group_code'=>$group_code,
                ':session_year'=>$_SESSION['session_year'],
                ':marking_centre_code'=>$_SESSION['marking_centre_code']
        ));
        if($sql->rowCount() > 0){
                $i =0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                        $data_array[$i]['id'] = $row['id'] ?? '';
                        $data_array[$i]['examiner_number'] = $row['examiner_number'] ?? '';
                        $data_array[$i]['nrc'] = $row['nrc'] ?? '';
                        $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                        $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                        $data_array[$i]['position'] = $row['position'] ?? '';
                        $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                        $data_array[$i]['belt'] = str_replace(' ','_',$row['belt_no']);
                        $data_array[$i]['belt2'] = $row['belt_no'] == "NOT BELTED" ? 'NOT_BELTED' : 'BELTED';
                        $i++;
                       
                }
        }else{
                $data_array['status'] = '400';
        }
   
}
echo json_encode($data_array);
?>