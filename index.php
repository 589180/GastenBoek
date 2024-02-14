<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GastenBoek</title>
    <link rel="stylesheet" href="gast.css">
</head>
<body>
    <div class="container">
        <div class="Nav">
            <a href="homegast.html" class="HomeBut1"><img src="home.png"width="70" height="70"></a>
        </div>
        <div class="NavBar"></div>
        <div class="NavBar1"></div>
        <div class="Button3" id="plusButton">
            <div class="plusIcon">+</div>
        </div>
    </div>

    <div class="overlay" id="overlay">
        <div class="overlay-content">
            <span class="closeButton" onclick="closeOverlay()">×</span>
            <h2>Gastenboek Bericht</h2>
            <form>
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>
                <label for="message">Your Message:</label>
                <textarea id="message" name="message" required></textarea>
                <div class="image-upload">
                <label for="image">Optional Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
