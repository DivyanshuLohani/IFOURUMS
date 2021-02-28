<!doctype html>
<html lang="en">

<head>
    <title>IForums - Coding Forums</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
    #maincontainer {
        min-height: 90vh;
    }
    </style>
</head>

<body>
    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <?php 
        $method = $_SERVER['REQUEST_METHOD'];
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
            if($method == 'POST'){
                if(isset($_POST['username'])){
                $username = $_POST['username'];
                $sql = "UPDATE `users` SET `user_name` = '$username' WHERE `users`.`srno` = ".$_SESSION['id'].";";
                $_SESSION['username'] = $username; 
                $result = mysqli_query($conn, $sql);
                $showalert = TRUE;
                if($showalert){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong>Your username is successfully changed now you can refresh the page
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                }
                }
                if(isset($_POST['email'])){
                $email = $_POST['email'];
                $sql = "UPDATE `users` SET `user_email` = '$email' WHERE `users`.`srno` = ".$_SESSION['id'].";";
                $_SESSION['useremail'] = $email; 
                $result = mysqli_query($conn, $sql);
                $showalert = TRUE;
                if($showalert){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong>Your Email is successfully changed now you can refresh the page
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                }
                }
                if(isset($_POST['password'])){
                $password = $_POST['password'];
                $newpass=$_POST['new_pass'];
                $useremail = $_SESSION['useremail'] ;
                $sql = "SELECT * FROM `users` WHERE user_email='$useremail'";
                $result = mysqli_query($conn, $sql);
               
                $row = mysqli_fetch_assoc($result);
                if(password_verify($password, $row['user_pass'])){
                    $hash = password_hash($newpass, PASSWORD_DEFAULT);
                    $sql = "UPDATE `users` SET `user_pass` = '$hash' WHERE `users`.`srno` = ".$_SESSION['id'].";";
                    $result = mysqli_query($conn, $sql);
                    $showalert = TRUE;
                    if($showalert){
                        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success! </strong>Your password has been Changed
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
                    }
                }
                
                else{
                    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Failed! </strong>Your password cannot be changed try again
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>';
                }
           }
        }
    }




    ?>
    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
    echo ' 
    <div id="maincontainer">
        <div class="container my-4">
            <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp"
                        value="'.$_SESSION['username'] .'">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <hr class="font-weight-bold">
            <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                        value="'.$_SESSION['useremail'].'">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <hr>
            <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
                <div class="form-group">
                    <label for="exampleInputPassword1">Current Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password" class="form-control" id="new_pass" name="new_pass">
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>';}
        else{
            echo '
                <div id="maincontainer">
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">You Are Not Logged IN &#128542;</p>
                            <hr>
                            <p class="lead"> &#128515;   You need to  <b><strong><a type="button"data-toggle="modal" data-target="#loginmodal" class="text-primary">Login</a></strong></b> to be able to See this page</p>
                        </div>
                    </div>
                </div>';
            
        }

    ?>
    <?php include 'partials/_footer.php' ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    
</body>

</html>