<!--
Date: 22/11/2020
Students: Willian Bernatzki Woellner,  Jyle Darling, Travis Reeve
Course: Diploma of Software Development
Cluster: Rapid App Development
Page: newAdmin.php
Version: 1.0
Project: RAD application on the Movie Search Database.  
Version Developer: Travis Reeve
-->
<?php
    $page = 'Administrator Login';
    $title = 'adminLogin';
    require 'head.php';
    require 'usefulFunctions.php';
    try
    {
        require "connectpdo.php";
        if(isset($_POST["email"]))
        {
            $email = $_POST["email"];
        }
        if(isset($_POST["password"]))
        {
            $password = $_POST["password"];
        }
        $stmt = $conn->prepare('INSERT users(email, password) VALUES (:email, :password)');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        echo '<H3>';
        echo 'New admin created';
        echo '</H3>';
        
    }
    catch (PDOException $e) 
    {
         
    }
    $conn = null;
?>
<main>
    <h2>Create new admin
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
                            <input type="password" id="password" name="password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                        </div>
                        <div class="row">
                            <input type="submit" name="add" value="Add">
                        </div>        
                </form>
                    </div>
                    <div id="message">
                        <h3>Password must contain the following:</h3>
                        <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                        <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                        <p id="number" class="invalid">A <b>number</b></p>
                        <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                    </div>
        </h3>
    </h2>
</main>