<?php
session_start();
header('Content-Type: application/json;charset=utf-8');
include '../../functions.php';
include '../../config.php';
$data_array = array();

if (isset($_FILES['myFile']['name']) && isset($_POST['group_id']) && isset($_POST['subject_code']) && isset($_POST['paper_no']) && isset($_POST['belt_no'])) {
    $name = $_FILES['myFile']['name'];
    $file_path = $_FILES['myFile']['tmp_name'];
    $group_id = $_POST['group_id'];
    $subject_code = $_POST['subject_code'];
    $paper_no = $_POST['paper_no'];
    $belt_no = $_POST['belt_no'];

    // Assign session values to variables
    $marking_centre_code = $_SESSION['marking_centre_code'];
    $province = $_SESSION['province_code'];
    $username = $_SESSION['username'] . ' - ' . $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];

    $file_name = explode('.', $name);
    $file_extension = $file_name[1];
    
    try {
        if (($handle = fopen($file_path, 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ',');

            $sql = $db_9->prepare('INSERT IGNORE INTO apportionment (school, script_no, group_id, subject, paper, belt_no, marking_centre, province, username, date_apportioned) VALUES (:centre_code, :script_no, :group_id, :subject_code, :paper_no, :belt_no, :marking_centre_code, :province, :username, NOW())');
            
            // Bind parameters
            $sql->bindParam(':centre_code', $centre_code, PDO::PARAM_STR);
            $sql->bindParam(':script_no', $script_no, PDO::PARAM_INT);
            $sql->bindParam(':group_id', $group_id, PDO::PARAM_STR);
            $sql->bindParam(':subject_code', $subject_code, PDO::PARAM_STR);
            $sql->bindParam(':paper_no', $paper_no, PDO::PARAM_INT);
            $sql->bindParam(':belt_no', $belt_no, PDO::PARAM_INT);
            $sql->bindParam(':marking_centre_code', $marking_centre_code, PDO::PARAM_STR);
            $sql->bindParam(':province', $province, PDO::PARAM_STR);
            $sql->bindParam(':username', $username, PDO::PARAM_STR);

            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                $centre_code = $data[0];
                $script_no = $data[1];

                $sql->execute();
            }
            fclose($handle);
            $data_array['status'] = '200';
            $data_array['response_msg'] = 'Successfully uploaded data. Note that all duplicate data will be discarded';
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
