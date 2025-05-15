<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
    session_unset();
    session_destroy();
    header("Location: ../index.php"); // Reindirizza alla homepage o pagina login
    exit();
}
else {
    header("Location: ../index.php"); // Reindirizza alla homepage o pagina login
}
