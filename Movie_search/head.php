<!DOCTYPE html>

<html lang="en">

<head>
    <!-- title displayed on browser tab -->
    <title>Movie Search - <?php echo $title; ?></title>    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="website_styles.css">
</head>
<body>
    <div>
        <header>
            <div class="container-fluid">
                <!-- enables the header elements to adapt to different page widths -->
                <div class="header">
                    <img src="Cinema.jpg" alt="" style="width:max-content;"> <!-- the image to be used in the header -->
                    <div class="centered">Movie Rental</div> <!-- the text ontop of the image -->
                </div>
                <h2 class="text-center"><?php echo $page ?></h2> <!-- calls the text for the title bar -->
            </div>
        </header>
    </div>
