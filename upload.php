<?php
session_start();

// Santize zorgt ervoor dat ongelidge tekens worden verwijderd. 
function sanitizeInput($input) {
    // Verwijdert HTML- en PHP-tags uit de invoer
    $input = strip_tags($input); 
    // Voorkomt dat HTML-code wordt uitgevoerd bij het weergeven van gebruikersinvoer.
    $input = htmlspecialchars($input);
    // Geeft de gesaneerde invoer terug voor verdere verwerking in de applicatie.
    return $input;
}

if (isset($_SESSION['message_sent']) && $_SESSION['message_sent'] === true) {
    // Controleert of de sessievariabele 'message_sent' 
    // is ingesteld en of deze de waarde true heeft

    header("Location: index.php");
    // Als 'message_sent' al true is (wat betekent dat het bericht al is verzonden), 
    // wordt de gebruiker teruggestuurd naar de indexpagina.

    exit;
    // Stop de verdere uitvoering van de code om te voorkomen dat andere 
    // instructies na deze worden uitgevoerd,
    // aangezien de gebruiker al wordt omgeleid.
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Controleert of het verzoeksmethode POST is, wat betekent dat er gegevens zijn verzonden vanuit een formulier.

    $user_ip = $_SERVER['REMOTE_ADDR'];
    // Haalt het IP-adres van de gebruiker op van $_SERVER superglobale variabele.
    // $_SERVER['REMOTE_ADDR'] bevat het IP-adres van de gebruiker die het verzoek heeft ingediend.

    if (file_exists('messages/' . $user_ip . '.txt')) {
        // Controleert of er al een bestand bestaat met de naam 'messages/{user_ip}.txt'.
        // Dit wordt gebruikt om te bepalen of het IP-adres van de gebruiker al een bericht heeft verzonden.

        // Als het bestand al bestaat (wat betekent dat het IP-adres al een bericht heeft verzonden),
        // wordt de gebruiker onmiddellijk omgeleid naar de indexpagina.
        header("Location: index.php");

        // Stopt de verdere uitvoering van de code om te voorkomen dat er extra acties worden ondernomen nadat de gebruiker is omgeleid.
        exit;
    }

    $name = sanitizeInput($_POST['name']);
    // Haalt de waarde van de formuliervariabele 'name' op via POST,
    // sanitizeInput() wordt gebruikt om de invoer te saniteren.

    $message = sanitizeInput($_POST['message']);
    // Haalt de waarde van de formuliervariabele 'message' op via POST,
    // sanitizeInput() wordt gebruikt om de invoer te saniteren.

    $time = time();
    // Genereert een tijdstempel voor het verzonden bericht.


    $image = $_FILES['image'];
    // Haalt de geüploade bestandsgegevens op van het 'image' bestandsveld van het formulier.
    // Deze gegevens bevatten informatie zoals bestandsnaam, type, tijdelijke locatie op de server, etc.
    
    $imagePath = 'uploads/' . basename($image['name']);
    // Bepaalt het pad waar het geüploade bestand zal worden opgeslagen.
    // Hier wordt het pad ingesteld als 'uploads/' (een map op de server) plus de basennaam van het geüploade bestand.

    move_uploaded_file($image['tmp_name'], $imagePath);
    // Verplaatst het geüploade bestand van de tijdelijke locatie naar de definitieve locatie.


    $jsonData = file_get_contents('messages.json');
    // Leest de inhoud van 'messages.json' en slaat deze op in $jsonData.

    $data = json_decode($jsonData, true);
    // Decodeert $jsonData van JSON naar een PHP-array en slaat het op in $data.


    $data[] = [
        'name' => $name,
        'message' => $message,
        'time' => $time,
        'image' => $imagePath 
    ];
    // Voegt een nieuw element toe aan de array $data met de gegeven 'name', 'message', 'time', en 'image' waarden.
    

    $jsonData = json_encode($data, JSON_PRETTY_PRINT);
    // Encodeert $data naar JSON en behoudt opmaak.

    file_put_contents('messages.json', $jsonData);
    // Schrijft de JSON-gegevens naar 'messages.json'.

    file_put_contents('messages/' . $user_ip . '.txt', '');
    // Creëert een leeg bestand om te markeren dat een bericht is verzonden vanaf het IP-adres van de gebruiker.

    $_SESSION['message_sent'] = true;
    // Markeert dat er een bericht is verzonden in deze sessie.

    header("Location: index.php");
    // Stuurt de gebruiker door naar de indexpagina.

    exit;
    // Stopt de verdere uitvoering van de PHP-code na het omleiden van de gebruiker.

}
?>
