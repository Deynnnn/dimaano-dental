<?php
    require('../includes/essentials.php');
    require('../includes/dbConfig.php'); 
    require ("../../includes/Mail/phpmailer/PHPMailerAutoload.php");
    adminLogin();
    date_default_timezone_set("Asia/Manila");

    function send_mail($email, $type, $ticket, $date, $time, $contact_number){
        $type = 'appointment_accepted';
        $page = 'app_portal.php';
        $subject = 'Dimaano Dental Clinic - Appointment Accepted';
        $content = 'Appointment Accepted';
        $status = 'ACCEPTED';
        
        

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host='smtp.gmail.com';
        $mail->Port=587;
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username='deyndeyn727@gmail.com';
        $mail->Password='zwkkjcfbacijseku';

        $mail->setFrom('deyndeyn727@gmail.com', $subject);
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject= $subject;
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
                        src='../../images/logo.png'
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
                <p><b>Dear Patient,</b></p>
                <br><br>
                <p style='text-indent: 20px;'>We want to notify you that your dental appointment request, identified by appointment ticket number <b>$ticket</b>, has been $status <b>$date</b> at <b>$time</b>. To see details of your appointment login to you account.</p>
    
                <hr style='height: 1px;
                background-color: #303840;
                clear: both;
                width: 96%;
                margin: auto;'/>
    
                <footer>
                <p style='
                    text-align: center;
                    padding-bottom: 3%;
                    line-height: 16px;
                    font-size: 12px;
                    color: #303840;
                    '>
                    <i>*This is an automatically generated email * DO NOT REPLY</i>
                </p>
                </footer>
            </div>
        </div>";

        $ch = curl_init();
        $parameters = array(
            'apikey' => '4cfb842bbb619d7b04aa93cfd5e84d09', //Your API KEY
            'number' => $contact_number,
            'message' => "We want to notify you that your dental appointment on Dimaano Dental Clinic request has been accepted. Settle your payment visit our website for instructions. Manage appointment using your email and appointment number:  $ticket",
            'sendername' => 'SEMAPHORE'
        );
        curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        if ($mail->send()) {
            return 1;
            echo $output;
        } else {
            return 0;
        }
    }

    if(isset($_POST['get_appointments']))
    {
        $frm_data = filteration($_POST);

        $query = "SELECT ao.*, ad.* FROM `appointment_order` ao INNER JOIN `appointment_details` ad ON ao.id = ad.appointment_id WHERE (ao.order_id LIKE ? OR ad.phone_num LIKE ? OR ad.patient_name LIKE ?) AND ao.appointment_status = 'Pending' ORDER BY ao.id ASC";

        $res = select($query, ["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"], 'sss');
        $i = 1;
        $table_data = "";
        // $data = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res)==0){
            echo"<b>No Data Found!</b>";
            exit;
        }
        // $status_bg ='';
        // if($data['booking_status'] == 'booked'){
        //     $status_bg = "bg-primary";
        // }else if($data['booking_status'] == 'pending payment'){
        //     $status_bg = "bg-warning";
        // }
        while($data = mysqli_fetch_assoc($res)){
            $date = date("d-m-Y", strtotime($data['date']));
            $table_data .="
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge' style='background-color: rgb(165,16,18);'>
                        Order ID: $data[order_id]
                        </span>
                        <br>
                        <b>Name:</b> $data[patient_name]
                        <br>
                        <b>Phone No:</b> $data[phone_num]
                    </td>
                    <td>
                        <b>Service:</b> $data[service_name]
                        <br>
                        <b>Price:</b>₱$data[price]
                        <br>
                    </td>
                    <td>
                        <b>Paid:</b> ₱$data[total_pay]
                        <br>
                        <b>Date:</b> $date
                    </td>
                    <td>
                    <button type='button' onclick= accept_appointment($data[id],'$data[patient_email]','$data[order_id]','$data[date]','$data[time]','$data[phone_num]') class='btn btn-success shadow-none btn-sm mb-2 mt-2'>
                        ACCEPT
                    </button>
                    </td>
                </tr>
            ";
            $i++;
        }
        echo $table_data;
    }

    //done
    if(isset($_POST['accept_appointment'])){
        $frm_data = filteration($_POST);

        if (!send_mail($frm_data['patient_email'], 'appointment_accepted', $frm_data['order_id'], $frm_data['date'], $frm_data['time'], $frm_data['phone_num'])) {
            echo 'mail_failed';
            exit;
        }

        $q1 = "UPDATE `appointment_order` SET `appointment_status`=? WHERE `id`=?";
        $values = ['Accepted',$frm_data['id']];

        $sched_q = "INSERT INTO `schedule_list` (`title`, `description`, `start_datetime`, `end_datetime`) VALUES (?,?,?,?)";
        $sched_v = [$frm_data['order_id'],'Appointment Accepted',$frm_data['date'],$frm_data['time']];
        $sched_r = insert($sched_q,$sched_v,'ssss');

        if(update($q1,$values,'si')){
            echo 1;
        }else{
            echo 0;
        }
    }

?>