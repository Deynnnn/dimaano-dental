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

?>