<!--
Date: 15/11/2020
Students: Willian Bernatzki Woellner,  Jyle Darling, Travis Reeve
Course: Diploma of Software Development
Cluster: Rapid App Development
Page: verify.php
Version: 2.0
Project: RAD application on the Movie Search Database.  
Version Developer: Willian Bernatzki Woellner
-->
<?php
    // Start session
    if (!isset($_SESSION)) {
        session_start();
    }

    // check admin user is logon
    if(!isset($_SESSION["email_user"]))
    {
        //user have not login redirect to login
    header("Location: adminLogin.php");
    exit;
}
