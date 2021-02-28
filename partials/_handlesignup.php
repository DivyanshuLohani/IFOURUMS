<?php
$show_error = 'false';

if ($_SERVER['REQUEST_METHOD']=='POST'){

    include '_dbconnect.php';
    
    $user_name = $_POST['username'];
    $user_email = $_POST['signupemail'];
    $pass = $_POST['signuppassword'];
   
    $cpass = $_POST['signupcpassword'];

    $existsql = "SELECT * FROM `user` where `user_email` = '$user_email'";
    $result = mysqli_query($conn, $existsql);
    echo var_dump($result);
    $num_rows = mysqli_num_rows($result);
    if($num_rows>0){
        $show_error = "1";
        header('Location: /forum/index.php?error='.$show_error);
    }
    else{
        // echo "i am in else";
        if($pass == $cpass){
            // echo "ok";
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `user` (`user_email`, `user_name` ,`user_pass`, `timestamp`) VALUES (' $user_email', '$user_name' ,'$hash', CURRENT_TIMESTAMP)";
            // echo "ok";
            $result = mysqli_query($conn, $sql);
            // echo var_dump( $result);
            
            if($result){
                $show_alert = true;
                header ("Location:  /forum/index.php?signupsuccess=true");
                // header ("Location:  /forum/partials/_handlelogin.php");
                
            }
        }
        else{
            $show_error = "2";
            header('Location: /forum/index.php?error='.$show_error);
        }

        // header('Location: /forum/index.php?signupsuccess=false&error='.$show_error);
    }
    
}


?>