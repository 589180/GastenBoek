// Function to open the overlay
function openOverlay() {
    document.getElementById("overlay").style.display = "flex";
}

// Function to close the overlay
function closeOverlay() {
    document.getElementById("overlay").style.display = "none";
}

// Event listener to open the overlay when the "Bericht Sturen" button is clicked
document.getElementById("openOverlayButton").addEventListener("click", function(event) {
    event.preventDefault(); // Prevent default link behavior
    openOverlay(); // Call the openOverlay function
});
