<?php
    require('admin/includes/dbConfig.php');
    require('admin/includes/essentials.php');
    session_start();

    if(isset($_POST['submit'])){
        $frm_data = filteration($_POST);

        $user_res =select("SELECT * FROM `patients` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 'i');
        $user_data = mysqli_fetch_assoc($user_res);
        $patient_name = $user_data['first_name']." ".$user_data['last_name'];
        $ORDER_ID = 'APP_'.$_SESSION['uId'].random_int(111,999);
        $CUST_ID = $_SESSION['uId'];

        $query1 = "INSERT INTO `appointment_order`(`patient_id`, `service_id`, `date`, `time`, `order_id`,  `trans_amt`, `trans_status`) VALUES (?,?,?,?,?,?,?)";
        insert($query1, [$CUST_ID, $_SESSION['service']['id'],$frm_data['date'],$frm_data['time'],$ORDER_ID,$frm_data['amount'], 'pending'], 'issssis');
        $booking_id = mysqli_insert_id($con);

        $query2 = "INSERT INTO `appointment_details`(`appointment_id`, `service_name`, `price`, `total_pay`, `patient_name`, `patient_email`, `phone_num`, `address`) VALUES (?,?,?,?,?,?,?,?)";
        insert($query2, [$booking_id, $_SESSION['service']['name'], $_SESSION['service']['price'],$frm_data['amount'],$patient_name, $user_data['email'],$user_data['conNum'],$user_data['address']],'isssssss');
        
        redirect('appointments.php');
    } 
?>