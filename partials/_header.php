<?php include '_dbconnect.php' ?>

<?php

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="#">IForums</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
    <li class="nav-item active">
      <a class="nav-link" href="index.php">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="about.php">About</a>
    </li>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Categories
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">';
      $sql = "SELECT * FROM `categories` LIMIT 3";
      $result = mysqli_query($conn, $sql);
      
      while($row = mysqli_fetch_assoc($result)){
        echo('
          <a class="dropdown-item" href="threadlists.php?cat_id='.$row['cat_id'].'">'. $row['cat_name'] .'</a>
          
           
        ');
      }
        
   
    echo '</li><li class="nav-item">
      <a class="nav-link" href="contact.php" tabindex="-1">Contact Us</a>
    </li>
  </ul>
  <form action="search.php" class="form-inline my-2 my-lg-0">
    <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="q">
    <button class="btn btn-primary my-2 my-sm-0 mr-2" type="submit">Search</button></form>';
    session_start();
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
      echo '
      <p class="text-light my-0"><a href="account.php" type="button" class="mb-2 mt-2 ml-0 btn btn-primary ml-2">'.$_SESSION['username'] .'</a></p>
      <a href="partials/_logout.php" type="button" class="mb-2 mt-2 ml-0 btn btn-outline-primary ml-2">Logout</a>';

    }
    else{
      echo '
      
      <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#loginmodal">Login</button>
    <button type="button" class="btn btn-outline-primary ml-2" data-toggle="modal" data-target="#signupmodal">Sign Up</button>';
    }
echo '
</div>
</nav>';
include "partials/_loginmodal.php";
include "partials/_signupmodal.php";

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] =="true"){
  echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
  <strong>Success!</strong> You have been successfully signedup
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
}
else{
if(isset($_GET['error']) && $_GET['error'] =="1"){
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
    <strong>Failed! </strong>Email Already Exists Try Logging in
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
// if(isset($_GET['error']) && $_GET['error'] =="false"){
//     echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
//     <strong>Success! </strong>You have been successfully Logged in
//     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
//       <span aria-hidden="true">&times;</span>
//     </button>
//   </div>';
//   }
if(isset($_GET['error']) && $_GET['error'] =="2"){
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
    <strong>Failed! </strong>Passworrds Dosen'."'".'t match Try Again 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
if(isset($_GET['error']) && $_GET['error'] =="true"){
    echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
    <strong>Login Failed! </strong>Invalid Credentials
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>';
  }
}


  
?>