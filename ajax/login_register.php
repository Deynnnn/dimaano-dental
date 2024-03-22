<?php
    require ('../admin/includes/dbConfig.php');
    require ('../admin/includes/essentials.php');
    require ("../includes/Mail/phpmailer/PHPMailerAutoload.php");
    date_default_timezone_set("Asia/Manila");

    function sendMail($email, $token, $type, $name){
        if($type == 'email_confirmation'){
            $page = 'email_confirm.php';
            $subject = 'Dimaano Dental Clinic Appointment Schedule Account Verification Link';
            $content = 'Confirm your email';
        }else{
            $page = 'index.php';
            $subject = 'Dimaano Dental Clinic Appointment Schedule Account Recovery';
            $content = 'Recover your account';
        }


        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host='smtp_host';
        $mail->Port='smtp_port';
        $mail->SMTPAuth=true;
        $mail->SMTPSecure='tls';

        $mail->Username='smtp_username';
        $mail->Password='smtp_password';

        $mail->setFrom('smtp_username', 'Account Verification');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject= $subject;
        $mail->Body="<div id='wrapper' style='
        background-color: #f0f6fb; 
        font-family: 'Roboto', sans-serif; font-size: 19px;
        max-width: 800px;
        margin: 0 auto;
        padding: 3%;'>
    
            <header
            style='
            width: 98%;
            display: flex;
            align-items: center;
            justify-content: center;
            '
            >
                <div id='logo'>
                    <img
                        src='../images/logo.png'
                        width='100'
                        style='max-width: 100%'
                        alt=''
                    />
                </div>
                <div>
                    <h1>Dimaano Dental Clininc</h1>
                    <p id='contact' style='
                    text-align: center;
                    padding-bottom: 3%;
                    line-height: 16px;
                    font-size: 12px;
                    color: #303840;
                    '>
                        Poblaction 2 
                        Victoria 
                        5205, Oriental Mindoro 
                        dimaanoDental@gmail.com
                    </p>
                </div>
            </header>
            <hr style='height: 1px;
            background-color: #303840;
            clear: both;
            width: 96%;
            margin: auto;'/>
    
            <div style='padding: 15px;'>
                <p><b>Dear $name,</b></p>
                <div style='background-color: rgb(165,16,18); color: white; border-radius: 25px;'>
                    <h1 style='text-align: center;'>Click the link to $content:</h1>
                </div> 
                <p style='text-align: center;'>Thank you for making account in our website now you can $content and be able to make appointment schedule our dental services</p>
                <center>
                    <a href='" . SITE_URL . "$page?$type&email=$email&token=$token'>Click Me</a>
                </center>
    

                <footer>
                <p style='
                    text-align: center;
                    padding-bottom: 3%;
                    line-height: 16px;
                    font-size: 12px;
                    color: #303840;
                    '>
                    <i>*This is an automatically generated email* DO NOT REPLY</i>
                </p>
                </footer>
            </div>
        </div>";

        if ($mail->send()) {
            return 1;
        } else {
            return 0;
        }
    }

    if (isset($_POST['register'])){
        $data = filteration($_POST);

        // Password checker
        if ($data['password'] != $data['cPassword']) {
            echo 'password_mismatch';
            exit;
        }

        // User checker {existing/not}
        $u_exist = select("SELECT * FROM `patients` WHERE `email`=? OR `conNum`=? LIMIT 1", [$data['email'], $data['conNum']], 'ss');

        if (mysqli_num_rows($u_exist) != 0) {
            $u_exist_fetch = mysqli_fetch_assoc($u_exist);
            echo ($u_exist_fetch['email'] == $data['email']) ? 'email_already' : 'phone_already';
            exit;
        }

        $name = $data['first_name']." ".$data['last_name'];
        // Send confirmation link to user's email
        $token = bin2hex(random_bytes(16));

        if (!sendMail($data['email'], $token, "email_confirmation", $name)) {
            echo 'mail_failed';
            exit;
        }

        $enc_pass = password_hash($data['password'], PASSWORD_BCRYPT);

        $query = "INSERT INTO `patients`(`first_name`, `last_name`, `email`, `address`, `conNum`, `dob`, `password`, `token`) VALUES (?,?,?,?,?,?,?,?)";
        $values = [$data['first_name'],$data['last_name'], $data['email'], $data['address'], $data['conNum'], $data['birthday'], $enc_pass, $token];

        if (insert($query, $values, 'ssssssss')) {
            echo 1;
        } else {
            echo 'ins_failed';
        }
    }

    if (isset($_POST['login'])){
        $data = filteration($_POST);

        // User checker {existing/not}
        $u_exist = select("SELECT * FROM `patients` WHERE `email`=? OR `conNum`=? LIMIT 1", [$data['email_phone'], $data['email_phone']], 'ss');

        if(mysqli_num_rows($u_exist) == 0) {
            echo 'inv_email_mob';
            exit;
        }else{
            $u_fetch = mysqli_fetch_assoc($u_exist);
            if($u_fetch['is_verified']==0){
                echo 'not_verfied';
            }else if($u_fetch['status']==0){
                echo 'inactive';
            }else{
            if(!password_verify($data['password'],$u_fetch['password'])){
                echo 'invalid_pass';
            }else{
                    session_start();
                    $_SESSION['login'] = true;
                    $_SESSION['uId'] = $u_fetch['id'];
                    $_SESSION['uFName'] = $u_fetch['first_name'];
                    $_SESSION['uLName'] = $u_fetch['last_name'];
                    $_SESSION['uPhone'] = $u_fetch['conNum'];
                    echo 1;
                }
            }
        }
    }
?>