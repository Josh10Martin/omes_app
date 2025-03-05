<?php
session_start();
header('COntent-Type: application/json;charset=utf-8');
include '../../config.php';
$data_array = array();
$subject = array();

if($_SESSION['session_type']=='I'){
        if(isset($_POST['district']) && isset($_POST['subject_code'])){
                $_POST=filter_var_array($_POST);
                $subject_codes = $_POST['subject_code'];
                $districts = $_POST['district'];
                if(is_array($subject_codes) || is_array($districts)){
                        
                        $in_subjects = implode(', ', $subject_codes);
                        $in_districts = implode(', ', $districts);
                        $province = $_SESSION['province_code'];
                
                        $sql = $db_9->prepare("SELECT DISTINCT sc.centre_code AS centre_code, sc.centre_name AS centre_name FROM school sc INNER JOIN school_subject ss ON (sc.centre_code = ss.centre_code)
                        WHERE sc.province = ? AND sc.district IN (".$in_districts.") AND ss.subject_code IN (".$in_subjects.")
                        AND ss.centre_code NOT IN (SELECT centre_code FROM marks_prep WHERE subject_code IN (".$in_subjects."))
                        ORDER BY sc.centre_code ASC");
                $sql->execute([$province]);
        
                if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $i =0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                $i++;
                }
                }else{
                $data_array['status'] = '400';
                $data_array['districts'] = $in_districts;
                }
               
        }
                
                        
                
        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'District parameters not set';
        }
}else{
        if(isset($_POST['district']) && isset($_POST['subject_cod'])){
                $_POST=filter_var_array($_POST);
                $districts = $_POST['district'];
                $subject_cpdes = $_POST['subject_cpde'];
                if(is_array($districts) && is_array($subject_cpdes)){
                
                        $in_districts = implode(', ', $districts);
                        $in_subjects = implode(', ', $subject_cpdes);
                        $province = $_SESSION['province_code'];
                
                        $sql = $db_9->prepare("SELECT DISTINCT centre_code AS centre_code, centre_name AS centre_name FROM school  
                        WHERE province = ? AND district IN (".$in_districts.")
                        AND centre_code NOT IN (SELECT centre_code FROM marking_centre_centres WHERE subject_code IN (".$in_subjects."))
                        AND centre_type = ?
                        ORDER BY centre_code ASC");
                $sql->execute([$province,$_SESSION['session_type']]);
        
                if($sql->rowCount() > 0){
                $data_array['status'] = '200';
                $i =0;
                while($row = $sql->fetch(PDO::FETCH_ASSOC)){
                $data_array[$i]['centre_code'] = $row['centre_code'] ?? '';
                $data_array[$i]['centre_name'] = $row['centre_name'] ?? '';
                $i++;
                }
                }else{
                $data_array['status'] = '400';
                $data_array['districts'] = $in_districts;
                }
               
        }


        }else{
                $data_array['status'] = '400';
                $data_array['response_msg'] = 'District parameters not set';
        }
}

echo json_encode($data_array);
?>