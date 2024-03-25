<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('includes/links.php');?>
    <title>DentalPal - About Us</title>
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
        <img class="d-block mx-auto img-fluid mb-4 w-95"  src="images/banner.png" alt="">
        <span class="fs-1 fw-bold site-title">About Us</span>
        <h1 class="display-5 fw-bold text-body-emphasis mb-4">Gentle Care, Radiant Smiles</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead fw-bolder mb-4">Transforming Lives, One Smile at a Time: Your Journey to a Healthier, Happier You Starts Right Here.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
            </div>
        </div>
    </div>
    <!-- service offered section -->
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 ">
                    <form method="POST">
                        <h5>Send a Message</h5>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Name</label>
                            <input type="text" class="form-control shadow-none" name="name" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Email</label>
                            <input type="email" class="form-control shadow-none" name="email" required>
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Subject</label>
                            <input type="text" class="form-control shadow-none" name="subject" required >
                        </div>
                        <div class="mt-3">
                            <label class="form-label" style="font-weight: 500;">Message</label>
                            <textarea class="form-control shadow-none" rows="5" style="resize: none;" name="message" required></textarea>
                        </div>
                        <button type="submit" name="send" class="btn btn-outline-dark mt-4">SEND</button>
                    </form>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4">
                    <iframe class="w-100 rounded mb-4" height="320px" src="https://www.google.com/maps/embed?pb=!4v1708656065406!6m8!1m7!1slI1eJG2HM3K7FTCEuCnhfg!2m2!1d13.17490973774465!2d121.2788460721744!3f5.762094202870658!4f-2.539169865683263!5f0.7820865974627469" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <h5>Address</h5>
                    <a href="#" target="_blank" class="d-inline-block text-decoration-none text-dark">
                        <i class="bi bi-geo-alt-fill"></i> Poblacion 1 Victoria Oriental Mindoro
                    </a>

                    <h5 class="mt-4">Call us</h5>
                    <a href="tel: 09958829014" class="d-inline-block mb-2 text-decoration-none text-dark">
                        <i class="bi bi-telephone-fill"></i> 09958829014
                    </a>
                    <br>

                    <h5 class="mt-4">Email</h5>
                    <a href="mailto: dimaanoDental@gmail.com" class="d-inline-block mb-2 text-decoration-none text-dark"><i class="bi bi-envelope-fill"></i></a> dimaanoDental@gmail.com

                    <h5 class="mt-4">Follow us</h5>
                    <a href="https://www.facebook.com/dimaanodentalclinic" target="_blank" class="d-inline-block mb-3 text-dark fs-5 me-2 text-decoration-none">
                        <i class="bi bi-facebook me-1"></i> Facebook
                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['send'])){
            $frm = filteration($_POST);
            $q = "INSERT INTO `patient_queries` (`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
            $values = [$frm['name'],$frm['email'],$frm['subject'],$frm['message']];
            $res = insert($q,$values,'ssss');

            if($res == 1){
                alert('success', 'Mail sent!');
            }else{
                alert('error', 'Server Down! try again later.');
            }
        }
    ?>
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