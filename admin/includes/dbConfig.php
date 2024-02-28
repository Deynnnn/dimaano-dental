<?php
    $hostName ='localhost';
    $userName = 'root';
    $password = '';
    $dataBase ='dimaanoDental';

    $con = mysqli_connect($hostName,$userName,$password,$dataBase);

    if(!$con){
        die('Cannot Access Database'.mysqli_connect);
    }

    function filteration($data){
        foreach($data as $key => $value){
            $value=trim($value);
            $value=stripcslashes($value);
            $value=htmlspecialchars($value);
            $value=strip_tags($value);
            $data[$key] = $value;
        }
        return $data;
    }

    function selectAll($table){
        $con = $GLOBALS['con'];
        $res = mysqli_query($con, "SELECT * FROM $table");
        return $res;
    }

    function select($sql, $values, $datatypes){
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql))
        {
            mysqli_stmt_bind_param($stmt, $datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
            mysqli_smtm_close($stmt);
            die('Query cannot be executed - Select');
            }
        }
        else{
            die('Query cannot be executed - Select');
        }
    }

    function update($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql))
        {
            mysqli_stmt_bind_param($stmt, $datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Update");
            }
        }
        else{
            die("Query cannot be executed - Update");
        }
    }

    function insert($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql))
        {
            mysqli_stmt_bind_param($stmt, $datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Insert");
            }
        }
        else{
            die("Query cannot be executed - Insert");
        }
    }

    function delete($sql, $values, $datatypes)
    {
        $con = $GLOBALS['con'];
        if($stmt = mysqli_prepare($con, $sql))
        {
            mysqli_stmt_bind_param($stmt, $datatypes,...$values);
            if(mysqli_stmt_execute($stmt)){
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else{
            mysqli_stmt_close($stmt);
            die("Query cannot be executed - Delete");
            }
        }
        else{
            die("Query cannot be executed - Delete");
        }
    }
?>