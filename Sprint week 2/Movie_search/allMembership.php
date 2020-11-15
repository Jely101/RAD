<!--
Date: 15/11/2020
Students: Willian Bernatzki Woellner,  Jyle Darling, Travis Reeve
Course: Diploma of Software Development
Cluster: Rapid App Development
Page: allMembership.php
Version: 2.0
Project: RAD application on the Movie Search Database.  
Version Developer: Willian Bernatzki Woellner
-->

<?php
$page = 'All Membership';
$title = 'allMembership';
require 'verify.php';
require 'adminHead.php';
?>
<main>
    <h2>
        <h3>
            <div class="ex1">
                <?php
                try {
                    require "connectpdo.php";
                    $sql = "SELECT
                                id,
                                fullName,
                                email,
                                monthlyNews,
                                breakingNews    
                            FROM membership";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $dataSearch = $stmt->fetchAll();
                    echo '<table id="results">';
                    echo "<tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Monthly News</th>
                                <th>Breaking News</th>
                            </tr>";
                    // output data of each row
                    foreach ($dataSearch as $row) {
                        echo "<tr>
                                    <td>" . $row['fullName'] . "</td>
                                    <td>" . $row['email'] . "</td>
                                    <td>" . ($row['monthlyNews'] ? 'Yes' : 'No') . "</td>
                                    <td>" . ($row['breakingNews'] ? 'Yes' : 'No') . "</td>
                                </tr>";
                    }
                    echo "</table>";
                } catch (PDOException $e) {
                    showMessage('Error: ' . $e->getMessage());
                } finally {                    
                    $conn = null;
                }
                ?>
            </div>
        </h3>
    </h2>

</main>
</body>

</html>