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
                </a>
            </div>
            <div class="bottom-button">
                <a id="click">
                    <div class="Button3" id="plusButton">
                        <div class="plusIcon">+</div>
                    </div>
                </a>
            </div>    
        </div>
        <div class="overlay">
            <div class="overlay-content">
                <span class="closeButton" onclick="closeOverlay()">×</span>
                <h2>Gastenboek Bericht</h2>
                <?php
                // Load existing messages from JSON file
                $jsonData = file_get_contents("messages.json");
                $data = json_decode($jsonData, true);

                // Get current timestamp
                $currentTimestamp = time();

                // Check if the last message was sent today
                if (!empty($data)) {
                    $lastMessageTimestamp = end($data)['time']; // Get the timestamp of the last message
                    $lastMessageDate = date('Y-m-d', $lastMessageTimestamp);
                    $currentDate = date('Y-m-d', $currentTimestamp);

                    if ($lastMessageDate == $currentDate) {
                        // If the last message was sent today, inform the user and exit
                        echo "<p>You can only send one message per day. Please try again tomorrow.</p>";
                    } else {
                        // If the last message was not sent today, display the form
                        echo '
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                            <label for="name">Your Name:</label>
                            <input type="text" id="name" name="name" required>
                            <label for="message">Your Message:</label>
                            <textarea id="message" name="message" required maxlength="10"></textarea>
                            <div class="image-upload">
                                <label for="image">Optional Image:</label>
                                <input type="file" id="image" name="image" accept="image/*">
                            </div>
                            <button type="submit" value="Submit">Submit</button>
                        </form>';
                    }
                } else {
                    // If there are no existing messages, display the form
                    echo '
                    <form action="upload.php" method="post" enctype="multipart/form-data">
                        <label for="name">Your Name:</label>
                        <input type="text" id="name" name="name" required>
                        <label for="message">Your Message:</label>
                        <textarea id="message" name="message" required maxlength="10"></textarea>
                        <div class="image-upload">
                            <label for="image">Optional Image:</label>
                            <input type="file" id="image" name="image" accept="image/*">
                        </div>
                        <button type="submit" value="Submit">Submit</button>
                    </form>';
                }
                ?>
            </div>
        </div>
        <div class="BerichtenBox">
            <?php
            // Display existing messages
            foreach ($data as $bericht) {
                // Extract message details from the $bericht array
                $name = $bericht['name'];
                $message = $bericht['message'];
                $timestamp = $bericht['time']; // Assuming $time contains the Unix timestamp
                
                // Convert Unix timestamp to a human-readable date and time format
                $time = date('d-m-y H:i:s', $timestamp);
                
                // Output the message details within HTML structure
                echo '
                <div class="Bericht">
                    <div class="Image">
                        <img id="BerichtImg" src="' . $bericht['image'] . '">
                    </div>
                    <div class="name">' . $name . '</div>
                    <div class="date">' . $time . '</div>
                    <div class="Message">' . $message . '</div>
                </div>';
            }
            ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
