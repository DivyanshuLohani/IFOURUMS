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
        $id = $_GET['cat_id'];
        $sql = "SELECT * FROM `categories` WHERE `cat_id`=$id";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)){
            $catname = $row['cat_name'];
            $catdesc = $row['cat_description'];
        }; 
    ?>
    <?php 
        $showalert = false;
        $method = $_SERVER['REQUEST_METHOD'];
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        if($method == 'POST'){
            $th_title = $_POST['title'];
            $th_title = str_replace('<', '&lt', $th_title);
            $th_title = str_replace('>', '&gt', $th_title);
            $th_desc = $_POST['desc'];
            $th_desc = str_replace('<', '&lt', $th_desc);
            $th_desc = str_replace('>', '&gt', $th_desc);
            $user_id = $_SESSION['id'];
            $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$user_id', CURRENT_TIMESTAMP);";
            $result = mysqli_query($conn, $sql);
            $showalert = true;
            if ($showalert){
                echo '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success! </strong> Your Post Has Been Successfully added
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                ';
            }
        }
    }

    ?>

    <div class="container my-2">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo("$catname") ?> Forums</h1>
            <p class="lead"><?php echo("$catdesc") ?></p>
            <hr class="my-4">
            <p>This forum is to share knowledge with each other</p>
            <a class="btn btn-primary btn-lg" href="#BQ" role="button">Browse Topics</a>
        </div>
    </div>

    <div class="container">
        <h1>Start a Discurssion</h1>
        <?php 
            if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
                echo '<form action="' .$_SERVER['REQUEST_URI'] .'" method="POST">
                <div class="form-group">
                    <label for="exampleInputEmail1">Problem Title</label>
                    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
                    <small id="emailHelp" class="form-text text-muted">Keep your title As crisp as possible</small>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Elaborate Problem</label>
    
                    <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>';

            }
        else{
            echo '<h3><span class="badge badge-dark">You Need To <a type="button"data-toggle="modal" data-target="#loginmodal" class="text-primary">Login</a> To be able to post a comment</span></h3>';
        }
        
        ?>
         

    <div class="container my-4">
        <h1 id="BQ">Browse Questions</h1>

        <?php
                $id = $_GET['cat_id'];
                $sql = "SELECT * FROM `threads` WHERE `thread_cat_id` = $id";
                $result = mysqli_query($conn, $sql);
                $noresult = true;
                while($row = mysqli_fetch_assoc($result)){
                    $noresult = false;
                    $thread_name = $row['thread_title'];
                    $thread_desc = $row['thread_desc'];
                    $id = $row['thread_id'];
                    $thread_time = $row['timestamp'];
                    $thread_user_id = $row['thread_user_id'];
                    $sql2 = "SELECT * FROM `users` WHERE `srno` =  $thread_user_id ";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
             
         
            echo '
        <div class="media my-4 py-2">
            <img src="img/defaultuser.jpg" width="69px" height="64px" class="mr-3" alt="...">
            <div class="media-body">
            <h5 class="mt-0"><p class="mt-0 font-weight-bold my-0">
            <a class="text-dark" href="thread.php?thread-id='. $id .'">'. $thread_name .'</a></h5>'
                . $thread_desc .'
                

            </div>
            <p class"font-weight-bold"><a class="text-dark" href="user.php?user_id='. $row2['srno'] .'">'. $row2['user_name'] . '</a> at '. $thread_time .'</p>
        </div>';
    };
    if($noresult){
        echo '<div class="jumbotron jumbotron-fluid">
        <div class="container">
          <p class="display-4">No Questions Yet  &#128542;</p>
          <p class="lead"> &#128515;   Be the First to post a question</p>
        </div>
      </div>';
    }
        ?>

        



    </div>
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