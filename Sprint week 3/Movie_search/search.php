<!--
Date: 15/11/2020
Students: Willian Bernatzki Woellner,  Jyle Darling, Travis Reeve
Course: Diploma of Software Development
Cluster: Rapid App Development
Page: search.php
Version: 2.0
Project: RAD application on the Movie Search Database.  
Version Developer: Jyle Darling
-->

<!-- This code allows the user to query the database with a search term based on multiple input fields.
 the code also updates any database items returned by the search query to track the amount of times that item has been searched for.-->
<?php
    error_reporting(E_ERROR | E_WARNING | E_PARSE);
    $page = 'Search';
    $title = 'Search';
    require 'head.php';
    require 'usefulFunctions.php';

// define variables and set to empty values    
$title = $genre = $rating = $year = $info = $query = "";
$select = "SELECT Title, Studio, Status, Rating, Year, Genre FROM movies_table WHERE ";
$update = "UPDATE movies_table SET times_searched = times_searched + 1 WHERE ";
$resultFound = false;

require "connectpdo.php";
$stmt = $conn->prepare("SELECT DISTINCT Rating FROM movies_table ORDER BY Rating ASC");
$stmt->execute();
$dataRating = $stmt->fetchAll();
$conn = null;

require "connectpdo.php";
$stmt = $conn->prepare("SELECT DISTINCT Genre FROM movies_table ORDER BY Genre ASC");
$stmt->execute();
$dataGenre = $stmt->fetchAll();
$conn = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = testInput($_POST["title"]);
    $genre = $_POST["genre"];
    $rating = $_POST["rating"];
    $year = testInput($_POST["year"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[0-9]*$/", $year)) {
        $info = "Only numbers for movie year";
    }

    // if statement to determine what input fields the user has entered and alter the sql queries
    if (empty($_POST["title"]) && empty($_POST["genre"]) && empty($_POST["rating"]) && empty($_POST["year"])) {
    } else {

        if (!empty($_POST["title"])) {
            $query .= "Title LIKE '%" . $title . "%'";
        }
        if (!empty($_POST["genre"])) {
            if (!empty($_POST["title"])) {
                $query .= 'AND Genre = "' . $genre . '"';
            } else {
                $query .= 'Genre = "' . $genre . '"';
            }
        }
        if (!empty($_POST["rating"])) {
            if (!empty($_POST["title"]) || !empty($_POST["genre"])) {
                $query .= 'AND Rating = "' . $rating . '"';
            } else {
                $query .= 'Rating = "' . $rating . '"';
            }
        }
        if (!empty($_POST["year"])) {
            if (!empty($_POST["title"]) || !empty($_POST["genre"]) || !empty($_POST["rating"])) {
                $query .= 'AND Year = "' . $year . '"';
            } else {
                $query .= 'Year = "' . $year . '"';
            }
        }

        $resultFound = true;
        $query .= ' ORDER BY Title';
    }
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="genre">Genre</label>
                        </div>
                        <div class="col-50">
                            <select id="genre" name="genre" value="<?php echo $genre; ?>">
                                <option value="" disabled selected hidden>Movie Genre..</option>
                                <?php foreach ($dataGenre as $rowGenre) : ?>
                                    <option><?php echo $rowGenre["Genre"] ?></option>
                                <?php endforeach ?>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="rating">Rating</label>
                        </div>
                        <div class="col-50">
                            <select id="rating" name="rating" value="<?php echo $rating; ?>">
                                <option value="" disabled selected hidden>Movie Rating..</option>
                                <?php foreach ($dataRating as $rowRating) : ?>
                                    <option><?php echo $rowRating["Rating"] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="year">Year</label>
                        </div>
                        <div class="col-50">
                            <input type="text" id="year" name="year" value="<?php echo $year; ?>" placeholder="Movie Year..">
                        </div>
                    </div>
                    <input type="submit" name="submit" value="Search">
                    <br><br>
                    <span class="info"> <?php echo $info; ?></span>
                </form>
            </div>
        </h3>
    </h2>
    <div class="ex1">
        <?php
        if ($resultFound) {

            include "connectpdo.php";
            $stmt = $conn->prepare($select . $query);
            $stmt->execute();
            $dataSearch = $stmt->fetchAll();
            $stmt = $conn->prepare($update . $query);
            $stmt->execute();
            $info = "Results Found";

            echo '<table id="results">';
            echo "<tr>
                        <th>Title</th>
                        <th>Studio</th>
                        <th>Status</th>
                        <th>Rating</th>
                        <th>Year</th>
                        <th>Genre</th>
                        <th>Rating</th>
                    </tr>";
            // output data of each row
            foreach ($dataSearch as $row) {
                $title = $row['Title'];
                $studio = $row['Studio'];
                $status = $row['Status'];
                $rating = $row['Rating'];
                $year = $row['Year'];
                $genre = $row['Genre'];
                echo "<tr>
                            <td>$title</td>
                            <td>$studio</td>
                            <td>$status</td>
                            <td>$rating</td>
                            <td>$year</td>
                            <td>$genre</td>
                            <td></td>
                        </tr>";
            }
            echo "</table>";
            $conn = null;
        }

        ?>
    </div>
</main>

</body>

</html>