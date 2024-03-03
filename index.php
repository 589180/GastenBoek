
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
                    <img id="nav-logo" src="uploads/home.png"> <!-- Link to home page -->
                </a>
            </div>
            <div class="bottom-button">
                <a id="click">
                    <div class="Button3" id="plusButton"> <!-- Button to open message submission form -->
                        <div class="plusIcon">+</div> <!-- Icon for the button -->
                    </div>
                </a>
            </div>
        </div>
        <div class="overlay">
            <div class="overlay-content">
                <span class="closeButton" onclick="closeOverlay()">×</span> <!-- Button to close the overlay -->
                <?php
                session_start(); // Start or resume a session to store data across multiple pages
                
                // Check if a message has already been sent in this session
                if (isset($_SESSION['message_sent']) && $_SESSION['message_sent'] === true) {
                    echo "<h2>Je hebt al een bericht gestuurd. Je mag maar één bericht sturen per sessie.</h2>"; // Display a message if message has already been sent
                } else {
                ?>
                <h2>Gastenboek Bericht</h2> <!-- Title for the message form -->
                <form action="upload.php" method="post" enctype="multipart/form-data"> <!-- Form for submitting messages -->
                    <label for="name">Your Name:</label> <!-- Input field label for user's name -->
                    <input type="text" id="name" name="name" required maxlength="8"> <!-- Input field for user's name -->
                    <label for="message">Your Message:</label> <!-- Input field label for user's message -->
                    <textarea id="message" name="message" required maxlength="250"></textarea> <!-- Input field for user's message -->
                    <div class="image-upload"> <!-- Container for optional image upload -->
                        <label for="image">Optional Image:</label> <!-- Label for image upload -->
                        <input type="file" id="image" name="image" accept="image/*"> <!-- Input field for uploading image -->
                    </div>
                    <button type="submit" value="Submit">Submit</button> <!-- Submit button for sending the message -->
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
                <img id="BerichtImg" src="<?php echo $bericht['image']; ?>"> <!-- Display message image -->
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
