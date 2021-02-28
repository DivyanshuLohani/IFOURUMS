<?php

session_start();
echo "Logging You Out Please wait.....";

session_destroy();
header('Location: /forum/index.php')

?>