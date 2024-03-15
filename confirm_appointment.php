<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('includes/links.php');?>
    <title>DentalPal - Services</title>
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
        /* Styling for the pop-up container */
        #popupContainer {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            opacity: 0; /* Initial opacity set to 0 for the fade-in effect */
            transition: opacity 0.5s ease-in-out; /* CSS transition for opacity */
        }

        /* Styling for the overlay */
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Styling for the close button */
        #closeButton {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>
    <div>
        <?php require('includes/navbar.php');?>
    </div>
    <?php
         /*
        CHECK SERVICE ID FROM URL IS PRESENT OR NOT
        SHUT DOWN MODE IS ACTIVE OR NOT
        USER IS LOG IN OR NOT
        */

        if(!isset($_GET['id']) || $setting_r['shutdown']==true){
            redirect('services.php');
        }else if(!(isset($_SESSION['login']) && $_SESSION['login']==true)){
            redirect('services.php');
        }
        
        //fiter and user get service and patient data
        $data = filteration($_GET);

        $room_res = select("SELECT * FROM `services` where `id`=? and `status`=? and `removed`=?",[$data['id'],1,0],'iii');

        if(mysqli_num_rows($room_res)==0){
            redirect('services.php');
        }

        $room_data = mysqli_fetch_assoc($room_res);

        $_SESSION['service'] = [
            "id" => $room_data['id'],
            "name" => $room_data['name'],
            "price" => $room_data['price'],
            "payment" => null,
            "available" => false,
        ];

        $user_res =select("SELECT * FROM `patients` WHERE `id`=? LIMIT 1", [$_SESSION['uId']], 'i');
        $user_data = mysqli_fetch_assoc($user_res);

    ?>

    
<div class="container">
    <div class="row"> 
        <div class="col-12 my-5 mb-4 px-4">
            <h2 class="fw-bold">CONFIRM APPOINTMENT</h2>

            <div style="font-size: 14px;">
                <a href="rooms.php" class="text-decoration-none text-secondary">
                    <i class="bi bi-arrow-left"></i> GO BACK >
                </a>
                <a href="#" class="text-decoration-none text-secondary">
                    CONFIRM
                </a>
            </div>
        </div>
        <div class="col-lg-7 col-md-12 px-4">
            <?php
                $room_thumb = SERVICES_IMG_PATH."banner.png";
                $thumb_q = mysqli_query($con,"SELECT * FROM `service_images` 
                    WHERE `service_id`='$room_data[id]' 
                    AND `thumb`='1'");
                if(mysqli_num_rows($thumb_q)>0){
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = SERVICES_IMG_PATH.$thumb_res['image'];
                }

                echo<<<data
                    <div class="card p-3 shadow-sm rounded">
                        <img src="$room_thumb" class="img-fluid rounded mb-3">
                        <h5>$room_data[name]</h5>
                        <h6>₱ $room_data[price]</h6>
                    </div>
                data;
            ?>
        </div>

        <div class="col-lg-5 col-md-12 px-4">
            <div class="card mb-4 border-0 shadow-sm rounded-3">
                <div class="card-body">
                    <form action="pay_now.php" id="booking_form" method="POST">
                        <h6>APPOINTMENT DETAILS</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Name</label>
                                <input type="text" value="<?php echo $user_data['name']?>" name="name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Phone Number</label>
                                <input type="number" name="phonenum" value="<?php echo $user_data['conNum']?>" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-medium">Address</label>
                                <textarea name="address" class="form-control shadow-none" rows="1" required><?php echo $user_data['address']?></textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="" class="form-label fw-medium">Email</label>
                                <input type="text" value="<?php echo $user_data['email']?>" name="email" class="form-control shadow-none" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Preferred Date*</label>
                                <input type="date" id="dateInput" class="form-control shadow-none" name="date" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-medium">Preferred Time*</label>
                                <input type="time" class="form-control shadow-none" name="time" min="08:00" max="19:00" required>   
                            </div>
                            <div class="col-12">
                                <input type="hidden" name="amount" value="<?php echo $room_data['price']?>" readonly>
                                <input class="btn w-100 text-white custom-bg shadow-none mb-2" type="submit" name="submit" value="Set Appointment">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pop-up container -->
<div id="popupContainer">
    <div id="closeButton" onclick="closePopup()"><i class="bi bi-x-circle-fill text-danger"></i></div>
    <h4 class="fw-bold"><img src="/images/logo.png" width="30" height="24" alt="">Dimaano Dental Clinic</h4>
    <p>No Operating Hours During Saturdays. Please select a weekday.</p>
</div>
<div id="overlay"></div>

<?php require('includes/footer.php');?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the date input element
        var dateInput = document.getElementById('dateInput');

        // Add an event listener to the input element
        dateInput.addEventListener('input', function () {
            // Get the selected date
            var selectedDate = new Date(this.value);

            // Check if the selected day is a Saturday (6)
            if (selectedDate.getDay() === 6) {
                // If it's a Saturday, reset the input value to an empty string
                this.value = '';
                showPopup();
            }
        });
    });
    function showPopup() {
        document.getElementById('popupContainer').style.display = 'block';

        // Triggering reflow to restart the animation
        void document.getElementById('popupContainer').offsetWidth;

        document.getElementById('popupContainer').style.opacity = 1;
        document.getElementById('overlay').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popupContainer').style.opacity = 0;
        document.getElementById('overlay').style.display = 'none';

        // Delay hiding the pop-up to allow the fade-out animation to complete
        setTimeout(function () {
            document.getElementById('popupContainer').style.display = 'none';
        }, 500);
    }
    // Get the current date
    const today = new Date();
    
    // Format it to YYYY-MM-DD for the input's min attribute
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const formattedDate = `${year}-${month}-${day}`;
    
    // Set the min attribute of the input element to today's date
    document.getElementById('dateInput').min = formattedDate;
</script>
</body>
</html>