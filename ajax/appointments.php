<?php
    require ('../admin/includes/dbConfig.php');
    require ('../admin/includes/essentials.php');
    require ("../includes/Mail/phpmailer/PHPMailerAutoload.php");
    date_default_timezone_set("Asia/Manila");
    session_start();

    function sendMail($ticket){
        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host='smtp_host';
        $mail->Port='smtp port';
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username='smtp_email';
        $mail->Password='smtp_password';

        $mail->setFrom('smtp_email', 'Appointment Cancellation');
        $mail->addAddress('reciever email');

        $mail->isHTML(true);
        $mail->Subject= 'Appointment Cancellation';
        $mail->Body="<div id='wrapper' style='
        background-color: #f0f6fb; 
        font-family: 'Roboto', sans-serif; font-size: 19px;
        max-width: 800px;
        margin: 0 auto;
        padding: 3%;'>
    
            <header
            style='
            width: 98%;
            display: flex;
            align-items: center;
            justify-content: center;
            '
            >
                <div id='logo'>
                    <img
                        src='images/logo.png'
                        width='100'
                        style='max-width: 100%'
                        alt=''
                    />
                </div>
                <div>
                    <h1>Dimaano Dental Clininc</h1>
                    <p id='contact' style='
                    text-align: center;
                    padding-bottom: 3%;
                    line-height: 16px;
                    font-size: 12px;
                    color: #303840;
                    '>
                        Poblaction 2 
                        Victoria 
                        5205, Oriental Mindoro 
                        dimaanoDental@gmail.com
                    </p>
                </div>
            </header>
            <hr style='height: 1px;
            background-color: #303840;
            clear: both;
            width: 96%;
            margin: auto;'/>
    
            <div style='padding: 15px;'>
                <p><b>Dear ,</b></p>
                <p style='text-indent: 20px;'>Appointment schedule cancelled by the patient, identified by appointment number <b>$ticket</b>, has been declined.</p>
    
                <footer>
                <p style='
                    text-align: center;
                    padding-bottom: 3%;
                    line-height: 16px;
                    font-size: 12px;
                    color: #303840;
                    '>
                    <i>*This is an automatically generated email* DO NOT REPLY</i>
                </p>
                </footer>
            </div>
        </div>";

        if ($mail->send()) {
            return 1;
        } else {
            return 0;
        }
    }

    if(isset($_POST['cancel_appointment'])){
        $frm_data = filteration($_POST);

        $q = 'UPDATE `appointment_order` SET `appointment_status`=?, `refund`=? WHERE `id`=? AND `patient_id`=?';
        $v = ['Cancelled', 0, $frm_data['id'], $_SESSION['uId']];
        $r = update($q, $v, 'siii');

        // if(!sendMail($frm_data["order_id"])){
        //     echo 'mail_failed';
        //     exit;
        // }

        if($r){
            echo 1;
        }else{
            echo 0;
        }
    }

    // if(isset($_GET['search'])){
    //     $filterval = $_GET['search'];
    //     $query = "SELECT * FROM appointment_order WHERE order_id LIKE '%$filterval%";
    //     $res = mysqli_query($con, $query);

    //     if(mysqli_num_rows($res) > 0){
    //         foreach($res as $items){
    //             $created_at = date('d-m-Y', strtotime($items['created_at']));
    //             $date = date('m-d-Y', strtotime($items['date']));
    //             $time = date('h:m:s a', strtotime($items['time']));

    //             $price = $items['total_pay'];
    //             $formatedPrice = number_format($price,2,'.',',');

    //             $status_bg = '';

    //             if($items['appointment_status']  == 'Accepted'){
    //                 $status_bg = 'bg-success';
    //             }else{
    //                 $status_bg = 'bg-danger';
    //             }
    //             echo<<<dataFound
    //             <div class='col-md-4 px-4 mb-4'>
    //                 <div class='p-3 rounded shadow-sm' style="background-color: rgba(255, 99, 132, 0.2);border: 2px solid rgb(255, 99, 132);">
    //                     <p class='badge bg-dark'>
    //                         <b>Order ID: </b>$items[order_id]
    //                     </p>
    //                     <h5 class='fw-bold'>$items[service_name]</h5>
    //                     <p>₱$formatedPrice</p>
    //                     <p class='badge text-dark' style="background-color: rgba(255, 99, 132, 0.4);">
    //                         <b>Prefered Date: </b>$date
    //                     </p>
    //                     <p class='badge text-dark' style="background-color: rgba(255, 99, 132, 0.4);">
    //                         <b>Prefered Time: </b>$time
    //                     </p>
    //                     <p>
    //                         <b>Amount: </b>₱$formatedPrice<br>
    //                         <b>Date: </b> $created_at
    //                     </p>
    //                     <div class="container">
    //                         <div class="row">
    //                                 <p class='badge $status_bg fs-6'>$items[appointment_status]</p>
    //                                 <button onclick='cancel_appointment($items[id], "$items[order_id]")' type='button' class='btn btn-outline-dark btn-sm shadow-none'>
    //                                 Download PDF
    //                                 <i class="bi bi-filetype-pdf"></i>
    //                                 </button>
    //                         </div>
    //                     </div>
    //                 </div>
    //             </div>
    //             dataFound;
    //         }
            
    //     }else{
    //         echo<<<noData
    //             <h1>No Records Found</h1>
    //         noData;
    //     }
    // }