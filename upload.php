<?php
session_start();

function sanitizeInput($input) {
    $input = strip_tags($input); 
    $input = htmlspecialchars($input);
    // Filter out bad words and words starting with 'nig'
    $badWords = array("nigger", "niger", "n1gger", "bitch", "b1tch", "fuck", "porn", "pornhub", "href", "'https", "neger", "negger", "kut", "fock");
    $input = preg_replace("/\b(nig\w*)\b/i", "***", $input); // Replace words starting with 'nig' with ***
    $input = str_ireplace($badWords, "***", $input); // Replace other bad words with ***
    return $input;
}

if (isset($_SESSION['message_sent']) && $_SESSION['message_sent'] === true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_ip = $_SERVER['REMOTE_ADDR'];

    if (file_exists('messages/' . $user_ip . '.txt')) {
        header("Location: index.php");
        exit;
    }
    
    $name = sanitizeInput($_POST['name']);
    $message = sanitizeInput($_POST['message']);
    $time = time();

    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imagePath = 'uploads/' . basename($image['name']);
        move_uploaded_file($image['tmp_name'], $imagePath);
    } else {
        $imagePath = 'default_image.jpg';
    }

    $jsonData = file_get_contents('messages.json');
    $data = json_decode($jsonData, true);

    $data[] = [
        'name' => $name,
        'message' => $message,
        'time' => $time,
        'image' => $imagePath 
    ];

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents('messages.json', $jsonData);
    file_put_contents('messages/' . $user_ip . '.txt', '');

    $_SESSION['message_sent'] = true;
    header("Location: index.php");
    exit;
}
?>
