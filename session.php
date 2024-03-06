<?php

session_start();

// Functie om te controleren of er een bericht is ingediend in de huidige sessie
function isMessageSubmitted() {
    return isset($_SESSION['message_submitted']);
// Isset controleert of een variabele is ingesteld en niet null is. 
}

function setMessageSubmitted() {
    $_SESSION['message_submitted'] = true; //geven dat het verzenden van het bericht is voltooid.
}

?>
