<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../config.php';
$data_array = array();
if(isset($_POST['username'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sess_id = $_POST['sess_id'];
        $session_name = $_POST['session_name'];
        $session_year = $_POST['session_year'];
        $session_level = $_POST['session_level'];
        $level = $_POST['level'];
        $session_type = $_POST['session_type'];

        // $sess_id_db_ted = $_POST['sess_id_db_ted'];
        // $session_name_db_ted = $_POST['session_name_db_ted'];
        // $session_year_db_ted = $_POST['session_year_db_ted'];
        // $session_level_db_ted = $_POST['session_level_db_ted'];
        // $session_level_db_ted = $_POST['session_level_db_ted'];
        // $session_type_db_ted = $_POST['session_type_db_ted'];


        $option = array('cost'=>12);
        if($level == '9'){
                
        $sql = $db_9->prepare('SELECT u.username AS username, u.password AS password, u.first_name AS first_name, u.last_name AS last_name,
                                u.province AS province_code, u.first_login AS first_login, p.p_name AS province_name, u.user_type AS user_type, u.activation_status AS active,
                                c.centre_code AS marking_centre_code, c.name AS marking_centre, s.subject_code AS subject_code, s.subject_name AS subject_name, pa.paper_no AS paper_no
                                FROM province p
                                LEFT OUTER JOIN users u ON (p.p_code = u.province)
                                LEFT OUTER JOIN centre c ON (u.province = c.province)
                                LEFT OUTER JOIN marking_centre mc ON (c.centre_code = mc.centre_code)
                                LEFT OUTER JOIN subjects s ON (mc.subject = s.subject_code)
                                LEFT OUTER JOIN paper pa ON (s.subject_code = pa.subject_code)
                                WHERE (u.province IS NULL OR u.province = mc.province)
                                AND (mc.subject IS NULL OR u.marking_centre = mc.centre_code)
                                AND u.username =:username
                                UNION
                                SELECT u.username AS username, u.password AS password,u.first_name AS first_name, u.last_name AS last_name,
                                u.province AS province_code,u.first_login AS first_login, p.p_name AS province_name, u.user_type AS user_type,u.activation_status AS active,
                                c.centre_code AS marking_centre_code, c.name AS marking_centre,null AS subject_code,null AS subject_name,null AS paper_no
                                FROM users u
                                LEFT OUTER JOIN centre c ON (u.marking_centre = c.centre_code AND u.province = c.province)
                                LEFT OUTER JOIN province p ON (u.province = p.p_code)
                                WHERE u.province = p.p_code
                                AND u.username =:username
                                ');
        $sql->execute(array(
                ':username'=>$username
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $password_hash = $row['password'] ?? '';
        $active = $row['active'] ?? '';
        $user_type = $row['user_type'] ?? '';
        $first_login = $row['first_login'] ?? '';
        $db_username = $row['username'] ?? '';
        $password_verify = password_verify($password,$password_hash);
        if($username == $db_username && $password_verify){
                if(password_needs_rehash($password_hash,PASSWORD_BCRYPT,$option)){
                        $password_hash = password_hash($password,PASSWORD_BCRYPT,$option);
                }
                if($active == 0){
                        $entity = $user_type == 'SESO' ? 'the Examinations Council of Zambia' : ($user_type == 'ADMIN' ? 'your SESO' : 'your SYstems Administrator');
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Your account is not active. Contact '.$entity.' to have it activated';
                }else if($first_login == 'true') {
                        $data_array['status'] = '200';
                        $data_array['first_login'] = 'true';
                        $_SESSION['username'] = $row['username'] ?? '';

                }else{
                        $data_array['status'] = '200';
                        $data_array['level'] = '9';
                        $_SESSION['username'] = $row['username'] ?? '';
                        $_SESSION['first_name'] = $row['first_name'] ?? '';
                        $_SESSION['last_name'] = $row['last_name'] ?? '';
                        $_SESSION['province_code'] = $row['province_code'] ?? '';
                        $_SESSION['province_name'] = $row['province_name'] ?? '';
                        $_SESSION['user_type'] = $row['user_type'] ?? '';
                        $_SESSION['marking_centre'] = $row['marking_centre'] ?? '';
                        $_SESSION['marking_centre_code'] = $row['marking_centre_code'] ?? '';
                        $_SESSION['subject_code'] = $row['subject_code'] ?? '';
                        $_SESSION['subject_name'] = $row['subject_name'] ?? '';
                        $_SESSION['paper_no'] = $row['paper_no'] ?? '';
                        $_SESSION['session_id'] = $sess_id;
                        $_SESSION['session_name'] = $session_name;
                        $_SESSION['session_year'] = $session_year;
                        $_SESSION['session_level'] = $session_level;
                        $_SESSION['session_type'] = $session_type;
                }
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'username and password do not match. Grade 9 login';
        }

        }else{
                if($level == 'ted'){
                        $sql = $db_ted->prepare('SELECT u.username AS username, u.password AS password,u.first_name AS first_name, u.last_name AS last_name,
                                u.province AS province_code, null AS province_name, u.user_type AS user_type,u.activation_status AS active,
                                c.centre_code AS marking_centre_code, c.name AS marking_centre
                                FROM  users u LEFT OUTER JOIN centre c ON (u.marking_centre = c.centre_code)
                                LEFT  OUTER JOIN marking_centre mc ON (c.centre_code = mc.centre_code)
                                LEFT OUTER JOIN course co ON (mc.course = co.course_code)
                               
                                WHERE  u.username =:username

                                ');
        $sql->execute(array(
                ':username'=>$username
        ));
        $row = $sql->fetch(PDO::FETCH_ASSOC);
        $password_hash = $row['password'] ?? '';
        $active = $row['active'] ?? '';
        $user_type = $row['user_type'] ?? '';
        $db_username = $row['username'] ?? '';
        $password_verify = password_verify($password,$password_hash);
        if($username == $db_username && $password_verify){
                if(password_needs_rehash($password_hash,PASSWORD_BCRYPT,$option)){
                        $password_hash = password_hash($password,PASSWORD_BCRYPT,$option);
                }
                if($active == 0){
                        $entity = $user_type == 'SESO' ? 'the Examinations Council of Zambia' : ($user_type == 'ADMIN' ? 'your SESO' : 'your SYstems Administrator');
                        $data_array['status'] = '400';
                        $data_array['response_msg'] = 'Your account is not active. Contact '.$entity.' to have it activated';
                }else{
                        $data_array['status'] = '200';
                        $data_array['level'] = 'ted';
                        $_SESSION['username'] = $row['username'] ?? '';
                        $_SESSION['first_name'] = $row['first_name'] ?? '';
                        $_SESSION['last_name'] = $row['last_name'] ?? '';
                        $_SESSION['province_code'] = $row['province_code'] ?? '';
                        $_SESSION['province_name'] = $row['province_name'] ?? '';
                        $_SESSION['user_type'] = $row['user_type'] ?? '';
                        $_SESSION['marking_centre'] = $row['marking_centre'] ?? '';
                        $_SESSION['marking_centre_code'] = $row['marking_centre_code'] ?? '';
                        $_SESSION['subject_code'] = $row['subject_code'] ?? '';
                        $_SESSION['subject_name'] = $row['subject_name'] ?? '';
                        $_SESSION['paper_no'] = $row['paper_no'] ?? '';
                        $_SESSION['session_id'] = $sess_id_db_ted;
                        $_SESSION['session_name'] = $session_name_db_ted;
                        $_SESSION['session_year'] = $session_year_db_ted;
                        $_SESSION['session_level'] = $session_level_db_ted;
                        $_SESSION['session_type'] = $session_type_db_ted;
                }
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'username and password do not match. Teacher Education login';
        }
                }
        }
}else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'Parameters not set. Please reload / refresh the page and try again. If this continues, change the browser and try again';
}
echo json_encode($data_array);
?>