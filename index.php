
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
                    <img id="nav-logo" src="navimg.png"> <!-- Link to home page -->
            </a>
            </div>
            <div class="bottom-button">
                <a id="click">
                    <div class="Button1" id="plusButton"> <!-- Button to open message submission form -->
                        <div class="plusIcon">+</div> <!-- Icon for the button -->
                    </div>
                </a>
            </div>
        </div>
        <div class="overlay">
            <div class="overlay-content">
            <span class="closeButton" onclick="closeOverlay()" ontouchstart="closeOverlay()">×</span>
                <?php
                    session_start(); // Start een nieuwe sessie of hervat een bestaande sessie om gegevens over meerdere pagina's te behouden

                    // Controleer of er al een bericht is verzonden in deze sessie
                    if (isset($_SESSION['message_sent']) && $_SESSION['message_sent'] === true) {
                        echo "<h2>Je hebt al een bericht gestuurd. Je mag maar één bericht sturen per sessie.</h2>"; // Als er al een bericht is verzonden, toon dan een bericht aan de gebruiker
                    } else { // Als de waarde niet true is dan opent hij het formulier.
                ?>

                <h2>Gastenboek Bericht</h2> <!-- Title for the message form -->
                <form id="upload-form" action="upload.php" method="post" enctype="multipart/form-data">
                    <label for="name">Jou naam:</label>
                    <input type="text" id="name" name="name" required maxlength="8">
                    <label for="message">Jou bericht:</label>
                    <textarea id="message" name="message" required maxlength="250"></textarea>
                    <div class="image-upload">
                        <label for="image">Optionele afbeelding:</label>
                        <input type="file" id="image" name="image" accept=".avif, .jpg, .jpeg, .png">
                        <div id="image-error" class="error-message"></div>
                    </div>
                    <button type="submit" value="Submit">inzenden</button>
                </form>
                <?php } ?>
            </div>
        </div>
        <div class="BerichtenBox">
    <?php
    $jsonData = file_get_contents("messages.json"); // Read JSON data from file
    $data = json_decode($jsonData, true); // Decode JSON data into associative array

    $time = date('d-m-y H:i:s'); // Get current time

    foreach ($data as $bericht) { // Loop through each message in the data
        // Extract message details from the $bericht array
        $name = $bericht['name']; // Get the sender's name
        $message = $bericht['message']; // Get the message content
        $timestamp = $bericht['time']; // Get the Unix timestamp of the message

        // Convert Unix timestamp to a human-readable date and time format
        $time = date('d-m-y H:i:s', $timestamp); // Convert Unix timestamp to date and time format

        // Output the message details within HTML structure
        ?>
        <div class="Bericht"> <!-- Container for each individual message -->
            <div class="Image"> <!-- Container for message image -->
                <img id="BerichtImg" src="<?php echo $bericht['image']; ?>" alt="default_image.jpg" > <!-- Display message image -->
            </div>
            <div class="name"><?php echo $name; ?></div> <!-- Display message sender's name -->
            <div class="date"><?php echo $time; ?></div> <!-- Display message timestamp -->
            <div class="Message"><?php echo $message; ?></div> <!-- Display message content -->
        </div>
        <?php
    }
    ?>
    </div>
    </div>
    </div>
    <script src="script.js"></script> <!-- Include JavaScript file -->
</body>
</html>
