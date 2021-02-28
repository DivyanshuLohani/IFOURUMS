<!doctype html>
<html lang="en">

<head>
    <title>IForums - Coding Forums</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <style>
    #maincontainer {
        min-height: 85vh;
    }
    </style>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <?php include 'partials/_header.php' ?>
    <?php include 'partials/_dbconnect.php' ?>

    <div id="maincontainer">
        <div class="container">
            <h1>Search Results For "<em><i><?php echo $_GET['q']; ?></i></em>"</h1>
            <?php
               
                $query = $_GET['q'];
                $sql = "SELECT * FROM `threads` WHERE MATCH (`thread_title`, `thread_desc`)AGAINST('". $query ."')";
                $result = mysqli_query($conn, $sql);
                $noresult = true;
                while($row = mysqli_fetch_assoc($result)){
                    $noresult = false;
                    $thread_name = $row['thread_title'];
                    $thread_desc = $row['thread_desc'];
                    $id = $row['thread_id'];
                    echo'

                    <div class="media mt-4">
                        <div class="media-body">
                            <h5 class="mt-0"><a href="thread.php?thread-id='. $id .'" class="text-dark">'. $thread_name .'</h5>
                            '. $thread_desc .'
                        </div>
                    </div>';
                }
                if($noresult){
                    echo '
                    <div class="jumbotron jumbotron-fluid">
                        <div class="container">
                            <p class="display-4">No Results Found For <em><i>'. $_GET['q'] .'</i></em>  </p>
                            <p class="lead">Suggestions:<ul>
                            

                            <li>Make sure that all words are spelled correctly.</li>
                            <li>Try different keywords.</li>
                            <li>Try more general keywords.</li>
                            </ul></p>
                        </div>
                    </div>
                    ';
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