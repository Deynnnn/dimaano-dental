<nav  id="nav-bar" class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="index.php"> <img src="images/logo.jpg" width="50" height="50" alt=""> DentalPal</a>
        <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link hov" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link hov" href="calendar.php">Calendar</a>
                </li>
                <li class="nav-item">
                <a class="nav-link hov" href="about.php">About Us</a>
                </li>
                <li class="nav-item">
                <a class="nav-link hov" href="services.php">Services</a>
                </li>
                <!-- <li class="nav-item">
                <a class="nav-link hov" href="book_appointment.php">Book an Appointment</a>
                </li> -->
            </ul>
            <div class="d-flex">
                <?php
                    if(isset($_SESSION['login']) && $_SESSION['login']==true){
                        echo<<<data
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-dark shadow_none dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                                    <i class="bi bi-person-badge-fill fs-5"></i>
                                    $_SESSION[uFName] $_SESSION[uLName]
                                </button>
                                <ul class="dropdown-menu dropdown-menu-lg-end">
                                    <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                                    <li><a class="dropdown-item" href="appointments.php">Appointments</a></li>
                                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                                </ul>
                            </div>
                        data;
                    }else{
                        echo<<<data
                            <button type="button" class="btn btn-outline-dark shadow-none me-lg-3 me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                                Login
                            </button>
                            <button type="button" class="btn btn-outline-dark shadow-none" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Register
                            </button>
                        data;
                    }
                ?>
            </div>
        </div>
    </div>
</nav>

<!--LOGIN FORM MODAL-->
<div class="modal fade" id="loginModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="login-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-circle fs-3 me-2"></i>User Login
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                    <div class="mb-3">
                        <label class="form-label">Email / Phone</label>
                        <input type="text" name="email_phone" required class="form-control shadow-none" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control shadow-none" >
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <button class="btn btn-dark shadow-none px-4 mb-2">LOGIN </button>
                        <button type="button" class="btn text-secondary text-decoration-none mb-2 shadow-none p-0" data-bs-target="#forgotModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                        Forgot Pasword?
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--forgot pass modal-->
<div class="modal fade" id="forgotModal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="forgot-form">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalToggleLabel2">
                        <i claa="bi bi-person-circle fs-3 me-2"></i> Forgot Password
                    </h5>
                </div>
                <div class="modal-body">
                    <span class="badge bg-light text-dark mb-3 text-wrap lh-base">
                        Note: A link will be sent to your email to reset your password.
                    </span>
                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" required class="form-control shadow-none">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="mb-2 text-end">
                        <button type="button" class="btn me-2 shadow-none" data-bs-target="#loginModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                            CANCEL
                        </button>
                        <button class="btn btn-dark shadow-none px-4 mb-2">SEND LINK</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--REGISTRATION FORM MODAL-->
<div class="modal fade" id="registerModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="register-form">
                <div class="modal-header">
                    <h5 class="modal-title d-flex align-items-center">
                        <i class="bi bi-person-add fs-3 me-2"></i>Patient Registration
                    </h5>
                    <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 col-sm-12 form-floating mb-3 ps-0">
                                <input type="text" name="first_name" class="form-control shadow-none" id="fnameInput" placeholder="name@example.com" required>
                                <label for="fnameInput">First Name</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-floating mb-3 ps-0">
                                <input type="text" name="last_name" class="form-control shadow-none" id="lnameInput" placeholder="name@example.com" required>
                                <label for="lnameInput">Last Name</label>
                            </div>
                            <div class="mb-3 form-floating col-md-12 ps-0"> 
                                <input type="email" name="email" class="form-control shadow-none" id="emailInput" placeholder="name@example.com" required>
                                <label for="emailInput">Email</label>
                            </div>
                            <div class="col-md-12 form-floating mb-3 ps-0">
                                <textarea name="address" class="form-control shadow-none" id="addressInput" placeholder="name@example.com" required></textarea>
                                <label for="addressInput">Address</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-floating mb-3 ps-0">
                                <input type="number" name="conNum" class="form-control shadow-none" id="conNumInput" placeholder="name@example.com" required>
                                <label for="conNumInput">Contact Number</label>
                            </div>
                            <div class="col-md-6 col-sm-12 form-floating mb-3 ps-0">
                                <input type="date" name="birthday" class="form-control shadow-none" id="dobInput" placeholder="name@example.com" required>
                                <label for="dobInput">Date of Birth</label>
                            </div>
                            <div class="mb-3 form-floating col-md-6 col-sm-12 ps-0"> 
                                <input type="password" name="password" class="form-control shadow-none" id="passwordInput" placeholder="password" required>
                                <label for="passwordInput">Create Password</label>
                            </div>
                            <div class="mb-3 form-floating col-md-6 col-sm-12 ps-0"> 
                                <input type="password" name="cPassword" class="form-control shadow-none" id="cpasswordInput" placeholder="password" required>
                                <label for="cpasswordInput">Confirm Password</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input shadow-none" type="checkbox" value="remember-me" id="flexCheckDefault" required>
                                <label class="form-check-label" for="flexCheckDefault">
                                    I Agree to <a class="text-decoration-none fw-medium" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dataprivacyModal">Data Privacy Policy</a>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn custom-bg shadow-none text-light fw-medium">REGISTER</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Data Privacy Modal -->
<div class="modal fade" id="dataprivacyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="bi bi-shield-lock-fill"></i> Data Privacy Policy</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="">In compliance with the <b>Data Privacy Act (DPA) of 2012</b>, and its <b>Implementing Rules and Regulations (IRR)</b> effective since September 8, 2016, I allow The Dimaano Dental Clinic to use the data I provided in this form for the processing of my appointment scheduling in the Clinic and other reports needed by the clinic in relation to its appointment and scheduling processes. Additionally, I give my consent and allow Dimaano Dental Clinic to share my information to the other clinic stakeholders.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#registerModal">Close</button>
      </div>
    </div>
  </div>
</div>