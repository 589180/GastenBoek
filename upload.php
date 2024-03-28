<?php
session_start();

# Upload limit = 2MB 
ini_set('upload_max_filesize', '2M');
ini_set('post_max_size', '2M');

#If the session variable 'message_sent' is set and its value is precisely true
if (isset($_SESSION['message_sent']) && $_SESSION['message_sent'] === true) {
    header("Location: index.php");
    exit;
}

# Create a file in order to remember that some one posted. 
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    # If name if longer than 8 chracters then give error
    $nameLimit = 8; 
    $messageLimit = 250; 
    
    $name = sanitizeInput($_POST['name']);

    if (strlen($name) > $nameLimit) {
        echo "Error: Name exceeds the character limit of $nameLimit.";
        exit;
    }

    $message = sanitizeInput($_POST['message']);

    if (strlen($message) > $messageLimit) {0
        echo "Error: Message exceeds the character limit of $messageLimit.";
        exit;
    }
    
    $time = time();
    $maxFileSize = 2097152; 

    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        # Check if the 'image' file input field is set and there are no errors in the uploaded file
        $image = $_FILES['image']; # Retrieve the uploaded file information
        $imageSize = $image['size']; # Get the size of the uploaded image
        
        if ($imageSize > $maxFileSize) {
            # Check if the size of the uploaded image exceeds the maximum allowed size (2MB)
            echo "Error: File size exceeds the limit of 2MB.";
            exit; 
        }
        
        # Generate the path where the uploaded image will be saved
        $imagePath = 'uploads/' . basename($image['name']);
        # Move the uploaded image from the temporary directory to the specified path
        move_uploaded_file($image['tmp_name'], $imagePath);
    } else {
        # If the 'image' file input field is not set or there are errors in the uploaded file
        # Assign a default image path in case no image is uploaded or an error occurs
        $imagePath = 'default_image.jpg';
    }
    
    $jsonData = file_get_contents('messages.json');
    $data = json_decode($jsonData, true);
    # Decode the JSON string stored in $jsonData into a PHP associative array and store it in $data

    $data[] = [
         # Read the contents of the 'messages.json' file and store it in $jsonData
        'name' => $name,
        'message' => $message,
        'time' => $time,
        'image' => $imagePath 
    ];

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    # Convert the PHP associative array $data into a JSON string, with human-readable formatting, and store it in $jsonData
    file_put_contents('messages.json', $jsonData);
    # Write the JSON data stored in $jsonData to a file named 'messages.json'
    file_put_contents('messages/' . $user_ip . '.txt', '');
    # Create an empty text file in the 'messages' directory with a filename based on the user's IP address

    $_SESSION['message_sent'] = true;
    header("Location: index.php");
    exit;
}

function sanitizeInput($input) {
    $input = strip_tags($input); 
    $input = htmlspecialchars($input);
    
    $badWords = array("nigger", "niger", "n1gger", "bitch", "b1tch", "fuck", "porn", "pornhub", "href", "'https", "neger", "negger", "kut", "fock", "h0mo", "homo", "kanker");
    $input = preg_replace("/\b(nig\w*)\b/i", "***", $input); 
    $input = str_ireplace($badWords, "***", $input); 
    
    $input = preg_replace("/\b(pornhub\w*)\b/i", "***", $input); 
    $input = preg_replace("/\b(https\w*)\b/i", "***", $input); 
    $input = preg_replace("/\b(neg\w*)\b/i", "***", $input); 
    $input = preg_replace("/\b(kut\w*)\b/i", "***", $input); 
    $input = preg_replace("/\b(fock\w*)\b/i", "***", $input); 
    return $input;
}
?>
