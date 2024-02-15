<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $message = $_POST['message'];
    $time = time();

    $jsonData = file_get_contents ('messages.json');

    // zet json data om in een associative array. Aan deze array kunnen wij nieuwe data toevoegen of wijzigen.
    $data = json_decode($jsonData, true);

    // hier voegen wij de data van het nieuwe bericht toe aan de array
    $data[] =[
        'name' => $name,
        'message'=>$message,
        'time'=>$time
    ];

    // encode to json om het weer op te slaan in de json file
    // pretty print zodat het te lezen is
    $jsonData = json_encode($data, JSON_PRETTY_PRINT);

    // methode om het op te slaan naar het bestand
   file_put_contents ('messages.json', $jsonData);

   header("Location: gast.php");
}
