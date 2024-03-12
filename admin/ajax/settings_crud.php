<?php

    require('../includes/essentials.php');
    require('../includes/dbConfig.php'); 
    adminLogin();

    if(isset($_POST['get_general']))
    {
        $q = "SELECT * FROM `settings` WHERE `id`=?";
        $values = [1];
        $res = select($q, $values, "i");
        $data = mysqli_fetch_assoc($res);
        $json_data = json_encode($data);
        echo $json_data;
    }

    if(isset($_POST['upd_shutdown']))
    {
        $frm_data = ($_POST['upd_shutdown']==0)? 1 : 0;

        $q = "UPDATE `settings` SET `shutdown`=? WHERE `id`=?";
        $values = [$frm_data,1];
        $res = update($q,$values,'ii');
        echo $res;
    }

    if(isset($_POST['pass_form'])){
        $frm_data = filteration($_POST);
        session_start();

        if($frm_data['new_pass']!=$frm_data['confirm_pass']){
            echo 'mismatch';
            exit;
        }

        $enc_pass = password_hash($frm_data['new_pass'], PASSWORD_BCRYPT);

        $query = "UPDATE `admin` SET `password`=? WHERE `id`=? LIMIT 1";

        $values = [$enc_pass, $_SESSION['adminId']];

        if(update($query,$values,'ss')){
            echo 1;
        }else{
            echo 0;
        }
    }

?>