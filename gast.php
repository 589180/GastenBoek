<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GastenBoek</title>
    <link rel="stylesheet" href="gast.css">
</head>
<body>
    <div class="deskContainer">
        <div class="side-nav">
            <div class="header-logo">
                <a href="homegast.html">
                    <img id="nav-logo" src="/uploads/home.png">
                </a>
            </div>
            <div class="bottom-button">
                <a id="click">
                   <div class="Button3" id="plusButton">
                  <div class="plusIcon">+</div>
                </a>

            </div>
          </div>    
        </div>
        <div class="overlay">
            <div class="overlay-content">
                <span class="closeButton" onclick="closeOverlay()">×</span>
                <h2>Gastenboek Bericht</h2>
                <form action="upload.php" method="post" enctype="multipart/form-data">
                    <label for="name">Your Name:</label>
                    <input type="text" id="name" name="name" required>
                    <label for="message">Your Message:</label>
                    <textarea id="message" name="message" required></textarea>
                    <div class="image-upload">
                    <label for="image">Optional Image:</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    </div>
                    <button type="submit" value="Submit">Submit</button> 
                </form>
            </div>
        </div>
    
        <div class="BerichtenBox">
            <?php
                $jsonData = file_get_contents ('messages.json');

                $data = json_decode($jsonData, true);
                
                  ?>

        
            <div class="Bericht">
                <div class="Image">
                <img id="BerichtImg" src="/uploads/random1.png">
                </div>
                <div class="Date">
                    26 Maart 2024 
                </div>
                <div class="Time">
                    14:54 CET
                </div>
                <div class="Message">
                    Lorem ipsum dolor sit amet. Est quia odit eum odio nulla aut internos nesciunt id laborum fugiat et cumque rerum. 
                    Aut officia officiis et facere galisum ut galisum rerum qui veniam consequatur sit recusandae iure et maxime delectus?
                    Est consequatur provident aut aspernatur pariatur non reprehenderit sequi.
                </div>
            </div>
                <div class="Bericht">
                        <div class="Image"></div>
                        <div class="Date"></div>
                        <div class="Time"></div>
                        <div class="Message"></div>
                </div>
                <div class="Bericht"></div>
                <div class="Bericht"></div>
                <div class="Bericht"></div>
                <div class="Bericht"></div>
                <div class="Bericht"></div>
                <div class="Bericht"></div>
                <div class="Bericht"></div>
                <div class="Bericht"></div>
                <div class="Bericht"></div>
                <div class="Bericht"></div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>
