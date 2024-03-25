<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('includes/links.php')?>
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <title>DentaKlyn - Calendar</title>
</head>
<body class="bg-light">
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
        .active{
            border-bottom: 3px solid rgb(164,15,17);
            transition: .15s;
        }
        .custom-alert{
            position: fixed;
            top: 25px;
            right: 25px;
        }
        .custom-bg{
            background-color:  rgb(165,16,18);
            border: 1px solid  rgb(165,16,18);
        }
        .custom-bg:hover{
            background-color:  rgb(165,16,18,.85);
            border: 1px solid  rgb(165,16,18)
        }
    </style>
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

<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
</script>
<script src="/scripts.js"></script>
<?php require('includes/footer.php');?>
<script>
    let register_form = document.getElementById('register-form');

    register_form.addEventListener('submit', (e)=>{
        e.preventDefault();

        let data = new FormData();

        data.append('first_name', register_form.elements['first_name'].value);
        data.append('last_name', register_form.elements['last_name'].value);
        data.append('email', register_form.elements['email'].value);
        data.append('conNum', register_form.elements['conNum'].value);
        data.append('address', register_form.elements['address'].value);
        data.append('birthday', register_form.elements['birthday'].value);
        data.append('password', register_form.elements['password'].value);
        data.append('cPassword', register_form.elements['cPassword'].value);
        data.append('register', '');
        
        var myModal = document.getElementById('registerModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function()
        {
            if(this.responseText == 'password_mismatch'){
                alert('error', "PASSWORD MISMATCH!");
            }else if(this.responseText == 'email_already'){
                alert('error', "email is already existing. USE ANOTHER EMAIL");
            }else if(this.responseText == 'phone_already'){
                alert('error', "Phone number is already been used by another user");
            }else if(this.responseText == 'mail_failed'){
                alert('error', "Cannot send email confirmation, Server Down!");
            }else if(this.responseText == 'ins_failed'){
                alert('error', "Registration Failed! Server Down!");
            }else{
                alert('success', "Registration Successful, Check your email to verify your account!");
                register_form.reset();
            }
        }
        xhr.send(data);
    });

    let login_form = document.getElementById('login-form');

    login_form.addEventListener('submit', (e) => {
        e.preventDefault();

        let data = new FormData();

        data.append('email_phone', login_form.elements['email_phone'].value);
        data.append('password', login_form.elements['password'].value);
        data.append('login', '');

        var myModal = document.getElementById('loginModal');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/login_register.php", true);

        xhr.onload = function () {
            if(this.responseText == 'inv_email_mob'){
                alert('error','Invalid Email, Try again!');
            }else if(this.responseText =='not_verfied'){
                alert('error','Email not verified, check your mail to verify!');
            }else if(this.responseText == 'inactive'){
                alert('error','Account suspended! Contact Admin.');
            }else if(this.responseText == 'invalid_pass'){
                alert('error','Incorrect Password, try again!');
            }else{
                let fileUrl = window.location.href.split('/').pop().split('?').shift();
                if(fileUrl == 'room_details.php'){
                    window.location = window.location.href;
                }else{
                    window.location = window.location.pathname;
                }
                window.location = window.location.href;
            }
        }
        xhr.send(data);
    });
</script>
</body>
</html>