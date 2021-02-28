<?php
$show_error = 'false';
if ($_SERVER['REQUEST_METHOD']=='POST'){

    include '_dbconnect.php';
    $email = $_POST['loginemail']; 
    // echo $email;
    $pass = $_POST['loginpassword'];
    // echo $pass;
    $sql = "SELECT * FROM `user` WHERE `user_email` = $email";
    $result = mysqli_query($conn, $sql);
	echo var_dump( $result);
    $num_rows = mysqli_num_rows($result);
    if($num_rows==1){
        $row = mysqli_fetch_assoc($result);
        $user_name = $row['user_name'];
        if(password_verify($pass, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['useremail'] = $email;
            $_SESSION['id'] = $row['srno'];
            $_SESSION['username'] = $user_name;
            $_SESSION['password'] = $pass;
            echo "Logined". $email;
            $show_error = 'false';
        }
        else{
            $show_error = 'true';
        }
        header("Location: /forum/index.php?error=". $show_error);
         
    }
}
// if ($_SERVER['REQUEST_METHOD']=='GET'){

//     // echo "success";



//     include '_dbconnect.php';
//     include '_handlesignup.php';

//     // $email = $_POST['loginemail'];
//     // $pass = $_POST['loginpassword'];
//     $sql = "SELECT * FROM `users` WHERE user_email=". $GLOBALS[`$user_email`];
//     $result = mysqli_query($conn, $sql);
//     $num_rows = mysqli_num_rows($result);
//     if($num_rows==1){
//         $row = mysqli_fetch_assoc($result);
//         $user_name = $row['user_name'];
//         if(password_verify($GLOBALS['$pass'], $row['user_pass'])){
//             session_start();
//             $_SESSION['loggedin'] = true;
//             $_SESSION['useremail'] = $GLOBALS['user_email'];
//             $_SESSION['id'] = $row['srno'];
//             $_SESSION['username'] = $user_name;
//             echo "Logined". $uder_email;
//             $show_error = 'false';
//         }
//         else{
//             $show_error = 'true';
//         }
//         header("Location: /forum/index.php?error=". $show_error);
         
//     }
// }
?>