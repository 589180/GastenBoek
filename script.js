function openOverlay() {
    document.querySelector(".overlay").style.display = "flex";
}

function closeOverlay() {
    document.querySelector(".overlay").style.display = "none";
}

document.getElementById("plusButton").addEventListener("click", openOverlay);

function limitTextarea(element) {
    if (element.value.length > 400) {
        element.value = element.value.substring(0, 100);
    }
}