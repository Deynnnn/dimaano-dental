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
        $mail->Host='host';
        $mail->Port='port';
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username='smtp_mail';
        $mail->Password='smtp_secret';

        $mail->setFrom('smtp_mail', $subject);
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
            'apikey' => 'Your API KEY', //Your API KEY
            'number' => $contact_number,
            'message' => "We want to notify you that your dental appointment on Dimaano Dental Clinic request has been accepted. Settle your payment visit our website for instructions. Manage appointment using your email and appointment number:  $ticket",
            'sendername' => 'SEMAPHORE'
        );
        curl_setopt( $ch, CURLOPT_URL,'semaphorelink' );
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

    function decline_mail($email, $type, $ticket, $date, $time, $contact_number){
        $type = 'decline_information';
        $page = 'index.php';
        $subject = 'Dimaano Dental Clinic - Appointment Declined';
        $content = 'Appointment Declined';

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host='host';
        $mail->Port='port';
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username='smtp_mail';
        $mail->Password='smtp_secret';

        $mail->setFrom('smtp_mail', $subject);
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
                <br><br>
                <p style='text-indent: 20px;'>We want to notify you that your dental appointment request, identified by ticket number <b>$ticket</b>, has been declined. However you can make anothet appointment, please click the button below:</p>
                <a href='" . SITE_URL . "$page' class='btn'
                style='
                float: right;
                margin: 0 2% 4% 0;
                background-color: rgba(75, 192, 192, 0.2);
                border: 1px solid rgb(75, 192, 192);
                color: rgb(75, 192, 192);
                text-decoration: none;
                font-weight: 600;
                padding: 8px 12px;
                border-radius: 8px;
                letter-spacing: 3px;
                '
                >Book Another</a>
    
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
                    <i>*This is an automatically generated email* DO NOT REPLY</i>
                </p>
                </footer>
            </div>
        </div>";

        $ch = curl_init();
        $parameters = array(
            'apikey' => 'semaphore_secret', //Your API KEY
            'number' => $contact_number,
            'message' => "'We want to notify you that your dental appointment request on Gabito Dental Clinic has been declined due to certain circumstances. Make another appointment at dentcast.000.pe' $ticket",
            'sendername' => 'SEMAPHORE'
        );
        curl_setopt( $ch, CURLOPT_URL,'semaphore_link' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        if ($mail->send()) {
            // echo $output;
            return 1;
        } else {
            return 0;
        }

        
    }

    if(isset($_POST['get_all_appointments']))
    {
        $frm_data = filteration($_POST);

        $query = "SELECT ao.*, ad.* FROM `appointment_order` ao INNER JOIN `appointment_details` ad ON ao.id = ad.appointment_id WHERE (ao.order_id LIKE ? OR ad.phone_num LIKE ? OR ad.patient_name LIKE ?) AND ao.appointment_status = 'New' ORDER BY ao.id ASC";

        $res = select($query, ["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"], 'sss');
        $i = 1;
        $data = "";
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
        while($row = mysqli_fetch_assoc($res)){
            $date = date("d-m-Y", strtotime($row['date']));
            $data .="
                <tr>
                    <td>$i</td>
                    <td>
                        <span class='badge' style='background-color: rgb(165,16,18);'>
                        Order ID: $row[order_id]
                        </span>
                        <br>
                        <b>Name:</b> $row[patient_name]
                        <br>
                        <b>Phone No:</b> $row[phone_num]
                    </td>
                    <td>
                        <b>Service:</b> $row[service_name]
                        <br>
                        <b>Price:</b>₱$row[price]
                        <br>
                    </td>
                    <td>
                        <b>Paid:</b> ₱$row[total_pay]
                        <br>
                        <b>Date:</b> $date
                    </td>
                    <td>
                    <button type='button' onclick= accept_appointment($row[id],'$row[patient_email]','$row[order_id]','$row[date]','$row[time]','$row[phone_num]') class='btn btn-success shadow-none btn-sm mb-2 mt-2'>
                        ACCEPT
                    </button>
                    <button type='button' onclick= cancel_appointment($row[id],'$row[patient_email]','$row[order_id]','$row[date]','$row[time]','$row[phone_num]') class='btn btn-danger shadow-none btn-sm mb-2 mt-2'>
                        CANCEL
                    </button>
                    <button type='button' onclick=reschedule_date($row[id]) class='btn btn-warning shadow-none btn-sm mb-2 mt-2
                        ' data-bs-toggle='modal' data-bs-target='#reschedule_date'>
                        RESCHEDULE
                    </button>
                    </td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST['get_appointment'])){
        $frm_data = filteration($_POST);
        $res1 = select("SELECT appointment_order.*, appointment_details.*
        FROM appointment_order
        JOIN appointment_details ON appointment_order.id = appointment_details.appointment_id
        WHERE appointment_order.id = ?
        ",[$frm_data['get_appointment']],'i');

        $appointmentData = mysqli_fetch_assoc($res1);

        $data = ["appointmentData" => $appointmentData];

        $data = json_encode($data);

        echo $data;
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

    if(isset($_POST['cancel_appointment'])){
        $frm_data = filteration($_POST);

        if (!decline_mail($frm_data['patient_email'], 'appointment_accepted', $frm_data['order_id'], $frm_data['date'], $frm_data['time'], $frm_data['phone_num'])) {
            echo 'mail_failed';
            exit;
        }

        $q1 = "UPDATE `appointment_order` SET `appointment_status`=? WHERE `id`=?";
        $values = ['Cancelled',$frm_data['id']];

        if(update($q1,$values,'si')){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST['reschedule_date'])){
        $frm_data = filteration($_POST);

        // if (!resched_mail($frm_data['patient_email'], 'appointment_resheduled', $frm_data['order_id'], $frm_data['reschedule_date'], $frm_data['reschedule_time'], $frm_data['phone_num'])) {
        //     echo 'mail_failed';
        //     exit;
        // }

        $q1 = "UPDATE `appointment_order` SET `date`=?, `time`=?, `appointment_status`=? WHERE `id`=?";
        $values = [$frm_data['reschedule_date'],$frm_data['reschedule_time'],'Pending',$frm_data['id']];

        if(update($q1,$values,'sssi')){
            echo 1;
        }else{
            echo 0;
        }
    }

?>