<!--
Date: 24/11/2020
Students: Willian Bernatzki Woellner,  Jyle Darling, Travis Reeve
Course: Diploma of Software Development
Cluster: Rapid App Development
Page: rate_movies.php
Version: 1.0
Project: RAD application on the Movie Search Database.  
Version Developer: Travis Reeve
-->
<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $page = 'Rate A Movie';
    require 'head.php';
    require 'usefulFunctions.php';
    try 
    {
        require "connectpdo.php";
        $found = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $title = $_POST['title'];
            $rating = $_POST['estrellas'];
            $sql = "SELECT Title FROM movies_table WHERE Title = :title";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            if($result == $title)
            {
                $found = true;
            }
            if($found == true)
            {
                try
                {
                    require "connectpdo.php";
                    $sql2 = "UPDATE `movies_table` SET `times_rated` = `times_rated` + 1 WHERE `Title` = :title";
                    $sql3 = "UPDATE `movies_table` SET `total_rating` = `total_rating` + $rating WHERE `Title` = :title";
                    $sql4 = "UPDATE `movies_table` SET `star_rating` = `total_rating` / `times_rated` WHERE `Title` = :title";
                    $stmt2 = $conn->prepare($sql2);
                    $stmt2->bindParam(':title', $title, PDO::PARAM_STR);
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->bindParam(':title', $title, PDO::PARAM_STR);
                    $stmt4 = $conn->prepare($sql4);
                    $stmt4->bindParam(':title', $title, PDO::PARAM_STR);
                    $stmt2->execute();
                    $stmt3->execute();
                    $stmt4->execute();
                    $conn = null;
                }
                catch(PDOException $e)
                {
                    echo "FOUND!!!!";
                    echo "Error: " . $e->getMessage();
                }
            }
            else
            {
                echo "Movie not found in database";
            }
        }
    }
    catch (PDOException $e) 
    {
        echo "Error: " . $e->getMessage();
    }
?>
<main>
    <h2>Search All Movies
        <h3>
            <div class="container">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="row">
                        <div class="col-25">
                            <label for="title">Title</label>
                        </div>
                        <div class="col-50">
                            <input type="text" id="title" name="title" value="<?php echo $title; ?>" placeholder="Movie Title..">
                            <div id="wrapper">
                                <p class="clasificacion">
                                    <input id="radio1" type="radio" name="estrellas" value="1"><!--
                                    --><label for="radio1">&#9733;</label><!--
                                    --><input id="radio2" type="radio" name="estrellas" value="2"><!--
                                    --><label for="radio2">&#9733;</label><!--
                                    --><input id="radio3" type="radio" name="estrellas" value="3"><!--
                                    --><label for="radio3">&#9733;</label><!--
                                    --><input id="radio4" type="radio" name="estrellas" value="4"><!--
                                    --><label for="radio4">&#9733;</label><!--
                                    --><input id="radio5" type="radio" name="estrellas" value="5"><!--
                                    --><label for="radio5">&#9733;</label>
                                </p>
                            </div>
                            <input type="submit" name="submit" value="Rate">
                        </div>
                    </div>
                    <?php
                            include "connectpdo.php";
                            $sql5 = "SELECT Title, Studio, Status, Rating, Year, Genre, `star_rating` FROM movies_table ORDER BY star_rating DESC LIMIT 5";
                            $stmt5 = $conn->prepare($sql5);
                            $stmt5->execute();
                            $dataSearch = $stmt5->fetchAll();
                            echo '<table id="results">';
                            echo "<tr>
                                        <th>Title</th>
                                        <th>Studio</th>
                                        <th>Status</th>
                                        <th>Rating</th>
                                        <th>Year</th>
                                        <th>Genre</th>
                                        <th>Star Rating</th>
                                    </tr>";
                            // output data of each row
                            foreach ($dataSearch as $row) 
                            {
                                $title = $row['Title'];
                                $studio = $row['Studio'];
                                $status = $row['Status'];
                                $rating = $row['Rating'];
                                $year = $row['Year'];
                                $genre = $row['Genre'];
                                $star_rating = $row['star_rating'];
                                echo "<tr>
                                            <td>$title</td>
                                            <td>$studio</td>
                                            <td>$status</td>
                                            <td>$rating</td>
                                            <td>$year</td>
                                            <td>$genre</td>
                                            <td>$star_rating</td>
                                        </tr>";
                            }
                            echo "</table>";
                            $conn = null;
                        ?>
                </form>
            </div>
        </h3>
    </h2>
</main>