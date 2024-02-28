<?php
session_start();

// Function to sanitize user input
function sanitizeInput($input) {
    // Remove HTML tags
    $input = strip_tags($input);
    // Convert special characters to HTML entities
    $input = htmlspecialchars($input);
    return $input;
}

// Check if the user's IP address has already sent a message
if (isset($_SESSION['message_sent']) && $_SESSION['message_sent'] === true) {
    // Redirect the user back to the index page or show a message
    header("Location: index.php");
    exit; // Stop further execution
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user's IP address
    $user_ip = $_SERVER['REMOTE_ADDR'];

    // Check if the user's IP address has already sent a message
    if (file_exists('messages/' . $user_ip . '.txt')) {
        // Redirect the user back to the index page or show a message
        header("Location: index.php");
        exit; // Stop further execution
    }

    // Sanitize input
    $name = sanitizeInput($_POST['name']);
    $message = sanitizeInput($_POST['message']);
    $time = time();

    // Handle image upload
    $image = $_FILES['image'];
    $imagePath = 'uploads/' . basename($image['name']);
    move_uploaded_file($image['tmp_name'], $imagePath);

    $jsonData = file_get_contents('messages.json');
    $data = json_decode($jsonData, true);

    $data[] = [
        'name' => $name,
        'message' => $message,
        'time' => $time,
        'image' => $imagePath  // Store the image path in the JSON data
    ];

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents('messages.json', $jsonData);

    // Create a file to mark that this IP address has sent a message
    file_put_contents('messages/' . $user_ip . '.txt', '');

    // Set session variable to indicate that a message has been sent in this session
    $_SESSION['message_sent'] = true;

    header("Location: index.php");
    exit; // Ensure script stops execution after redirection
}
?>
