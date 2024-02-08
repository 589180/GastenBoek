
function openOverlay() {
    document.getElementById("overlay").style.display = "flex";
}

function closeOverlay() {
    document.getElementById("overlay").style.display = "none";
}

document.getElementById("plusButton").addEventListener("click", openOverlay);

const imageUpload = document.getElementById("image");
const imageUploadArea = document.querySelector(".image-upload");

