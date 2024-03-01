<?php
    require ('../admin/includes/dbConfig.php');
    require ('../admin/includes/essentials.php');

    date_default_timezone_set("Asia/Manila");


    if(isset($_POST['info_form'])){
        $frm_data = filteration($_POST);
        session_start();

        $u_exist = select("SELECT * FROM `patients` WHERE `conNum`=? AND `id`!=? LIMIT 1", [$frm_data['conNum'],$_SESSION['uId']], "ss");

        if(mysqli_num_rows($u_exist)!=0) {
            echo 'phone_already';
            exit;
        }

        $query = "UPDATE `patients` SET `name`=?, `address`=?, `conNum`=?, `dob`=? WHERE `id`=?";
        $values = [$frm_data['name'],$frm_data['address'],$frm_data['conNum'],$frm_data['dob'],$_SESSION['uId']];
        
        if(update($query,$values,'sssss')){
            $_SESSION['uName'] = $frm_data['name'];
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST['pass_form'])){
        $frm_data = filteration($_POST);
        session_start();

        if($frm_data['new_pass']!=$frm_data['confirm_pass']){
            echo 'mismatch';
            exit;
        }

        $enc_pass = password_hash($frm_data['new_pass'], PASSWORD_BCRYPT);

        $query = "UPDATE `patients` SET `password`=? WHERE `id`=? LIMIT 1";

        $values = [$enc_pass, $_SESSION['uId']];

        if(update($query,$values,'ss')){
            echo 1;
        }else{
            echo 0;
        }
    }

?>