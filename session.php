<?php

session_start();

// Functie om te controleren of er een bericht is ingediend in de huidige sessie
function isMessageSubmitted() {
    return isset($_SESSION['message_submitted']); // Controleer of de sessievariabele 'message_submitted' is ingesteld
}

// Functie om de vlag in te stellen die aangeeft dat er een bericht is ingediend in de huidige sessie
function setMessageSubmitted() {
    $_SESSION['message_submitted'] = true; // Stel de sessievariabele 'message_submitted' in op true
}

?>
