<?php
$page = 'Unsubscribe Membership';
$title = 'unsubscribeMembership';
require "verify.php";
require 'adminHead.php';
require 'usefulFunctions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["remove"])) {
        $email = testInput($_POST["email"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    } else {
        $email = testInput($_POST["emailGrid"]);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    if (isset($email)) {
        if (verifyMembershipUnsubscribe($email)) {
            removeMembership($email);
        } else {
            showMessage('Membership cannot be removed. Unsolicited unsubscribe.');
        }
    }
}

function verifyMembershipUnsubscribe($email)
{
    try {
        require "connectpdo.php";
        $sql = "SELECT email 
                FROM membership 
                WHERE email = :email 
                AND unsubscribe = :unsubscribe";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array( //execute query
            ':email' => $email,
            ':unsubscribe' => true
        ));
        $membershipCheck = $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        showMessage('Error: ' . $e->getMessage());
    } finally {
        $conn = null;
    }

    return $membershipCheck;
}

function removeMembership($email)
{
    try {
        require "connectpdo.php";
        $sql = "DELETE FROM membership WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array( //execute query
            ':email' => $email
        ));
    } catch (PDOException $e) {
        showMessage('Error: ' . $e->getMessage());
    } finally {
        $conn = null;
    }
    showMessage('Membership successfully removed.');
    header('Location: unsubscribeMembership.php');
}
?>
<main>
    <h2>
        <h3>
            <div class="container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="email">Email</label>
                        </div>
                        <div class="col-50">
                            <input type="text" id="email" name="email" maxlength="100" required pattern="^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$" title="Please enter a correct email format." placeholder="Email..">
                        </div>
                    </div>
                    <div class="row">
                        <input type="submit" name="remove" value="Remove">
                    </div>
                </form>
            </div>

            <div class="ex1">
                <?php
                try {
                    require "connectpdo.php";
                    $sql = "SELECT
                                fullName,
                                email,
                                monthlyNews,
                                breakingNews    
                            FROM membership                        
                            WHERE 
                                unsubscribe = :unsubscribe";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute(array( //execute query
                        ':unsubscribe' => true
                    ));
                    $dataSearch = $stmt->fetchAll();
                    echo '<table id="results">';
                    echo "<tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Monthly News</th>
                                <th>Breaking News</th>
                                <th></th>
                            </tr>";
                    // output data of each row
                    foreach ($dataSearch as $row) {
                        echo "<tr>
                                    <td>" . $row['fullName'] . "</td>
                                    <td>" . $row['email'] . "</td>
                                    <td>" . ($row['monthlyNews'] ? 'Yes' : 'No') . "</td>
                                    <td>" . ($row['breakingNews'] ? 'Yes' : 'No') . "</td>
                                    <td>
                                        <form action=" . htmlspecialchars($_SERVER['PHP_SELF']) . " method='post'>
                                        <input type='hidden' id='emailGrid' name='emailGrid' value=" . $row['email'] . " />
                                        <input type='submit' name='removeGrid' id='removeGrid' value='Remove' />
                                        </form>
                                    </td>
                                </tr>";
                    }
                    echo "</table>";
                } catch (PDOException $e) {
                    showMessage('Error: ' . $e->getMessage());
                }
                $conn = null;
                ?>
            </div>
        </h3>
    </h2>

</main>
</body>

</html>