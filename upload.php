<?php
session_start();

function sanitizeInput($input) {
    $input = strip_tags($input); 
    $input = htmlspecialchars($input);
    return $input;
    // Zorgt ervoor dat er geen code in the forum kan worden geinject 
}

if (isset($_SESSION['message_sent']) && $_SESSION['message_sent'] === true) {
    // Controleert of de sessievariabele 'message_sent' is ingesteld en of deze 'true' is.
    // Als 'message_sent' al true is, betekent dit dat het bericht al is verzonden.
    // Verder uitvoeren van code wordt voorkomen om te voorkomen dat hetzelfde bericht meerdere keren wordt verzonden.


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
        // Als het bestand al bestaat (wat betekent dat het IP-adres al een bericht heeft verzonden),
        // wordt de gebruiker omgeleid naar de indexpagina.

        exit;
    }
    
    // gegevens op te halen die zijn verzonden via een POST-verzoek.
    $name = sanitizeInput($_POST['name']);
    $message = sanitizeInput($_POST['message']);
    $time = time();


    $image = $_FILES['image'];
    // Haalt de informatie van het geüploade bestand op uit de $_FILES array en wijst deze toe aan de variabele $image.
    $imagePath = 'uploads/' . basename($image['name']);
    // Creëert het pad waar het geüploade bestand zal worden opgeslagen. De map 'uploads/' wordt gebruikt om alle geüploade bestanden te bewaren. De bestandsnaam wordt verkregen met behulp van basename()
    move_uploaded_file($image['tmp_name'], $imagePath);
    // Verplaatst het geüploade bestand van de tijdelijke locatie (aangegeven door $_FILES['image']['tmp_name']) naar de definitieve locatie (bepaald door $imagePath). Dit zorgt ervoor dat het geüploade bestand permanent wordt opgeslagen op de server.


    $jsonData = file_get_contents('messages.json');
    $data = json_decode($jsonData, true);
    // Decodes the JSON string into a PHP associative array

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
