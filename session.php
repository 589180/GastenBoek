<?php
// Start the session
session_start();

// Function to check if a message has been submitted in this session
function isMessageSubmitted() {
    return isset($_SESSION['message_submitted']);
}

// Function to set the message submitted flag in the session
function setMessageSubmitted() {
    $_SESSION['message_submitted'] = true;
}
?>
