<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GastenBoek</title>
    <link rel="stylesheet" href="gast.css">
</head>
<body>
    <div class="deskContainer">
        <div class="side-nav">
            <div class="header-logo">
                <a href="index.html">
                    <img id="nav-logo" src="uploads/home.png">
                </a></div>
            <div class="bottom-button">
                <a id="click">
                   <div class="Button3" id="plusButton">
                  <div class="plusIcon">+</div>
                </a>
            </div>
          </div>    
        </div>
        <div class="overlay">
            <div class="overlay-content">
                <span class="closeButton" onclick="closeOverlay()">×</span>
                <h2>Gastenboek Bericht</h2>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="message">Your Message:</label>
                    <textarea id="message" name="message" required></textarea>
                    <div class="image-upload">
                    <label for="image">Optional Image:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    <button type="submit" value="Submit">Submit</button>
                </form>
            </div>
        </div>
        <div class="BerichtenBox">
    <?php
    $jsonData = file_get_contents("messages.json");
    $data = json_decode($jsonData, true);

    $time = date('d-m-y H:i:s'); // Current time

    foreach ($data as $bericht) {
        // Extract message details from the $bericht array
        $name = $bericht['name'];
        $message = $bericht['message'];
        $timestamp = $bericht['time']; // Assuming $time contains the Unix timestamp
    
        // Convert Unix timestamp to a human-readable date and time format
        $time = date('d-m-y H:i:s', $timestamp);
    
        // Output the message details within HTML structure
        ?>
        <div class="Bericht">
            <div class="Image">
                <img id="BerichtImg" src="<?php echo $bericht['image']; ?>">
            </div>
            <div class="name"><?php echo $name; ?></div>
            <span class="date"><?php echo $time; ?></span>
            <div class="Message"><?php echo $message; ?></div>
        </div>
        <?php
    }
    ?>
    </div>
    </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
