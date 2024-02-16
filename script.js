function openOverlay() {
    document.querySelector(".overlay").style.display = "flex";
}

function closeOverlay() {
    document.querySelector(".overlay").style.display = "none";
}

document.getElementById("plusButton").addEventListener("click", openOverlay);

