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
