<?php

    require('../includes/essentials.php');
    require('../includes/dbConfig.php'); 
    adminLogin();

    if(isset($_POST['booking_analytics']))
    {
        $frm_data = filteration($_POST);

        $condition="";

        if($frm_data['period']==1){
            $condition = "WHERE created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        }else if($frm_data['period']==2) {
            $condition = "WHERE created_at BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
        }elseif($frm_data['period']==3){
            $condition = "WHERE created_at BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
        }

        $result = mysqli_fetch_assoc(mysqli_query($con, "SELECT 

                        COUNT(CASE WHEN appointment_status ='Accepted' THEN 1 END) AS `total_bookings`, 
                        SUM(CASE WHEN appointment_status ='Accepted' THEN `trans_amt` END) AS `total_amt`, 

                        COUNT(CASE WHEN appointment_status='Pending' THEN 1 END) AS `active_bookings`,
                        SUM(CASE WHEN appointment_status='Pending' THEN `trans_amt` END) AS `active_amt`,

                        COUNT(CASE WHEN appointment_status = 'Cancelled' AND refund = 1 THEN 1 END) AS `cancelled_bookings`, 
                        SUM(CASE WHEN appointment_status = 'Cancelled' AND refund = 1 THEN `trans_amt` END) AS `cancelled_amt` FROM `appointment_order` $condition"
                    ));

        $output = json_encode($result);

        echo $output;
    }

    if(isset($_POST['user_analytics']))
    {
        $frm_data = filteration($_POST);

        $condition="";

        if($frm_data['period']==1){
            $condition = "WHERE created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()";
        }else if($frm_data['period']==2) {
            $condition = "WHERE created_at BETWEEN NOW() - INTERVAL 90 DAY AND NOW()";
        }elseif($frm_data['period']==3){
            $condition = "WHERE created_at BETWEEN NOW() - INTERVAL 1 YEAR AND NOW()";
        }

        $total_reviews = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS `count` FROM `rating_review` $condition"));

        $total_queries = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(sr_no) AS `count` FROM `patient_queries` $condition"));

        $total_new_reg = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(id) AS `count` FROM `patients` $condition"));

        $output = ['total_queries' => $total_queries['count'],
            'total_reviews' => $total_reviews['count'],
            'total_new_reg' => $total_new_reg['count']
        ];

        $output = json_encode($output);

        echo $output;

    }

?>