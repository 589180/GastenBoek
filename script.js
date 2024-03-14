function openOverlay() {
        // Zorgt ervoor dat de overlat (Formulier open zodat je deze kan zien)
    document.querySelector(".overlay").style.display = "flex";
}

function closeOverlay() {
    // Verbergt weergave 
    document.querySelector(".overlay").style.display = "none";
}


// Eventlistener toevoegen aan het element met de id "plusButton", zodat wanneer erop wordt geklikt, de overlay wordt geopend
document.getElementById("plusButton").addEventListener("click", openOverlay);

document.getElementById('upload-form').addEventListener('submit', function(event) {
    var fileInput = document.getElementById('image');
    var file = fileInput.files[0];
    if (file && file.size > 2097152) { // Check file size (2MB)
        var errorMessage = document.getElementById('image-error');
        errorMessage.textContent = 'Error: File size exceeds the limit of 2MB.';
        event.preventDefault(); // Prevent form submission
    }
});
