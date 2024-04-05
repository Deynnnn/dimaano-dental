<?php
    require ('../admin/includes/dbConfig.php');
    require ('../admin/includes/essentials.php');
    require ("../includes/Mail/phpmailer/PHPMailerAutoload.php");
    date_default_timezone_set("Asia/Manila");
    session_start();

    if(isset($_POST['review_form'])){
        $frm_data = filteration($_POST);
        
         // Corrected UPDATE query
        $upd_query = "UPDATE `appointment_order` SET `rate_review`=? WHERE `id`=? AND `patient_id`=?";
        $upd_values = [1, $frm_data['id'], $_SESSION['uId']];
        $upd_result = update($upd_query, $upd_values, 'iii');

        // Corrected INSERT query
        $ins_query = "INSERT INTO `rating_review`(`appointment_id`, `service_id`, `patient_id`, `rating`, `review`) VALUES(?,?,?,?,?)";
        $ins_values = [$frm_data['id'], $frm_data['service_id'], $_SESSION['uId'], $frm_data['rating'], $frm_data['review']];
        $ins_result = insert($ins_query, $ins_values, 'iiiis');

        if($ins_result){
            echo 1;
        }else{
            echo 0;
        }
    }
?>