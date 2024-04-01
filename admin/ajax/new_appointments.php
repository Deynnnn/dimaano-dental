<?php
    require('../includes/essentials.php');
    require('../includes/dbConfig.php'); 
    adminLogin();

    if(isset($_POST['get_appointments']))
    {
        $frm_data = filteration($_POST);

        $query = "SELECT ao.*, ad.* FROM `appointment_order` ao INNER JOIN `appointment_details` ad ON ao.id = ad.appointment_id WHERE (ao.order_id LIKE ? OR ad.phone_num LIKE ? OR ad.patient_name LIKE ?) AND ao.appointment_status = 'Pending' ORDER BY ao.id ASC";

        $res = select($query, ["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%"], 'sss');
        $i = 1;
        $table_data = "";
        // $data = mysqli_fetch_assoc($res);
        if(mysqli_num_rows($res)==0){
            echo"<b>No Data Found</b>";
            exit;
        }
        // $status_bg ='';
        // if($data['booking_status'] == 'booked'){
        //     $status_bg = "bg-primary";
        // }else if($data['booking_status'] == 'pending payment'){
        //     $status_bg = "bg-warning";
        // }
        while($data = mysqli_fetch_assoc($res)){
            $date = date("d-m-Y", strtotime($data['created_at']));
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

        // if (!send_mail($frm_data['email'], 'appointment_accepted', $frm_data['appointment_ticket'], $frm_data['date'], $frm_data['time'], $frm_data['contact_number'])) {
        //     echo 'mail_failed';
        //     exit;
        // }

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