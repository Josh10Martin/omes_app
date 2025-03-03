<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();

if(isset($_FILES['upload']['name'])){
    $name = $_FILES['upload']['name'];
    $file_path = $_FILES['upload']['tmp_name'];
   

    // Assign session values to variables
    $marking_centre_code = $_SESSION['marking_centre_code'];
    $province = $_SESSION['province_code'];
    $session_id = $_SESSION['session_id'];

    $file_name = explode('.', $name);
    $file_extension = $file_name[1];
    
    try {
        if (($handle = fopen($file_path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');

            $sql = $db_9->prepare('INSERT IGNORE INTO examiner (nrc, tpin, first_name, last_name, phone_number,title,role, belt_no, no_of_days, subject_code,paper_no,address,attendance, marking_centre, province, session) VALUES (:nrc, :tpin, :first_name, :last_name, :phone_number,:title,:role, :belt_no, :no_of_days, :subject_code,"1",:address,"1",:marking_centre_code, :province, :session)');
            
            // Bind parameters
            $sql->bindParam(':nrc', $nrc, PDO::PARAM_STR);
            $sql->bindParam(':tpin', $tpin, PDO::PARAM_STR);
            $sql->bindParam(':first_name', $first_name, PDO::PARAM_STR);
            $sql->bindParam(':last_name', $last_name, PDO::PARAM_STR);
            $sql->bindParam(':phone_number', $phone_number, PDO::PARAM_STR);
            $sql->bindParam(':title', $title, PDO::PARAM_STR);
            $sql->bindParam(':role', $role, PDO::PARAM_INT);
            $sql->bindParam(':belt_no', $belt_no, PDO::PARAM_INT);
            $sql->bindParam(':no_of_days', $no_of_days, PDO::PARAM_INT);
            $sql->bindParam(':subject_code', $subject_code, PDO::PARAM_STR);
            $sql->bindParam(':address', $address, PDO::PARAM_STR);
            $sql->bindParam(':marking_centre_code', $marking_centre_code, PDO::PARAM_STR);
            $sql->bindParam(':province', $province, PDO::PARAM_STR);
            $sql->bindParam(':session', $session_id, PDO::PARAM_STR);

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $nrc = $data[0];
                $tpin = $data[1];
                $first_name = $data[2];
                $last_name = $data[3];
                $phone_number = $data[4];
                $title = $data[5];
                $role = $data[6];
                $belt_no = $data[7];
                $no_of_days = $data[8];
                $subject_code = $data[9];
                $address = $data[10];

                $sql->execute();
            }
            fclose($handle);
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Successfully uploaded data.';
        } else {
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'There was a problem opening the CSV file';
        }
    } catch (PDOException $e) {
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: ' . $e->getMessage();
    }
} else {
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Not all parameters are set';
}

echo json_encode($data_array);
?>
