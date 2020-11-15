<?php
if (!isset($_SESSION)) {
    session_start();
}
//var_dump($_SESSION['message']);
if (isset($_SESSION['message']) && !empty($_SESSION['message'])) {
    echo $_SESSION['message'];
    $_SESSION['message'] = "";
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sendEmail($unsubscribeEmail)
{
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require "connectpdo.php";

    try {
        $mail = new PHPMailer();
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'radproject.willian@gmail.com';                 // SMTP username
        $mail->Password = 'Password01@';                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to    
        $mail->setFrom('radproject.willian@gmail.com', 'RAD Application');
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Unsubscribe Request!';
        $mail->Body    = 'Unsubscribe email: <b>' . $unsubscribeEmail . '</b>';

        $sql = "SELECT email FROM users";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll();

            foreach ($result as $row) {
                $mail->addAddress($row['email'], 'Administrator');     // Add a recipient
            }

            if (!$mail->send()) {
                showMessage('Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
            }
        } else {
            showMessage('Administrators not found to send email.');
        }
    } catch (PDOException $e) {
        showMessage('Error: ' . $e->getMessage());
    } finally {
        $conn = null;
    }
}

function showMessage($message)
{    
    $_SESSION["message"] = "<div class='divMessage'><label>* " . $message . "</label></div>";
}

//function to test any input provided by the user to ensure it is not malicious.
function testInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
