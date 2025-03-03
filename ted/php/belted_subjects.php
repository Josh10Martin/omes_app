<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$sql = $db_ted->prepare('SELECT g.id AS id,g.belt_no AS belt_no,cg.group_code AS group_code,cg.group_name AS group_name,g.no_of_centres AS no_of_centres, g.no_of_scripts AS no_of_scripts
                        FROM group_apportion g INNER JOIN course_group cg ON (g.group_code = cg.group_code)
                        
                        LEFT OUTER JOIN apportionment a ON (g.id = a.group_apportion_id)
                                                        AND g.group_code = a.group_code
                        WHERE g.marking_centre = :marking_centre_code
                        AND g.session =:session_year
                        GROUP BY g.id,g.belt_no,cg.group_code,cg.group_name
                        ORDER BY g.belt_no ASC, cg.group_code ASC');
$sql->execute(array(
        ':marking_centre_code'=>$_SESSION['marking_centre_code'],
        ':session_year'=>$_SESSION['session_year']
));
if($sql->rowCount() > 0){
        $i=0;
        while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['id'] = $row['id'] ?? '';
                $data_array[$i]['belt_no'] = $row['belt_no'] ?? '';
                $data_array[$i]['group_code'] = $row['group_code'] ?? '';
                $data_array[$i]['group_name'] = $row['group_name'] ?? '';
                $data_array[$i]['no_of_centres'] = $row['no_of_centres'] ?? '';
                $data_array[$i]['no_of_scripts'] = $row['no_of_scripts'] ?? '';
                $i++;
        }
}else{
        $data_array['status'] = '400';
}
echo json_encode($data_array);
?>