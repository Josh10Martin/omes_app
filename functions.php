<?php
function nrc_exists($db,$nrc){
        $sql = $db->prepare('SELECT ex.first_name AS first_name,ex.last_name AS last_name, ce.centre_code AS marking_centre_code, ce.name AS marking_centre_name, p.p_name AS province
                                FROM examiner ex INNER JOIN centre ce ON (ex.marking_centre = ce.centre_code)
                                INNER JOIN province p ON (ce.province = p.p_code)
                                WHERE ex.province = p.p_code
                                AND ex.nrc =:nrc
                                
                                UNION
                                
                                SELECT u.first_name AS first_name,u.last_name AS last_name,ce.centre_code AS marking_centre_code, ce.name AS marking_centre_name,p.p_name AS province
                                FROM users u INNER JOIN centre ce ON (u.marking_centre = ce.centre_code)
                                INNER JOIN province p ON (ce.province = p.p_code)
                                WHERE u.province = p.p_code
                                AND u.nrc =:nrc
                                ');
        $sql->execute(array(
                ':nrc'=>$nrc
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $first_name = $row['first_name'] ?? '';
                $last_name = $row['last_name'] ?? '';
                $marking_centre_code = $row['marking_centre_code'] ?? '';
                $marking_centre_name = $row['marking_centre_name'] ?? '';
                $province = $row['province'] ?? '';
                return $first_name.' '.$last_name.' at '.$marking_centre_code.' - '.$marking_centre_name.' in '.$province.' province';
        }else{
                return 'false';
        }
}
function nrc_exists_for_transcriber($db,$nrc){
        $sql = $db->prepare('SELECT t.first_name AS first_name,t.last_name AS last_name,ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name
                                FROM transcriber t INNER JOIN centre ce ON (t.marking_centre = ce.centre_code)
                                WHERE t.nrc =:nrc
                                ');
        $sql->execute(array(
                ':nrc'=>$nrc
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $first_name = $row['first_name'] ?? '';
                $last_name = $row['last_name'] ?? '';
                $marking_centre_code = $row['marking_centre_code'] ?? '';
                $marking_centre_name = $row['marking_centre_name'] ?? '';
                return $first_name.' '.$last_name.' at '.$marking_centre_code.' - '.$marking_centre_name;
        }else{
                return 'false';
        }
}
function email_exists($db,$email){
        $sql = $db->prepare('SELECT email FROM examiner WHERE email =:email');
        $sql->execute(array(
                ':email'=>$email
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}
function email_exists_for_transcriber($db,$email){
        $sql = $db->prepare('SELECT email FROM transcriber WHERE email =:email');
        $sql->execute(array(
                ':email'=>$email
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}
function tpin_exists($db,$tpin){
        $sql = $db->prepare('SELECT ex.first_name AS first_name,ex.last_name AS last_name, ce.centre_code AS marking_centre_code, ce.name AS marking_centre_name, p.p_name AS province
                             FROM examiner ex INNER JOIN centre ce ON (ex.marking_centre = ce.centre_code)
                             INNER JOIN province p ON (ce.province = p.p_code)
                             WHERE ex.province = p.p_code
                             AND ex.tpin =:tpin
                             
                             UNION
                             
                             SELECT u.first_name AS first_name,u.last_name AS last_name,ce.centre_code AS marking_centre_code, ce.name AS marking_centre_name,p.p_name AS province
                             FROM users u INNER JOIN centre ce ON (u.marking_centre = ce.centre_code)
                             INNER JOIN province p ON (ce.province = p.p_code)
                             WHERE u.province = p.p_code
                             AND u.tpin =:tpin
                             ');
        $sql->execute(array(
                ':tpin'=>$tpin
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $first_name = $row['first_name'] ?? '';
                $last_name = $row['last_name'] ?? '';
                $marking_centre_code = $row['marking_centre_code'] ?? '';
                $marking_centre_name = $row['marking_centre_name'] ?? '';
                $province = $row['province'] ?? '';
                return $first_name.' '.$last_name.' at '.$marking_centre_code.' - '.$marking_centre_name.' in '.$province.' province';
        }else{
                return 'false';
        }
}
function tpin_exists_for_transcriber($db,$tpin){
        $sql = $db->prepare('SELECT t.first_name AS first_name,t.last_name AS last_name,ce.centre_code AS marking_centre_code,ce.name AS marking_centre_name
        FROM transcriber t INNER JOIN centre ce ON (t.marking_centre = ce.centre_code)
        WHERE t.tpin =:tpin
        ');
        $sql->execute(array(
        ':tpin'=>$tpin
        ));
        if($sql->rowCount() > 0){
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $first_name = $row['first_name'] ?? '';
        $last_name = $row['last_name'] ?? '';
        $marking_centre_code = $row['marking_centre_code'] ?? '';
        $marking_centre_name = $row['marking_centre_name'] ?? '';
        return $first_name.' '.$last_name.' at '.$marking_centre_code.' - '.$marking_centre_name;
        }else{
        return 'false';
        }
}

function username_exists($db,$username){
        $sql=$db->prepare('SELECT username FROM users WHERE username =:username');
        $sql->execute(array(
                ':username'=>$username
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $username = $row['username'];
                return $username;
        }else{
                return 'false';
        }
}

function activation_value($db,$id){
        $sql = $db->prepare('SELECT activation_status FROM users WHERE username =:id');
        $sql->execute(array(
                ':id'=>$id
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $status = $row['activation_status'];
                return $status;
        }
        
}

// function deo_username($db,$subject_code,$paper,$user_type){
//         $sql = $db->prepare('SELECT MAX(SUBSTRING(username,-1,1)) AS serial,COUNT(user_type) AS user_count FROM users WHERE user_type =:user_type');
//         $sql->execute(array(
//                 ':user_type'=>$user_type
//         ));
//         $row = $sql->fetch(PDO::FETCH_ASSOC);
//         $user_count = $row['user_count'] ?? '';
//         $serial = $row['serial'] ?? '';
//         if($user_count > 0){
//                 $username = $subject_code.'/'.$paper.'/'.$serial +1;
//                 return $username;
//         }else{
//                 $serial = '1';
//                 return $subject_code.'/'.$paper.'/'.$serial;
//         }
// }

function belt_added($db,$belt_no,$subject,$paper,$marking_centre_code,$province){
        $sql = $db->prepare('SELECT belt_no FROM group_apportion WHERE subject =:subject_code AND paper =:paper_no AND belt_no =:belt_no AND marking_centre =:marking_centre_code AND province =:province_code');
        $sql->execute(array(
                ':subject_code'=>$subject,
                ':paper_no'=>$paper,
                ':belt_no'=>$belt_no,
                ':marking_centre_code'=>$marking_centre_code,
                ':province_code'=>$province
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $belt_no = $row['belt_no'];
                return $belt_no;
        }else{
                return 'false';
        }
}
function belt_added_g12_gce($db,$belt_no,$subject,$paper,$marking_centre_code){
        $sql = $db->prepare('SELECT belt_no FROM group_apportion WHERE subject =:subject_code AND paper =:paper_no AND belt_no =:belt_no AND marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':subject_code'=>$subject,
                ':paper_no'=>$paper,
                ':belt_no'=>$belt_no,
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $belt_no = $row['belt_no'];
                return $belt_no;
        }else{
                return 'false';
        }
}
function belt_added_ted($db,$belt_no,$subject,$paper,$marking_centre_code){
        $sql = $db->prepare('SELECT belt_no FROM group_apportion WHERE subject =:subject_code AND paper =:paper_no AND belt_no =:belt_no AND marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':subject_code'=>$subject,
                ':paper_no'=>$paper,
                ':belt_no'=>$belt_no,
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $belt_no = $row['belt_no'];
                return $belt_no;
        }else{
                return 'false';
        }
}
function centre_in_belt($db,$subject,$paper,$school,$marking_centre_code,$province){
        $sql = $db->prepare('SELECT ce.name AS marking_centre_name, s.centre_code AS centre_code, s.centre_name AS centre_name,a.belt_no AS belt_no, a.username AS username  FROM centre ce INNER JOIN apportionment a ON (ce.centre_code = a.marking_centre)
                               INNER JOIN school s ON (a.school = s.centre_code)
                                 WHERE ce.province = a.province
                                 AND a.subject =:subject_code 
                                 AND a.paper =:paper_no 
                                 AND a.school =:school
                                 AND a.marking_centre =:marking_centre_code  
                                 AND a.province =:province_code');
        $sql->execute(array(
                ':subject_code'=>$subject,
                ':paper_no'=>$paper,
                ':school'=>$school,
                ':marking_centre_code'=>$marking_centre_code,
                ':province_code'=>$province
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $belt_no = $row['belt_no'];
                $centre_name = $row['centre_name'];
                $centre_code = $row['centre_code'];
                $username = $row['username'];
                $marking_centre_name = $row['marking_centre_name'];
                $message = 'Centre '.$centre_code.' -'.$centre_name.' is already belted in belt '.$belt_no.' by '.$username.' at '.$marking_centre_name;

                return $message;
        }else{
                return 'false';
        }
}
function centre_already_entered($db,$subject_code,$paper_no,$school,$belt,$sen,$marking_centre_code){
        $sql = $db->prepare('SELECT DISTINCT s.centre_code AS centre_code, s.centre_name AS centre_name,a.belt_no AS belt_no,a.sen AS sen,a.username AS username FROM apportionment a 
                                INNER JOIN school s ON (a.school = s.centre_code)
                                WHERE a.subject =:subject_code 
                                AND a.paper =:paper_no 
                                AND a.sen =:sen 
                                AND a.school =:school
                                AND a.marking_centre =:marking_centre_code');

        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':sen'=>$sen,
                ':school'=>$school,
                ':marking_centre_code'=>$marking_centre_code
        ));

        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $belt_no = $row['belt_no'] ?? '';
        $sen = is_array($row) ? ($row['sen'] == 1 ? 'SEN' : ($row['sen'] == 0 ? 'MAINSTREAM' : '')) : '';
        $centre_name = $row['centre_name'] ?? '';
        $centre_code = $row['centre_code'] ?? '';
        if($sql->rowCount() > 0 && ($belt != $belt_no)){
                
                $message = $centre_code.' - '.$centre_name.' for '.$sen.' is already entered for belt '.$belt_no;

                return $message;
        }else{
                return 'true';
        }
}
function ted_centre_already_entered($db,$subject_code,$school,$belt,$marking_centre_code,$session_year){
        $sql = $db->prepare('SELECT DISTINCT s.centre_code AS centre_code, s.centre_name AS centre_name,a.belt_no AS belt_no,a.username AS username FROM apportionment a 
                                INNER JOIN school s ON (a.school = s.centre_code)
                                WHERE a.subject =:subject_code 
                                AND a.school =:school
                                AND a.marking_centre =:marking_centre_code
                                AND a.session =:session');

        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':school'=>$school,
                ':marking_centre_code'=>$marking_centre_code,
                ':session'=>$session_year
        ));

        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $belt_no = $row['belt_no'] ?? '';
        $centre_name = $row['centre_name'] ?? '';
        $centre_code = $row['centre_code'] ?? '';
        if($sql->rowCount() > 0 && ($belt != $belt_no)){
                
                $message = $centre_code.' - '.$centre_name.' is already entered for belt '.$belt_no;

                return $message;
        }else{
                return 'true';
        }
}
function centre_in_belt_g12_gce($db,$subject,$paper,$school,$marking_centre_code,$this_belt =null){
        $sql = $db->prepare('SELECT DISTINCT s.centre_code AS centre_code, s.centre_name AS centre_name,a.belt_no AS belt_no FROM apportionment a INNER JOIN school s ON (a.school = s.centre_code)
                                 WHERE a.subject =:subject_code AND a.paper =:paper_no AND a.school =:school AND a.marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':subject_code'=>$subject,
                ':paper_no'=>$paper,
                ':school'=>$school,
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $belt_no = $row['belt_no'];
                $centre_name = $row['centre_name'];
                $centre_code = $row['centre_code'];
                $belt_id = $belt_no == $this_belt ? 'the current belt' : 'belt '.$belt_no;
                $message = $centre_code.' -'.$centre_name.' is already belted in '.$belt_id;

                return $message;
        }else{
                return 'false';
        }
}
function centre_in_belt_ted($db,$subject,$paper,$school,$marking_centre_code,$this_belt){
        $sql = $db->prepare('SELECT DISTINCT s.centre_code AS centre_code, s.centre_name AS centre_name,a.belt_no AS belt_no FROM apportionment a INNER JOIN school s ON (a.school = s.centre_code)
                                 WHERE a.subject =:subject_code AND a.paper =:paper_no AND a.school =:school AND a.marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':subject_code'=>$subject,
                ':paper_no'=>$paper,
                ':school'=>$school,
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $belt_no = $row['belt_no'];
                $centre_name = $row['centre_name'];
                $centre_code = $row['centre_code'];
                $belt_id = $belt_no == $this_belt ? 'the current belt' : 'belt '.$belt_no;
                $message = $centre_code.' -'.$centre_name.' is already belted in '.$belt_id;

                return $message;
        }else{
                return 'false';
        }
}
function max_number($db){
        $sql = $db->prepare('SELECT MAX(SUBSTRING()) AS id, COUNT(province) AS count FROM group_apportion');
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $count = $row['count'];
        $id = $row['id'];
        if($count > 0){
                $id = $id + 1;
                return $id;
        }else{
                $id = 1;
                return $id;
        }
}
function user_id($db){
        $sql = $db->prepare('SELECT id FROM users');
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        return $id = $row['id'];
}

function marking_centre_code($db){
        $sql = $db->prepare('SELECT MAX(SUBSTRING(centre_code,-2,2)) AS serial,COUNT(centre_code) AS centre_count FROM centre');
        $sql->execute();
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $serial = $row['serial'] ?? '';
        $centre_count = $row['centre_count'];
        if($centre_count > 0){
                $centre_code = $serial +1;
                return 'MC-'.$centre_code;
        }else{
                $serial = '1';
                return 'MC-'.$serial;
        }
}

function marking_centre_exists($db,$centre_code){
        $sql = $db->prepare('SELECT centre_code FROM centre where centre_code =:centre_code');
        $sql->execute(array(
                ':centre_code'=>$centre_code
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $centre_code = $row['centre_code'] ?? '';
                return $centre_code;
        }else{
                return 'false';
        }
}
function in_marksheet($db,$exam_no,$subject_code,$paper_no){
        $sql = $db->prepare('SELECT exam_no FROM marks WHERE exam_no =:exam_no AND subject_code =:subject_code AND paper_no =:paper_no');
        $sql->execute(array(
                ':exam_no'=>$exam_no,
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}
function in_marksheet_ted($db,$exam_no,$subject_code,$session_year){
        $sql = $db->prepare('SELECT exam_no FROM marks WHERE exam_no =:exam_no AND subject_code =:subject_code AND session =:session');
        $sql->execute(array(
                ':exam_no'=>$exam_no,
                ':subject_code'=>$subject_code,
                ':session'=>$session_year
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}
function account_not_provided($db,$user_type,$username){
        $sql = $db->prepare('SELECT username FROM users WHERE (nrc = "none" OR phone = "none" OR branch = "none" OR account_no = "none") AND user_type =:user_type AND username =:username');
        $sql->execute(array(
                ':user_type'=>$user_type,
                ':username'=>$username
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}
function data_entry_in_attendance($db){
        $sql = $db->prepare('SELECT examiner_number FROM examiner WHERE attendance = 1 AND role = "DATA ENTRY OFFICER"');
        $sql->execute();
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}
function attendance_status($db,$username){
        $sql = $db->prepare('SELECT first_name,last_name, attendance FROM examiner WHERE examiner_number =:username');
        $sql->execute(array(
                ':username'=>$username
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $attendance = $row['attendance'] ?? '';
        $first_name = $row['first_name'] ?? '';
        $last_name = $row['last_name'] ?? '';

        if($attendance == 1){
                return 'true';
        }else{
                return $first_name.' '.$last_name.'. Confirm your attendance status';
        }
}

function no_of_marking_centres($db,$province_code,$session_type){
        $sql = $db->prepare('SELECT COUNT(centre_code) AS no_of_marking_centres FROM centre
                                WHERE province =:province_code AND centre_type =:session_type');
        $sql->execute(array(
                ':province_code'=>$province_code,
                ':session_type'=>$session_type
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $no_of_marking_centres = $row['no_of_marking_centres'] ?? '';
        return $no_of_marking_centres;
}

function subject_name($db,$subject_code){
        $sql = $db->prepare('SELECT subject_name FROM subjects WHERE subject_code =:subject_code');
        $sql->execute(array(
                ':subject_code'=>$subject_code
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $subject_name = $row['subject_name'] ?? '';
        return $subject_name;
}

function subject_code($db,$subject_name){
        $sql = $db->prepare('SELECT subject_code FROM subjects WHERE subject_name =:subject_name');
        $sql->execute(array(
                ':subject_name'=>$subject_name
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $subject_code = $row['subject_code'] ?? '';
        return $subject_code;
}
function school_exists($db,$centre_code){
        $sql = $db->prepare('SELECT centre_code FROM school WHERE centre_code =:centre_code');
        $sql->execute(array(
                ':centre_code'=>$centre_code
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}
function max_mark($db,$subject_code,$paper_no){
        $sql = $db->prepare('SELECT max_mark FROM paper WHERE subject_code =:subject_code AND paper_no =:paper_no');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $max = $row['max_mark'] ?? '';
        return $max;
}

//internal
function apportionment_value($db,$province_code){
        $sql = $db->prepare('SELECT MAX(apportion_id) AS marking_centre_serial FROM apportionment_summary WHERE province =:province_code');
        $sql->execute(array(
                ':province_code'=>$province_code
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
                $marking_centre_serial = $row['marking_centre_serial'];
                return $marking_centre_serial + 1;
        }else{
                $marking_centre_serial = 1;
                return $marking_centre_serial;
        }
}

//external

function apportionment_value_external($db,$province_code){
        $sql = $db->prepare('SELECT MAX(apportion_id) AS marking_centre_serial FROM marking_centre_centres WHERE province =:province_code');
        $sql->execute(array(
                ':province_code'=>$province_code
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
                $marking_centre_serial = $row['marking_centre_serial'];
                return $marking_centre_serial + 1;
        }else{
                $marking_centre_serial = 1;
                return $marking_centre_serial;
        }
}

function subject_more_than_1_paper($db,$subject_code){
        $sql = $db->prepare('SELECT subject_code FROM paper WHERE subject_code =:subject_code
                                GROUP BY subject_code HAVING COUNT(*) > 1');
        $sql->execute(array(
                ':subject_code'=>$subject_code
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}
function current_no_of_paperss($db,$nrc,$subject_code){
        $sql = $db->prepare('SELECT COUNT(subject_code) AS no_of_papers FROM examiner WHERE nrc =:nrc AND subject_code =:subject_code
                                GROUP BY subject_code');
        $sql->execute(array(
                ':nrc'=>$nrc,
                ':subject_code'=>$subject_code
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $no_of_papers = $row['no_of_papers'] ?? '';
        return $no_of_papers;

}

function prepend($db,$marking_centre_code){
        $sql = $db->prepare('UPDATE apportionment SET school = CONCAT("0",school) WHERE length(school) = 5 AND marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':marking_centre_code'=>$marking_centre_code
        ));
}
function remove_centres_not_exist($db,$marking_centre_code,$province_code){
        $sql = $db->prepare('DELETE FROM apportionment WHERE marking_centre =:marking_centre_code AND school NOT IN (SELECT centre_code FROM school WHERE province =:province)');
        $sql->execute(array(
                ':marking_centre_code'=>$marking_centre_code,
                ':province'=>$province_code
        ));
}
function remove_centres_not_exist_12_gce($db,$marking_centre_code){
        $sql = $db->prepare('DELETE FROM apportionment WHERE marking_centre =:marking_centre_code AND school NOT IN (SELECT centre_code FROM school)');
        $sql->execute(array(
                ':marking_centre_code'=>$marking_centre_code
        ));
}

function this_examiner_role_id($db,$subject_code,$paper_no,$role_id,$marking_centre_code,$province_code){
        $sql = $db->prepare('SELECT role FROM examiner WHERE subject_code =:subject_code AND paper_no =:paper_no AND role =:role_id AND marking_centre =:marking_centre_code AND province =:province_code');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':role_id'=>$role_id,
                ':marking_centre_code'=>$marking_centre_code,
                ':province_code'=>$province_code  
        ));
        if($sql->rowCount() > 0){

        
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $role_id = $row['role'];
        return $role_id;
        }else{
                return 'falser';
        }
}
function team_leader_exists($db,$subject_code,$paper_no,$role_id,$belt_no,$marking_centre_code,$province_code){
        $sql = $db->prepare('SELECT role FROM examiner WHERE subject_code =:subject_code AND paper_no =:paper_no AND belt_no =:belt_no AND role =:role_id AND role = 3 AND marking_centre =:marking_centre_code AND province =:province_code AND role = 3');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':belt_no'=>$belt_no,
                ':role_id'=>$role_id,
                ':marking_centre_code'=>$marking_centre_code,
                ':province_code'=>$province_code

                
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}

function checker_exists($db,$subject_code,$paper_no,$role_id,$belt_no,$marking_centre_code,$province_code){
        $sql = $db->prepare('SELECT role FROM examiner WHERE subject_code =:subject_code AND paper_no =:paper_no AND belt_no =:belt_no AND role = :role_id AND marking_centre =:marking_centre_code AND province =:province_code AND role = 2');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':belt_no'=>$belt_no,
                ':role_id'=>$role_id,
                ':marking_centre_code'=>$marking_centre_code,
                ':province_code'=>$province_code

                
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
}

function not_valid($db,$province_code,$session_type){
    if($session_type == 'I'){
        $sql = $db->prepare('SELECT apportion_id FROM apportionment_summary WHERE valid = 0 AND province =:province_code');
        $sql->execute(array(
                ':province_code'=>$province_code
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
    }else{
        $sql = $db->prepare('SELECT apportion_id FROM marking_centre_centres WHERE valid = 0 AND province =:province_code');
        $sql->execute(array(
                ':province_code'=>$province_code
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }
    }
}
function chief_examiner_username($db,$subject_code,$paper_no){
        $sql = $db->prepare('SELECT examiner_number FROM examiner WHERE subject_code =:subject_code AND paper_no =:paper_no AND role = "CHIEF EXAMINER" AND attendance = 1');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                $examiner_number = $row['examiner_number'] ?? '';
                return $examiner_number;
        }else{
                return 'null';
        }
}
function role_g12($db,$id){
        $sql = $db->prepare('SELECT role FROM examiner WHERE id =:id');
        $sql->execute(array(
                ':id'=>$id
        ));
        if($sql->rowCount() > 0){
                $row = $sql->fetch(PDO::FETCH_ASSOC);
                        $role = $row['role'] ?? '';
                        return $role;
        }else{
                return 'false';
        }
}

function centres_subjects_in_marksheet($db,$province_code){
        
                $sql = $db->prepare('SELEct centre_code FROM marks WHERE province = "00"
                                        AND centre_code IN (SELECT centre_code FROM school WHERE province =:province_code)');
                $sql->execute(array(
                        ':province_code'=>$province_code
                ));
                if($sql->rowCount() > 0){
                        return 'NOTICE: Make sure to activate set script movement after centre / script apportionment';
                }else{
                        return 'Marksheet status is ok';
                }
        
}
function activation_status($db,$username,$marking_centre_code){
        $sql = $db->prepare('SELECT activation_status FROM examiner WHERE role ="DATA ENTRY OFFICER" AND examiner_number =:username AND marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':username'=>$username,
                ':marking_centre_code'=>$marking_centre_code
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $active = $row['activation_status'] ?? '';
        return $active;
}
function activation_status_9($db,$username,$marking_centre_code){
        $sql = $db->prepare('SELECT activation_status FROM users WHERE user_type ="DEO" AND username =:username AND marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':username'=>$username,
                ':marking_centre_code'=>$marking_centre_code
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $active = $row['activation_status'] ?? '';
        return $active;
}
function login_status($db,$username){
        $sql = $db->prepare('SELECT login_status FROM examiner WHERE role = "DATA ENTRY OFFICER" AND examiner_number =:username');
        $sql->execute(array(
                ':username'=>$username
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $login_status = $row['login_status'] ?? '';
        return $login_status;

}
function update_login_status($db,$username){
        $sql = $db->prepare('UPDATE examiner SET login_status = 1 WHERE role = "DATA ENTRY OFFICER" AND examiner_number =:username');
        $sql->execute(array(
                ':username'=>$username
        ));
        return;
      
}
function logout($db,$username){
        $sql = $db->prepare('UPDATE examiner SET login_status = 0 WHERE role = "DATA ENTRY OFFICER" AND examiner_number =:username');
        $sql->execute(array(
                ':username'=>$username
        ));
        return;
       
}

function marrks_disabled($db,$exam_no,$centre_code,$subject_code,$paper_no,$username,$marking_centre_code){
        $sql = $db->prepare('SELECT disable FROM marks WHERE exam_no =:exam_no AND centre_code =:centre_code AND subject_code =:subject_code AND paper_no =:paper_no AND entered_by =:username AND marking_centre =:marking_centre_code AND disable = "1"');
        $sql->execute(array(
                ':exam_no'=>$exam_no,
                ':centre_code'=>$centre_code,
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':username'=>$username,
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql->rowCount() > 0){
                return 'true';
        }else{
                return 'false';
        }

}
function group_apportion($db,$subject_code,$paper_no,$belt_no,$username,$marking_centre_code,$province=null){
        try{
        
        $sql = $db->prepare('SELECT id FROM group_apportion WHERE subject=:subject_code AND paper =:paper_no AND belt_no =:belt_no AND marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':belt_no'=>$belt_no,
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql->rowCount() == 0){
                $sql1 = $db->prepare('INSERT INTO group_apportion(id,subject,paper,belt_no,marking_centre,username,date_created)
                                        VALUES(CONCAT(:marking_centre_code,"_",:subject_code,"_",:paper_no,"_",:belt_no),:subject_code,:paper_no,:belt_no,:marking_centre_code,:username, NOW())');
                 $sql1->execute(array(
                        ':subject_code'=>$subject_code,
                        ':paper_no'=>$paper_no,
                        ':belt_no'=>$belt_no,
                        ':username'=>$username,
                        ':marking_centre_code'=>$marking_centre_code
                ));
        }
}catch(PDOException $e){
        return $e->getMessage();
}
}
function add_in_apportionment($db,$centre_code,$subject_code,$paper_no,$sen,$belt_no,$marking_centre_code){
        $sql = $db->prepare('INSERT INTO apportionment(school,script_no,group_id,subject,paper,sen,belt_no,marking_centre,username,date_apportioned)
                              SELECT centre_code,COUNT(*) AS no_of_scripts,CONCAT(marking_centre,"_",subject_code,"_",paper_no,"_",belt_no) AS group_id,subject_code,paper_no,sen,belt_no,marking_centre,entered_by AS entered_by, MAX(date_entered)
                              FROM marks WHERE centre_code =:centre_code 
                              AND subject_code =:subject_code 
                              AND paper_no =:paper_no
                              AND sen =:sen 
                              AND belt_no =:belt_no 
                              AND marking_centre =:marking_centre_code
                              AND status = "-"
                              AND date_entered <> "none"
                              GROUP BY centre_code,subject_code,paper_no,sen,belt_no,marking_centre,entered_by
                              
                              ON DUPLICATE KEY UPDATE
                              script_no = VALUES (script_no),
                              username = VALUES(username),
                              date_apportioned = VALUES(date_apportioned)');
        $sql->execute(array(
                ':centre_code'=>$centre_code,
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':sen'=>$sen,
                ':belt_no'=>$belt_no,
                ':marking_centre_code'=>$marking_centre_code
        ));
        
}
function ted_group_apportion($db,$subject_code,$belt_no,$username,$marking_centre_code,$session_year){
        try{
        
        $sql = $db->prepare('SELECT id FROM group_apportion WHERE group_code IN (SELECT group_id FROM course WHERE course_code IN (SELECT course_id FROM subjects WHERE subject_code =:subject_code)) AND belt_no =:belt_no AND marking_centre =:marking_centre_code AND session =:session');
        $sql->execute(array(
                ':subject_code'=>$subject_code,
                ':session'=>$session_year,
                ':belt_no'=>$belt_no,
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql->rowCount() == 0){
                $sql1 = $db->prepare('INSERT INTO group_apportion(id,group_code,belt_no,marking_centre,username,date_created,session)
                                        SELECT CONCAT(:marking_centre_code,"_",cg.group_code,"_":belt_no),cg.group_code,:belt_no,:marking_centre_code,:username,NOW(),:session
                                        FROM course_group cg INNER JOIN course c ON (cg.group_code = c.group_id)
                                        INNER JOIN subjects su ON (c.course_code = su.course_id)
                                        WHERE su.subject_code =:subject_code
                                        ');
                 $sql1->execute(array(
                        ':subject_code'=>$subject_code,
                        ':session'=>$session_year,
                        ':belt_no'=>$belt_no,
                        ':username'=>$username,
                        ':marking_centre_code'=>$marking_centre_code
                ));
        }
}catch(PDOException $e){
        return $e->getMessage();
}
}
function ted_add_in_apportionment($db,$centre_code,$subject_code,$belt_no,$marking_centre_code){
        $sql = $db->prepare('INSERT INTO apportionment(school,script_no,group_apportion_id,group_code,course,subject,belt_no,marking_centre,username,date_apportioned,session)
                              SELECT m.centre_code AS centre_code,SUM(m.status = "-") AS no_of_scripts,CONCAT(m.marking_centre,"_",cg.group_code,"_",m.belt_no) AS group_id,cg.group_code AS group_code, c.course_code AS course_code,m.subject_code,m.belt_no,m.marking_centre,m.entered_by AS entered_by, MAX(m.date_entered), m.session
                              FROM marks m INNER JOIN subjects su ON (m.subject_code = su.subject_code)
                              INNER JOIN course c ON (su.course_id = c.course_code)
                              INNER JOIN course_group cg ON (c.group_id =  cg.group_code)
                              
                              WHERE m.centre_code =:centre_code 
                              AND m.subject_code =:subject_code
                              AND m.belt_no =:belt_no 
                              AND m.marking_centre =:marking_centre_code
                              AND date_entered <> "none"
                              GROUP BY m.centre_code,m.subject_code,m.sen,m.belt_no,m.marking_centre,cg.group_code,c.course_code,m.entered_by,m.session
                              
                              ON DUPLICATE KEY UPDATE
                              script_no = VALUES (script_no),
                              username = VALUES(username),
                              date_apportioned = VALUES(date_apportioned)');
        $sql->execute(array(
                ':centre_code'=>$centre_code,
                ':subject_code'=>$subject_code,
                ':belt_no'=>$belt_no,
                ':marking_centre_code'=>$marking_centre_code
        ));
        
}
function deduct_improvised_script($db,$centre_code,$subject_code,$paper_no,$sen,$marking_centre_code){
        $sql = $db->prepare('UPDATE apportionment SET script_no  =script_no - 1 WHERE school =:centre_code
                                AND subject =:subject_code
                                AND paper =:paper_no
                                AND sen =:sen
                                AND marking_centre =:marking_centre_code');
        $sql->execute(array(
                ':centre_code'=>$centre_code,
                ':subject_code'=>$subject_code,
                ':paper_no'=>$paper_no,
                ':sen'=>$sen,
                ':marking_centre_code'=>$marking_centre_code
        ));
}
function ted_add_improvised_script($db,$centre_code,$subject_code,$marking_centre_code,$session_year){
        $sql = $db->prepare('UPDATE apportionment SET script_no  =script_no + 1 WHERE school =:centre_code
                                AND subject =:subject_code
                                AND marking_centre =:marking_centre_code
                                AND session =:session
                                ');
        $sql->execute(array(
                ':centre_code'=>$centre_code,
                ':subject_code'=>$subject_code,
                ':session'=>$session_year,
                ':marking_centre_code'=>$marking_centre_code
        ));
}
function ted_deduct_improvised_script($db,$centre_code,$subject_code,$marking_centre_code,$session_year){
        $sql = $db->prepare('UPDATE apportionment SET script_no  =script_no - 1 WHERE school =:centre_code
                                AND subject =:subject_code
                                AND marking_centre =:marking_centre_code
                                AND session =:session
                                ');
        $sql->execute(array(
                ':centre_code'=>$centre_code,
                ':subject_code'=>$subject_code,
                ':session'=>$session_year,
                ':marking_centre_code'=>$marking_centre_code
        ));
}
function claims_exist_gcge_g12($db,$marking_centre_code){
        $sql1 = $db->prepare('SELECT marking_centre_name,examiner_number,nrc,tpin,full_name,address,province,district,position,no_of_scripts,bank,branch,sortcode,account_no,gross_pay,15_wht,net_pay,subject_code,subject_name,paper_no,belt_no
        FROM examiner_claim WHERE marking_centre_code =:marking_centre_code');
        $sql1->execute(array(
                ':marking_centre_code'=>$marking_centre_code
        ));
        $sql2 = $db->prepare('SELECT marking_centre_name,examiner_number,nrc,tpin,full_name,address,province,district,position,no_of_scripts,bank,branch,sortcode,account_no,gross_pay,15_wht,net_pay,subject_code,subject_name,paper_no,belt_no
        FROM data_entry_claims WHERE marking_centre_code =:marking_centre_code');
          $sql2->execute(array(
                ':marking_centre_code'=>$marking_centre_code
        ));
        if($sql1->rowCount() == 0 || $sql2->rowCount() == 0){
                return 'false';
        }else{
                return 'true';
        }
}

function append_0($db){
        $sql = $db->prepare('UPDATE marks SET centre_code = CONCAT(0,centre_code) WHERE LENGTH(centre_code) = 5');
        $sql->execute();
}

function remove_subject_paper_from_marksheet_not_belong($db){
        $sql = $db->prepare('DELETE FROM marks WHERE (subject_code,paper_no) NOT IN (SELECT subject_code,paper_no FROM paper)');
        $sql->execute();
        return $sql->rowCount();
}
//  function absa_account_length($db,$accout_no_length){
//         $sql = $db->prepare('SELECT LENGTH(account_no)');
//  }
// function subject_apportioned($db,$centre_code,$subject_code,$sen){
//         $sql = $db->prepare('SELECT DISTINCT centre_code,subject_code,sen FROM marks_prep WHERE centre_code =:centre_code AND subject_code =:subject_code AND sen =:sen');
//         $sql->execute(array(
//                 ':centre_code'=>$centre_code,
//                 ':subject_code'=>$subject_code,
//                 ':sen'=>$sen
//         ));
//         if($sql->rowCount() > 0){
//                 return 'true';
//         }else{
//                 return 'false';
//         }
// }
// function centre_in_belt($db,$school,$subject,$paper,$marking_centre_code,$province_code){
//         $sql = $db->prepare('SELECT belt_no FROM apportionment WHERE school =:school AND subject =:subject AND paper =:paper AND marking_centre =:marking_centre_code AND province =:province_code');
//         $sql->execute(array(
//                 ':school'=>$school,
//                 ':subject'=>$subject,
//                 ':paper'=>$paper,
//                 ':paper'=>$paper,
//                 ':marking_centre_code'=>$marking_centre_code,
//                 ':province_code'=>$province_code
//         ));
//         if($sql->rowCount() > 0){
//                 $row = $sql->fetch(PDO::FETCH_ASSOC);
//                 $belt_no = $row['belt_no'];
//                 return $belt_no;
//         }else{
//                 return 'false';
//         }
// }
?>