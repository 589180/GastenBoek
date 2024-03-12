<?php
session_start();

function sanitizeInput($input) {
    $input = strip_tags($input); 
    $input = htmlspecialchars($input);
    return $input;
    // Zorgt ervoor dat er geen code in the forum kan worden geinject 
}

if (isset($_SESSION['message_sent']) && $_SESSION['message_sent'] === true) {
   // && operator combineert twee voorwaarden
   // Isset in PHP controleert of een variabele is ingesteld en niet null is. 
   // Het retourneert true als de variabele is ingesteld en niet null is

    header("Location: index.php");
    exit;
    // Herlaad de pagina index.php
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controleert of het huidige verzoek een POST-verzoek is.
    // REQUEST METHOD: Controleren hoe gegevens zijn verzonden vanaf een webpagina
    $user_ip = $_SERVER['REMOTE_ADDR'];
    // Haalt het IP-adres op van de gebruiker die het verzoek heeft ingediend.
    //REMOTE_ADDR: bevat het IP-adres van de huidige client


    if (file_exists('messages/' . $user_ip . '.txt')) {
        // Controleert of er al een bestand bestaat met de naam '{user_ip}.txt' in de map 'messages/'.
        
        header("Location: index.php");
        // Als het bestand al bestaad wordt de gebruiker omgeleid naar index.php

        exit;
    }
    
    // gegevens op te halen die zijn verzonden via een POST-verzoek.
    $name = sanitizeInput($_POST['name']);
    $message = sanitizeInput($_POST['message']);
    $time = time();


    $image = $_FILES['image'];
   
    $imagePath = 'uploads/' . basename($image['name']);

    move_uploaded_file($image['tmp_name'], $imagePath);
 
    $jsonData = file_get_contents('messages.json');
    // Decode the JSON content into a PHP associative array
    $data = json_decode($jsonData, true);


    $data[] = [
        'name' => $name,
        'message' => $message,
        'time' => $time,
        'image' => $imagePath 
    ];
// Voegt een nieuwe associatieve array toe aan de $data

$jsonData = json_encode($data, JSON_PRETTY_PRINT);
// De bijgewerkte berichtgegevens worden geconverteerd naar JSON-formaat en netjes geformatteerd.
file_put_contents('messages.json', $jsonData);
// De JSON-gegevens worden opgeslagen in het bestand 'messages.json'.
file_put_contents('messages/' . $user_ip . '.txt', '');
// Er wordt een leeg tekstbestand gemaakt om aan te geven dat een bericht vanaf dit IP-adres is verzonden.


    $_SESSION['message_sent'] = true;
    header("Location: index.php");
    exit;
    // Als bericht is gestuurd herlaad dan index.php
}
?>
