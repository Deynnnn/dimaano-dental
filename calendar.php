<?php
    require('admin/includes/dbConfig.php');
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('includes/links.php')?>
    <title>DentaKlyn - Calendar</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }
 
        html,
        body {
            height: 100%;
            width: 100%;
        }
 
        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }
        table, tbody, td, tfoot, th, thead, tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }
        .site-title{
            color: rgb(165,16,18);
        }
    </style>
</head>
 
<body class="bg-light">
    <div>
    <?php 
        require('includes/navbar.php');
    ?>  
    </div>
    <nav class="navbar navbar-expand-lg navbar-info bg-danger bg-gradient" id="topNavBar">
        <div class="container">
            <span class="fs-1 fw-bold text-light text-center mx-auto">Dimaano Dental Clinic</span>
        </div>
    </nav>
    <div class="container py-5" id="page-container">
        <div class="row">
            
            <div class="col-lg-4 col-md-12 mb-4">
                <img class="d-block mx-auto mb-4" width="250" src="images/logo.png" alt="">
                <center><span class="fs-1 fw-bold site-title">Dental Pal</span>
                <h1 class="display-5 fw-bold text-body-emphasis">Your Dental Health, Our Priority</h1></center>
            </div>
            <div class="col-lg-8 col-md-12">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->
 
<?php 
$schedules = $con->query("SELECT * FROM `schedule_list`");
$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $row['sdate'] = date("F d, Y",strtotime($row['start_datetime']));
    $row['edate'] = date("h:i A",strtotime($row['end_datetime']));
    $sched_res[$row['id']] = $row;
}
?>
<?php 
if(isset($con)) $con->close();
?>

</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="/scripts.js"></script>
<?php require('includes/footer.php');?>
</html>