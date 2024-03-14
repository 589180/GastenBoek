<?php
session_start();

ini_set('upload_max_filesize', '2M');
ini_set('post_max_size', '2M');

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

    $nameLimit = 8; 
    $messageLimit = 250; 
    
    $name = sanitizeInput($_POST['name']);
    if (strlen($name) > $nameLimit) {
        echo "Error: Name exceeds the character limit of $nameLimit.";
        exit;

    }
    $message = sanitizeInput($_POST['message']);
    if (strlen($message) > $messageLimit) {
        echo "Error: Message exceeds the character limit of $messageLimit.";
        exit;
    }
    
    $time = time();

    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $imageSize = $image['size']; 
        $maxFileSize = 2097152; 
        if ($imageSize > $maxFileSize) {
            echo "Error: File size exceeds the limit of 2MB.";
            exit;
        }
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

function sanitizeInput($input) {
    $input = strip_tags($input); 
    $input = htmlspecialchars($input);
    
    $badWords = array("nigger", "niger", "n1gger", "bitch", "b1tch", "fuck", "porn", "pornhub", "href", "'https", "neger", "negger", "kut", "fock", "h0mo", "homo");
    $input = preg_replace("/\b(nig\w*)\b/i", "***", $input); // Replace words starting with 'nig' with ***
    $input = str_ireplace($badWords, "***", $input); // Replace other bad words with ***

    $input = preg_replace("/\b(pornhub\w*)\b/i", "***", $input); // Replace words containing 'pornhub' with ***
    $input = preg_replace("/\b(https\w*)\b/i", "***", $input); // Replace words containing 'https' with ***
    $input = preg_replace("/\b(neg\w*)\b/i", "***", $input); // Replace words starting with 'neg' with ***
    $input = preg_replace("/\b(kut\w*)\b/i", "***", $input); // Replace words containing 'kut' with ***
    $input = preg_replace("/\b(fock\w*)\b/i", "***", $input); // Replace words containing 'fock' with ***
    return $input;
}
?>
