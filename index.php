<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/custom.css">
    <?php require('includes/links.php');?>
    <title>DentalPal</title>
</head>
<body>
    <style>
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
        <?php require('includes/navbar.php');?>
    </div>
    <!-- hero section -->
    <div class="px-4 py-5 text-center">
        <img class="d-block mx-auto mb-4" src="images/logo.png" width="250px" alt="">
        <span class="fs-1 fw-bold site-title">DentalPal</span>
        <h1 class="display-5 fw-bold text-body-emphasis">Your Brighter, Healthier Smile Awaits</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">Discover a Dental Experience Unlike Any Other, Where Compassion, Expertise, and Innovation Combine to Give You the Smile of Your Dreams.</p>
        </div>
    </div>

    <!-- service offered section -->
    <div class="container px-4 py-5" id="custom-cards service">
        <h2 class="pb-2 border-bottom">Dental Services</h2>
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
            <?php
                $service_res = select("SELECT * FROM `services` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3",[1,0],'ii');

                while($service_data = mysqli_fetch_assoc($service_res)){

                    // get service thumbnail
                    $service_thumb = SERVICES_IMG_PATH."banner.png";
                    $thumb_q = mysqli_query($con,"SELECT * FROM `service_images` 
                        WHERE `service_id`='$service_data[id]' 
                        AND `thumb`='1'");
                    if(mysqli_num_rows($thumb_q)>0){
                        $thumb_res = mysqli_fetch_assoc($thumb_q);
                        $service_thumb = SERVICES_IMG_PATH.$thumb_res['image'];
                    }
                    $book_btn = '';

                    if(!$setting_r['shutdown']){
                        $login=0;
                        if(isset($_SESSION['login']) && $_SESSION['login']==true){
                            $login=1;
                        }
                        $book_btn = "<button onclick='checkLoginToBook($login,$service_data[id])' class='btn btn-sm text-white custom-bg shadow-none'>Schedule Appointment Now</button>";
                    }

                    $rating_q = "SELECT AVG(rating) AS `avg_rating` FROM `rating_review` WHERE `service_id`='$service_data[id]' ORDER BY `id` DESC LIMIT 20";
                    $rating_res = mysqli_query($con,$rating_q);
                    $rating_fetch =mysqli_fetch_assoc($rating_res);

                    $rating_data = "";

                    if($rating_fetch['avg_rating']!= NULL){
                        $rating_data = "<div class='rating mb-4'>
                                            <span class='badge rounded-pill bg-light'>
                                        ";
    
                        for($i=0;  $i < $rating_fetch['avg_rating']; $i++){
                            $rating_data .= "<i class='bi bi-star-fill text-warning'></i> ";
                        }
    
                        $rating_data .= "</span>
                                        </div>";
                    }else{
                        $rating_data ="<div class='rating mb-4'>
                                            <span class='badge rounded-pill bg-dark'>NO RATINGS YET!</span>
                                        </div>";
                    }

                    $description = $service_data['description'];
                    $maxLength = 200;
                    $truncatedData = substr($description, 0, $maxLength);



                    echo<<<serdata
                    <div class="container">
                        <div class="row">
                            <div class="card col-lg-4 col-md-6 col-sm-12 mb-3" style="width: 25rem;">
                                <img src="$service_thumb" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <div class="d-flex align-content-center justify-content-between mb-2">
                                        <h3 class="display-6 lh-1 fw-bold">$service_data[name]</h3>
                                        <h6 class="mb-4 fw-medium">₱$service_data[price]</h6>
                                    </div>
                                    <p class="card-text">$truncatedData...</p>
                                    $rating_data
                                    <hr class="text-light-sm">
                                    <div class="d-flex justify-content-between mb-2">
                                        <a href="service_details.php?id=$service_data[id]" class="btn btn-sm btn-outline-dark shadow-none ">More details</a>
                                        $book_btn
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    serdata;
                }
            
            ?>
        </div>
        <div class="d-flex justify-content-center align-content-center">
            <a href="services.php" class="btn btn-sm btn-outline-dark shadow-none ">See More...</a>
        </div>
    </div>

    <!-- location offered section -->
    <div class="container px-4 py-5" id="custom-cards">
        <h2 class="pb-2 border-bottom">Location</h2>
        <div class="row row-cols-1 row-cols-lg-3 align-items-stretch g-4 py-5">
            <iframe class="w-100 rounded" src="https://www.google.com/maps/embed?pb=!4v1708656065406!6m8!1m7!1slI1eJG2HM3K7FTCEuCnhfg!2m2!1d13.17490973774465!2d121.2788460721744!3f5.762094202870658!4f-2.539169865683263!5f0.7820865974627469" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
    <!-- <script src="js/login_register.js"></script> -->
</body>
</html>