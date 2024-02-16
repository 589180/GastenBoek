<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $message = $_POST['message'];
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

    header("Location: gast.php");
    exit(); // Ensure script stops execution after redirection
}
?>
