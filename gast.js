// Function to open the overlay
function openOverlay() {
    document.getElementById("overlay").style.display = "flex";
}

// Function to close the overlay
function closeOverlay() {
    document.getElementById("overlay").style.display = "none";
}

// Open the overlay automatically when the page loads
window.addEventListener("load", function() {
    openOverlay(); // Call the openOverlay function
});

// Allow drag and drop for image upload
const imageUpload = document.getElementById("image");
const imageUploadArea = document.querySelector(".image-upload");

imageUploadArea.addEventListener("dragover", function(e) {
    e.preventDefault();
    this.classList.add("dragover");
});

imageUploadArea.addEventListener("dragleave", function() {
    this.classList.remove("dragover");
});

imageUploadArea.addEventListener("drop", function(e) {
    e.preventDefault();
    this.classList.remove("dragover");
    const file = e.dataTransfer.files[0];
    if (file.type.startsWith("image/")) {
        imageUpload.files = e.dataTransfer.files;
    }
});
