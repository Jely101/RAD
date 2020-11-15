<!DOCTYPE html>

<html lang="en">

<head>
    <!-- title displayed on browser tab -->
    <title>Movie Search - <?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <link rel="stylesheet" href="website_styles.css">
    <script src="main.js"></script>
</head>

<body>
    <div>
        <header>
            <div class="container-fluid">
                <!-- enables the header elements to adapt to different page widths -->
                <div class="header">
                    Movie Rental
                </div>
                <h2 class="text-center"><?php echo $page ?></h2> <!-- calls the text for the title bar -->
            </div>
        </header>
    </div>
    <ul id="nav">
        <!-- will be a horizontal navigation bar of different pages -->
        <li><a href="index.php">Home</a></li>
        <li><a href="search.php">Search</a></li>
        <li><a href="top_ten.php">Top Ten</a></li>
        <li><a href="adminLogin.php">Admin Login</a></li>
    </ul>