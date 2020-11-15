<!-- this code is designed to provide a chart which displays the ten most searched for movies contained in the database. the search file updates the database 
each time a item from the databse is queried. -->
<?php
    $page = 'Top Ten Search Results';
    $title = 'Top Ten';
    require 'head.php';
?>
<main>
    <?php

    $x = 0;
    require "connectpdo.php";
    $stmt = $conn->prepare("SELECT Title, times_searched FROM `movies_table` ORDER BY times_searched DESC LIMIT 10");
    $stmt->execute();
    $dataTopTen = $stmt->fetchAll();
    $conn = null;

    $dataTitle = array();
    $dataCount = array();

    foreach ($dataTopTen as $row) {
        $title = $row['Title'];
        $count = $row['times_searched'];

        array_push($dataTitle, $title);
        array_push($dataCount, $count);
    }

    $data;
    /*
                * Chart settings and create image
                */

    // Image dimensions
    $imageWidth = 1000;
    $imageHeight = 400;

    // Grid dimensions and placement within image
    $gridTop = 40;
    $gridLeft = 50;
    $gridBottom = 340;
    $gridRight = 950;
    $gridHeight = $gridBottom - $gridTop;
    $gridWidth = $gridRight - $gridLeft;

    // Bar and line width
    $lineWidth = 1;
    $barWidth = 20;

    // Font settings
    $font = 'C:\xampp\htdocs\Movie_search\OpenSans-Regular.ttf';
    $fontSize = 10;

    // Margin between label and axis
    $labelMargin = 8;

    // Max value on y-axis
    $yMaxValue = 30;

    // Distance between grid lines on y-axis
    $yLabelSpan = 5;

    // Init image
    $chart = imagecreate($imageWidth, $imageHeight);

    // Setup colors
    $backgroundColor = imagecolorallocate($chart, 255, 255, 255);
    $axisColor = imagecolorallocate($chart, 85, 85, 85);
    $labelColor = $axisColor;
    $gridColor = imagecolorallocate($chart, 212, 212, 212);
    $barColor = imagecolorallocate($chart, 47, 133, 217);

    imagefill($chart, 0, 0, $backgroundColor);

    imagesetthickness($chart, $lineWidth);

    /*
                * Print grid lines bottom up
                */

    for ($i = 0; $i <= $yMaxValue; $i += $yLabelSpan) {
        $y = $gridBottom - $i * $gridHeight / $yMaxValue;

        // draw the line
        imageline($chart, $gridLeft, $y, $gridRight, $y, $gridColor);

        // draw right aligned label
        $labelBox = imagettfbbox($fontSize, 0, $font, strval($i));
        $labelWidth = $labelBox[4] - $labelBox[0];

        $labelX = $gridLeft - $labelWidth - $labelMargin;
        $labelY = $y + $fontSize / 2;

        imagettftext($chart, $fontSize, 0, $labelX, $labelY, $labelColor, $font, strval($i));
    }

    /*
                * Draw x- and y-axis
                */

    imageline($chart, $gridLeft, $gridTop, $gridLeft, $gridBottom, $axisColor);
    imageline($chart, $gridLeft, $gridBottom, $gridRight, $gridBottom, $axisColor);

    /*
                * Draw the bars with labels
                */

    $barSpacing = $gridWidth / count($dataTitle);
    $itemX = $gridLeft + $barSpacing / 2;

    foreach ($dataCount as $key => $value) {
        // Draw the bar
        $x1 = $itemX - $barWidth / 2;
        $y1 = $gridBottom - $value / $yMaxValue * $gridHeight;
        $x2 = $itemX + $barWidth / 2;
        $y2 = $gridBottom - 1;

        imagefilledrectangle($chart, $x1, $y1, $x2, $y2, $barColor);

        // Draw the label
        $labelBox = imagettfbbox($fontSize, 0, $font, $key);
        $labelWidth = $labelBox[4] - $labelBox[0];

        $labelX = $itemX - $labelWidth / 2;
        $labelY = $gridBottom + $labelMargin + $fontSize;


        imagettftext($chart, $fontSize, 90, $labelX - 20, $labelY - 20, $labelColor, $font, $dataTitle[$x]);
        $x++;

        $itemX += $barSpacing;
    }

    imagepng($chart, 'chart.png');
    ?>
    <h2>
        <div class="ex1">
            <img src="chart.png" alt="results from dice rolls" />
        </div>
    </h2>
</main>
</body>

</html>