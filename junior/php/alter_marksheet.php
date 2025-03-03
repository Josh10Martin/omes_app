<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');

include '../../config.php';
include '../../functions.php';
$data_array = array();



if($_SESSION['session_type']=='I'){
        if(isset($_POST['marking_centre_code']) && isset($_POST['centre_code']) && isset($_POST['subject_code'])){
                $marking_centre_code = $_POST['marking_centre_code'];
                $centre_codes = $_POST['centre_code'];
                $subject_codes = $_POST['subject_code'];
                
                $_SESSION['centre_code'] = $centre_codes;
                $_SESSION['marking_centre_code'] = $marking_centre_code;
                $_SESSION['subject_code'] = $subject_codes;

                $sen = isset($_POST['sen']) ? '1' : '0';
                // $apportion_id = apportionment_value($db_9,$_SESSION['province_code']);
                // $_SESSION['apportion_id'] = $apportion_id;
                // $apportion_ids = $_SESSION['province_code'].'_'.$apportion_id;
                if(count($centre_codes) > 0 && count($subject_codes) > 0){
                        
                        try{
                                $i=0;
                        
                                    $in_centre_code = implode(', ',array_fill('0',count($centre_codes),'?'));
                                    $in_subject_code = implode(', ',array_fill('0',count($subject_codes),'?'));
                               
                                    $sql = $db_9->prepare('SELECT u.username AS username,u.first_name AS first_name,u.last_name AS last_name,u.email AS email,u.phone AS phone,u.user_type AS user_type,
                                    sc.centre_name AS centre_name,sc.centre_code AS centre_code,su.subject_name AS subject_name FROM users  u INNER JOIN marks m ON (u.marking_centre = m.marking_centre)
                                    INNER JOIN school sc ON (m.centre_code = sc.centre_code)
                                    INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                                    WHERE u.username IN (SELECT LEFT(m.entered_by,LOCATE(" ",m.entered_by) -1) FROM marks WHERE centre_code IN('.$in_centre_code.') AND subject_code IN('.$in_subject_code.') AND marking_centre <> ? AND sen =0 AND province = ?)
                                    AND sc.centre_code IN ('.$in_centre_code.')
                                    AND su.subject_code IN ('.$in_subject_code.')
                                    AND m.marking_centre <> ?
                                    AND m.sen = 0
                                    AND m.province = ?
                                    GROUP BY u.username,u.first_name,u.last_name,u.email,u.phone,u.user_type,sc.centre_name,sc.centre_code,su.subject_name');
                                    $sql->execute(array_merge($centre_codes,$subject_codes,[$marking_centre_code,$_SESSION['province_code']],$centre_codes,$subject_codes,[$marking_centre_code,$_SESSION['province_code']]));
                                    if($sql->rowCount() > 0){
                                    $row = $sql->fetch(PDO::FETCH_ASSOC);
                                $data_array[$i]['username'] = $row['username'] ?? '';
                                $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                                $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                                $data_array[$i]['phone'] = $row['phone'] ?? '';
                                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                                $data_array[$i]['subject_name'] = $row['subject_name'] ?? '';
                              
                                $data_array[$i]['email'] = $row['email'] ?? '';
                                $data_array[$i]['user_type'] = $row['user_type'] ?? '';
                            }
                               
               
                        // unset($_SESSION['apportion_id']);
                        // $data_array['status'] ='200';
                        // $data_array['response_msg'] = 'Successfully apportioned subjects';
                 
                }catch(PDOException $e){
                        $data_array['status'] ='400';
                        $data_array['response_msg'] ='There was an error: '.$e->getMessage();
                }
                }else{
                        $data_array['status'] ='400';
                        $data_array['response_msg'] ='Centres and subjects must be chosen';
                }
        }else{
                $data_array['status'] ='400';
                $data_array['response_msg'] ='Not all parameters are set';
        }
        
}else{
        if(no_of_marking_centres($db_8,$_SESSION['province_code'],$_SESSION['session_type']) == 1){
            $data_array['status'] ='400';
            $data_array['response_msg'] = 'You cannot edit script movement of one marking centre';
        }else{
        if (isset($_POST['marking_centre_code']) && isset($_POST['centre_code'])) {
                $marking_centre_code = $_POST['marking_centre_code'];
                $centre_codes = is_array($_POST['centre_code']) ? $_POST['centre_code'] : [$_POST['centre_code']];

                $_SESSION['marking_centre_code'] = $marking_centre_code;
                $_SESSION['centre_codes'] = $centre_codes;

                $apportion_id = apportionment_value_external($db_9, $_SESSION['province_code']);
                $_SESSION['apportion_id'] = $apportion_id;
            
                if (count($centre_codes) > 0) {
                    try {
                        // Create a string of question marks for the IN clause
                        $in_centre_code = implode(',', array_fill(0, count($centre_codes), '?'));
                        $_SESSION['in_centre_code'] = $in_centre_code;
                        // Prepare and execute the SELECT statement
                        $sql = $db_9->prepare('
                            SELECT u.username AS username, u.first_name AS first_name, u.last_name AS last_name, u.email AS email, u.phone AS phone, u.user_type AS user_type,
                                sc.centre_name AS centre_name,sc.centre_code AS centre_code
                            FROM users u
                            INNER JOIN marks m ON u.marking_centre = m.marking_centre
                            INNER JOIN school sc ON m.centre_code = sc.centre_code
                            WHERE u.username IN (
                                SELECT LEFT(m.entered_by, LOCATE(" ", m.entered_by) - 1)
                                FROM marks
                                WHERE centre_code IN (' . $in_centre_code . ')
                                AND marking_centre <> ?
                                AND sen =0
                                AND province = ?
                            )
                            AND sc.centre_code IN (' . $in_centre_code . ')
                            AND m.marking_centre <> ?
                            AND sc.province = m.province
                            AND sc.province = ?
                            GROUP BY u.username,u.first_name,u.last_name,u.email,u.phone,u.user_type,sc.centre_name,sc.centre_code
                        ');
            
                        $select_params = array_merge($centre_codes, [$marking_centre_code, $_SESSION['province_code']], $centre_codes, [$marking_centre_code,$_SESSION['province_code']]);
                        $sql->execute($select_params);
            
                     
                        if ($sql->rowCount() > 0) {
                            $i = 0;
                            while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                                $data_array[$i]['username'] = $row['username'] ?? '';
                                $data_array[$i]['first_name'] = $row['first_name'] ?? '';
                                $data_array[$i]['last_name'] = $row['last_name'] ?? '';
                                $data_array[$i]['phone'] = $row['phone'] ?? '';
                                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                                $data_array[$i]['email'] = $row['email'] ?? '';
                                $data_array[$i]['user_type'] = $row['user_type'] ?? '';
                                $i++;
                            }
                        }
            
                       
                        // $data_array['response_msg'] = 'Successfully altered marksheet';
                        // unset($_SESSION['apportion_id']);
                    } catch (PDOException $e) {
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'There was an error altering marksheet: ' . $e->getMessage() . '</br>' . $sql->queryString . '</br>' . print_r($params1, true);
                        
                    }
                } else {
                    $data_array['status'] = '400';
                    $data_array['response_msg'] = 'Centres must be chosen';
                }
            } else {
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'Not all parameters are set';
            }
            
        }
}

echo json_encode($data_array);
?>