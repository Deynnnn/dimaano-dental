<?php

    require('../includes/essentials.php');
    require('../includes/dbConfig.php'); 
    adminLogin();

    if(isset($_POST['get_users'])){
        $res = selectAll('patients');
        $i=1;

        $data="";

        while($row = mysqli_fetch_assoc($res)){

            $del_btn = "
            <button type='button' onclick='remove_user($row[id])' class='btn btn-outline-secondary shadow-none btn-sm border-0'>
                <i class='bi bi-eye fs-5'></i>
            </button>";

            $verified = "<p style='font-size: 25px;'><i class='bi bi-x-circle-fill text-danger'></i></p>";
            
            if($row['is_verified']){
                $verified = "<p style='font-size: 25px;'><i class='bi bi-patch-check-fill text-primary'></i></p>";
            }

            $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-warning btn-sm shadow-none'>active</button>";

            if(!$row['status']){
                $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>inactive</button>";

            }

            $date = date("m-d-Y",strtotime($row['created_at']));

            $data.="
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>
                    $row[first_name] $row[last_name]
                    </td>
                    <td>$row[email]</td>
                    <td>$row[conNum]</td>
                    <td>$row[address]</td>
                    <td>$row[dob]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }

    if(isset($_POST['toggle_status'])){
        $frm_data = filteration($_POST);

        $q = "UPDATE `patients` SET `status`=? WHERE `id`=?";
        $v = [$frm_data['value'],$frm_data['toggle_status']];

        if(update($q,$v,'ii')){
            echo 1;
        }else{
            echo 0;
        }
    }

    if(isset($_POST['remove_user'])){
        $frm_data = filteration($_POST);

        $res = delete("DELETE FROM `patients` WHERE `id`=? AND `is_verified`=?",[$frm_data['user_id'],0],'ii');

        if($res){
            echo 1;
        }else{
            echo 0;
        }

    }

    if(isset($_POST['search_user'])){

        $frm_data = filteration($_POST);

        $query = "SELECT * FROM `patients` WHERE `first_name` LIKE ? OR `last_name` LIKE ?";
        $res = select($query,["%$frm_data[name]%", "%$frm_data[name]%"],'ss');
        $i=1;

        $data="";

        while($row = mysqli_fetch_assoc($res)){

            $del_btn = "
            <button type='button' onclick='remove_user($row[id])' class='btn btn-outline-secondary shadow-none btn-sm'>
                <i class='bi bi-eye'></i>
            </button>";

            $verified = "<p style='font-size: 25px;'><i class='bi bi-x-circle-fill text-danger'></i></p>";
            
            if($row['is_verified']){
                $verified = "<p style='font-size: 25px;'><i class='bi bi-patch-check-fill text-primary'></i></p>";
            }

            $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-warning btn-sm shadow-none'>active</button>";

            if(!$row['status']){
                $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-danger btn-sm shadow-none'>inactive</button>";

            }

            $date = date("m-d-Y",strtotime($row['created_at']));

            $data.="
                <tr class='align-middle'>
                    <td>$i</td>
                    <td>
                    $row[first_name] $row[last_name]
                    </td>
                    <td>$row[email]</td>
                    <td>$row[conNum]</td>
                    <td>$row[address]</td>
                    <td>$row[dob]</td>
                    <td>$verified</td>
                    <td>$status</td>
                    <td>$date</td>
                    <td>$del_btn</td>
                </tr>
            ";
            $i++;
        }
        echo $data;
    }
?>