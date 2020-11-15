<!-- This code established the index for the website -->
<?php
$page = 'Home';
$title = 'Home';
require 'head.php';
require 'usefulFunctions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["subscribe"])) {
        $fullName = testInput($_POST["fullName"]);
        $fullName = filter_var($fullName, FILTER_SANITIZE_STRING);
        $email = testInput($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $monthlyNews = isset($_POST["monthlyNews"]);
        $breakingNews = isset($_POST["breakingNews"]);

        if (verifySubscribe($email)) {
            subscribe($fullName, $email, $monthlyNews, $breakingNews);
        }
        else{
            showMessage('Email already subscribed.');
            header('Location: index.php');
        }
    } else {
        $email = testInput($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        unsubscribe($email);
    }
}

function verifySubscribe($email)
{
    try {
        require "connectpdo.php";
        $sql = "SELECT email 
                FROM membership 
                WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array( //execute query
            ':email' => $email
        ));
        $subscribeCheck = $stmt->rowCount() <= 0;
    } catch (PDOException $e) {
        showMessage('Error: ' . $e->getMessage());
    } finally {
        $conn = null;
    }
    return $subscribeCheck;
}

function subscribe($fullName, $email, $monthlyNews, $breakingNews)
{
    try {
        require "connectpdo.php";
        $sql = "INSERT INTO membership (
            fullName, 
            email, 
            monthlyNews, 
            breakingNews, 
            unsubscribe ) 
        VALUES (
            :fullName,
            :email, 
            :monthlyNews, 
            :breakingNews, 
            :unsubscribe )";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array( //execute query
            ':fullName' => $fullName,
            ':email' => $email,
            ':monthlyNews' => $monthlyNews,
            ':breakingNews' => $breakingNews,
            ':unsubscribe' => false
        ));
        showMessage('Subscribe successfully saved.');
    } catch (PDOException $e) {
        showMessage('Error: ' . $e->getMessage());
    } finally {
        $conn = null;
        header('Location: index.php');
    }
}

function unsubscribe($email)
{
    try {
        require "connectpdo.php";
        $sql = "UPDATE membership 
                SET unsubscribe = :unsubscribe
                WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array( //execute query
            ':unsubscribe' => true,
            ':email' => $email
        ));
        showMessage('Unsubscribe successfully saved.');
    } catch (PDOException $e) {
        showMessage('Error: ' . $e->getMessage());
    } finally {
        $conn = null;
    }
    sendEmail($email);
    header('Location: index.php');
}

?>
<main>
    <h2 id="h2Title">Subscribe to our newsletter
        <h3>
            <div class="container">
                <form id="mainForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row" id="divFullName">
                        <div class="col-25">
                            <label for="fullName">Full Name</label>
                        </div>
                        <div class="col-50">
                            <input type="text" id="fullName" name="fullName" maxlength="100" required placeholder="Full Name..">
                        </div>
                    </div>
                    <div class="row" id="divEmail">
                        <div class="col-25">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-50">
                            <input type="email" pattern="^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" title="Please enter a correct email format." id="email" name="email" maxlength="50" required placeholder="Email..">
                        </div>
                    </div>
                    <div class="row" id="divMonthlyNews">
                        <div class="col-25">
                            <label for="monthlyNews">Monthly Newsletter</label>
                        </div>
                        <div class="col-50 rowCheckbox">
                            <input type="checkbox" id="monthlyNews" name="monthlyNews" class="checkbox">
                        </div>

                    </div>
                    <div class="row" id="divBreakNews">
                        <div class="col-25">
                            <label for="breakingNews">Breaking News</label>
                        </div>
                        <div class="col-50 rowCheckbox">
                            <input type="checkbox" id="breakingNews" name="breakingNews" class="checkbox">
                        </div>

                    </div>
                    <div class="row" id="divSubscribeButton">
                        <input type="submit" name="subscribe" value="Subscribe">
                    </div>
                    <div class="row" id="divUnsubscribeLink">
                        <a href="javascript:hideFields();" class="linkButton">Unsubscribe</a>
                    </div>
                </form>
            </div>
        </h3>
    </h2>

</main>
</body>

</html>