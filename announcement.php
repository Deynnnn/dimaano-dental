<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('includes/links.php');?>
    <title>DentalPal - Announcement</title>
</head>
<body>
    <style>
        .site-title{
            color: rgb(165,16,18);
        }
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
            z-index: 11;
        }
        .active{
            border-bottom: 3px solid rgb(164,15,17);
            transition: .15s;
        }
    </style>
    <div>
        <?php require('includes/navbar.php');?>
    </div>
    <div class="my-5 text-center">
        <span class="fs-1 fw-bold site-title">Announcements</span>
        <h1 class="display-5 fw-bold text-body-emphasis mb-4">Gentle Care, Radiant Smiles</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead fw-bolder mb-4">Transforming Lives, One Smile at a Time: Your Journey to a Healthier, Happier You Starts Right Here.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            </div>
        </div>
    </div>
    <div class="container">
        <h2 class="pb-2 border-bottom"></h2>
        
        <div class="row">

        <?php
            $q = "SELECT * FROM announcements WHERE removed = 0 ORDER BY id DESC";
            $data = mysqli_query($con, $q);
            $i=1;
            while($row = mysqli_fetch_assoc($data)){
                echo<<<announcement
                    <div class="card col-lg-4 col-md-6 col-sm-12 mb-3 me-2" style="width: 25rem;">
                        <div class="card-body">
                            <div class="d-flex align-content-center justify-content-between mb-2">
                                <h3 class="display-6 lh-1 fw-bold">$row[title]</h3>
                            </div>
                                <hr class="text-light-sm">
                            <div>
                                <p class="card-text">$row[description]</p>
                            </div>
                        </div>
                    </div>
                announcement;
            }
        ?>
        
        </div>
    </div>
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