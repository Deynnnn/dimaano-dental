<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require('includes/links.php');?>
    <title>DentalPal - Services</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
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
            .site-title{
                color: rgb(165,16,18);
            }
        </style>
</head>
<body>
    <div>
        <?php require('includes/navbar.php');?>
    </div>
    <div class="container my-4">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12 mx-auto">
                <img class="d-block mx-auto mb-4 mt-4" width="250" src="images/logo.png" alt="">
                <center><span class="fs-1 fw-bold site-title">DentaCast</span>
                <h1 class="display-5 fw-bold text-body-emphasis">Your Dental Health, Our Priority</h1></center>
            </div>
            <div class="col-lg-6 col-md-10 col-sm-12">
                <form class="row g-3" method="post" id="appointment_form">
                    <div class="form-floating col-md-12 mb-1 ps-0">
                        <input type="text" name="name" class="form-control shadow-none" id="nameInput" placeholder="name@example.com" required>
                        <label for="nameInput">Fullname</label>
                    </div>
                    <div class="form-floating col-md-6 mb-1 ps-0">
                        <input type="text" name="age"class="form-control shadow-none" id="ageInput" placeholder="5" required>
                        <label for="ageInput">Age</label>
                    </div>
                    <div class="form-floating col-md-6 mb-1 ps-0">
                        <select class="form-select shadow-none" name="gender" aria-label="Default select example" id="genderInput" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                        <label for="genderInput">Gender</label>
                    </div>
                    <div class="form-floating col-md-12 mb-1 ps-0">
                        <input type="text" name="address" class="form-control shadow-none" id="addressInput" placeholder="5" required>
                        <label for="addressInput">Address</label>
                    </div>
                    <div class="form-floating col-md-12 mb-1 ps-0">
                        <input type="text" name="contact_number" class="form-control shadow-none" id="contactInput" placeholder="5" required>
                        <label for="contactInput">Contact Number</label>
                    </div>
                    <div class="form-floating col-md-12 mb-1 ps-0">
                        <input type="text" name="email" class="form-control shadow-none" id="emailInput" placeholder="5" required>
                        <label for="emailInput">Email</label>
                    </div>
                    <div class="col-md-6 mb-1 ps-0">
                        <label class="form-label ">Preferred Date*</label>
                        <input type="date" id="dateInput" class="form-control shadow-none" name="date" required>
                    </div>
                    <div class="col-md-6 mb-1 ps-0">
                        <label class="form-label">Preferred Time*</label>
                        <input type="time" class="form-control shadow-none" name="time" min="09:00" max="17:00" required>
                    </div>  
                    <div class="form-floating col-md-12 mb-1 ps-0">
                        <select class="form-select shadow-none" name="service" aria-label="Default select example" id="floatingInput" required>
                            <?php
                                // $ser_q = "SELECT `name` FROM `services` WHERE `removed`=0 AND `status`=1";
                                // $res = $con->query($ser_q); 

                                // if ($res->num_rows > 0) {
                                //     while ($row = $res->fetch_assoc()) {
                                //         echo '<option value="' . $row['name'] . '">' . $row['name'] . '</option>';
                                //     }
                                // }
                            ?>
                        </select>
                        <label for="floatingInput">Select Service</label>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LdomHIoAAAAACjHsnXIx0GvV4hIUVw8_rycZVPl"></div>
                    </div>
                    <button type="submit" class="btn btn-md fw-bold btn-primary" name="submit">Book Appointment</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Pop-up container -->
    <div id="popupContainer">
        <div id="closeButton" onclick="closePopup()"><i class="bi bi-x-circle-fill text-danger"></i></div>
        <h4 class="fw-bold"><img src="/images/logo.png" width="30" height="24" alt="">Dimaano Dental Clinic</h4>
        <p>No Operating Hours During Saturdays. Please select a weekday.</p>
    </div>
    <!-- Overlay -->
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