<?php
    require 'verify.php';
    session_destroy();
    header("location: index.php");
    exit();
?>