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
</head>

<body>
    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>
    <?php
        $id = $_GET['thread-id'];
        $sql = "SELECT * FROM `threads` WHERE `thread_id`=$id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $title = $row['thread_title'];
            $thread_user_id = $row['thread_user_id'];
            $desc = $row['thread_desc'];
        }; 
    ?>
    <div class="container my-2">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo($desc) ?></p>
            <hr class="my-4">
            <!-- <p>This forum is to share knowledge with each other</p>-->
            <p>Posted By: <b><?php 
                $sql = "SELECT * FROM `users` where `srno` = $thread_user_id";
                $result = mysqli_query($conn, $sql);
                $num_rows = mysqli_num_rows($result);
                $row = mysqli_fetch_assoc($result);
                $user_name = $row['user_name'];
                echo $user_name;
            
            
            ?></b></p>
        </div>
    </div>

    <div class="container">
        <?php 
             $showalert = false;
             $method = $_SERVER['REQUEST_METHOD'];
             if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
             if($method == 'POST'){
                 $comment = $_POST['comment']; 
                 $comment = str_replace(">", "&lt", $comment);
                 $comment = str_replace("<", "&gt", $comment);
                 $user_id = $_SESSION['id'];
                 $sql = "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ('$comment', '$id', CURRENT_TIMESTAMP, '$user_id');";
                 $result = mysqli_query($conn, $sql);
                 $showalert = true;
                 if ($showalert){
                     echo '
                     <div class="alert alert-success alert-dismissible fade show" role="alert">
                     <strong>Success! </strong> Your comment Has Been Successfully added
                     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                     </button>
                   </div>
                     ';
                 }
             }}
        ?>
       <?php
            
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                echo ' <h1>Post A Comment</h1>
                <form action="'.  $_SERVER['REQUEST_URI'] .'" method="POST">
                    
                    <div class="form-group">
                        <label for="exampleInputPassword1">Type Your Comment here</label>
        
                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
        
                    </div>
                   
                    <button type="submit" class="btn btn-primary">Post Comment</button>
                </form>';
            }
            else{
                echo '<h3><span class="badge badge-dark">You Need To <a type="button"data-toggle="modal" data-target="#loginmodal" class="text-primary">Login</a> To be able to post a comment</span></h3>';
            }
       ?>

    </div>

    <div class="container">
        <h1>Discussions</h1>

           <?php
                $id = $_GET['thread-id'];
                $sql = "SELECT * FROM `comments` WHERE `thread_id` = $id";
                $result = mysqli_query($conn, $sql);
                $noresult = true;
                while($row = mysqli_fetch_assoc($result)){
                    $noresult = false;
                    
                    $comment = $row['comment_content'];
                    $id = $row['comment_id'];
                    $user_id = $row['comment_by'];
                    $comment_time = $row['comment_time'];
                    $sql2 = "SELECT * FROM `users` WHERE `srno` =  '$user_id' ";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                
            echo '
        <div class="media my-3 py-2">
            <img src="img/defaultuser.jpg" width="69px" height="64px" class="mr-3" alt="...">
            <div class="media-body"> <p class="mt-0 font-weight-bold my-0"><a class="text-dark" href="user.php?user_id='. $user_id .
            '">'.  $row2['user_name'] . '</a> at '. $comment_time .'</p>'
                . $comment .'
            </div>
        </div>';
    };
        if($noresult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No comments Yet</p>
              <p class="lead">Be the First to post a comment</p>
            </div>
          </div>';
        };
    
        ?>
       
    </div>

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