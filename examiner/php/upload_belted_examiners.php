<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();

if (isset($_FILES['myFile']['name']) && isset($_SESSION['username'])) {
    $name = $_FILES['myFile']['name'];
    $file_path = $_FILES['myFile']['tmp_name'];
   

    // Assign session values to variables
    $marking_centre_code = $_SESSION['marking_centre_code'];
    $username = $_SESSION['username'] . ' - ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];

    $file_name = explode('.', $name);
    $file_extension = $file_name[1];
    
    if($file_extension == 'csv'){
        try {
        if (($handle = fopen($file_path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');

            $sql = $db_12_gce->prepare('INSERT IGNORE INTO belted_examiners (examiner_number, subject_code, paper_no, belt_no,uploaded_by, date_uploaded, marking_centre) VALUES (:examiner_number, :subject_code, :paper_no, :belt_no, :username, NOW(), :marking_centre_code)');
            
            // Bind parameters
            $sql->bindParam(':examiner_number', $examiner_number, PDO::PARAM_STR);
            $sql->bindParam(':subject_code', $subject_code, PDO::PARAM_STR);
            $sql->bindParam(':paper_no', $paper_no, PDO::PARAM_INT);
            $sql->bindParam(':belt_no', $belt_no, PDO::PARAM_INT);
            $sql->bindParam(':marking_centre_code', $marking_centre_code, PDO::PARAM_STR);
            $sql->bindParam(':username', $username, PDO::PARAM_STR);

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $examiner_number = $data[0];
                $subject_code = $data[1];
                $paper_no = $data[2];
                $belt_no = $data[3];

                $sql->execute();
            }
            fclose($handle);
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Successfully uploaded data. ';
        } else {
            $data_array['status'] = '400';
            $data_array['response_msg'] = 'There was a problem opening the CSV file';
        }
    } catch (PDOException $e) {
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'There was an error: ' . $e->getMessage();
    }
    }else{
        $data_array['status'] = '400';
        $data_array['response_msg'] = 'File extension should be .csv';
    }
} else {
    $data_array['status'] = '400';
    $data_array['response_msg'] = 'Not all parameters are set';
}

echo json_encode($data_array);
?>
