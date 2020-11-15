<?php
$page = 'Administrator Login';
$title = 'adminLogin';
require 'head.php';
require 'usefulFunctions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //session_start();
    $email = testInput($_POST["email"]);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $passwordMD5 = testInput($_POST["password"]);
    $passwordMD5 = filter_var($passwordMD5, FILTER_SANITIZE_STRING);
    $passwordMD5 = md5($passwordMD5);

    try {
        require "connectpdo.php";
        $sql = "SELECT email
                    FROM users 
                    WHERE email = :email 
                    AND password = :passwordMD5";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array( //execute query
            ':email' => $email,
            ':passwordMD5' => $passwordMD5
        ));

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch();
            $_SESSION["email_user"] = $result['email'];
            header("Location: unsubscribeMembership.php");
        } else {
            showMessage('Email or Password not found.');
            header("Location: adminLogin.php");
        }
    } catch (PDOException $e) {
        showMessage('Error: ' . $e->getMessage());
    } finally {
        $conn = null;
    }
}
?>
<main>
    <h2>Login
        <h3>
            <div class="container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-50">
                            <input type="email" id="email" name="email" maxlength="100" required pattern="^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" title="Please enter a correct email format." placeholder="Email..">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="password">Password</label>
                        </div>
                        <div class="col-50">
                            <input type="password" id="password" name="password" maxlength="50" required placeholder="Password..">
                        </div>
                    </div>

                    <div class="row">
                        <input type="submit" name="login" value="Login">
                    </div>
                </form>
            </div>
        </h3>
    </h2>

</main>
</body>

</html>