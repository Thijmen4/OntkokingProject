<?php
require __DIR__ . '/include/config.php';

$stmt = $conn->prepare("SELECT id, titel, afbeelding FROM ontkoking ORDER BY id DESC LIMIT 4");
$stmt->execute();
$recepten = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>De homepagina</title>
    <link rel="stylesheet" href="../CSS/Homepagina.css">
    <script defer src="../JS/Homepagina.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/SplitText.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/TextPlugin.min.js"></script>

</head>
<body>


<header>
    <div class="navbar">

        <a href="Homepagina.html" class="home-logo">
            <img class="home-link" src="../IMAGES/Duck & Dish Chef Logo.png" alt="">
        </a>

        <input type="search" placeholder="🔍 Zoeken..." class="zoeken">

        <nav>
            <ul>
                <li>
                    <a href="../HTML/toevoegpagina.html" class="invoegen">
                        Invoegen
                    </a>

                    <a href="" class="invoegen">
                        -
                    </a>

                    <a href="../HTML/inlog.html" class="inloggen">
                        Inloggen
                    </a>
                </li>
            </ul>

            <div class="duck-walker"></div>

        </nav>

    </div>
</header>


<div class="categorien">
    <button class="ontbijt">Ontbijt</button>
    <button class="lunch">Lunch</button>
    <button class="avondeten">Avondeten</button>
</div>

<div class="backgroundimg">
    <img src="" alt="">
</div>





<main>
    <div class="hero">
        <div class="hero_tekst">
            <div class="hero_titel">
                <h1>Welkom op Duck & dish</h1>
            </div>
            <div class="hero_quote">
                <p>Op deze website kunt u alle kook tips en recepten vinden.</p>
            </div>
            <div class="hero_buttons">
                <a href="receptenpagina.php">
                    <button class="alle_recepten">Alle recepten</button></a>
            </div>
            <div class="hero_img"></div>
        </div>

    </div>

    <div class="gehele_box">

        <section class="populair">

            <div class="populair_box">
                <div class="populair_titel">
                    <span class="populair_fav">ONZE FAVORIETEN</span>
                    <h2>Populaire recepten</h2>
                    <p>Ontdek wat anderen graag op tafel zetten.</p>
                </div>
            </div>

            <div class="recepten_box">

                <div class="recepten">
                    <img src="../IMAGES/gezond eten img.jpeg" alt="">
                    <h2>Recept 1</h2>
                    <p>Hier staat de beschrijving.</p>
                </div>

                <div class="recepten">
                    <img src="../IMAGES/gezond eten img.jpeg" alt="">
                    <h2>Recept 2</h2>
                    <p>Hier staat de beschrijving.</p>
                </div>

                <div class="recepten">
                    <img src="../IMAGES/gezond eten img.jpeg" alt="">
                    <h2>Recept 3</h2>
                    <p>Hier staat de beschrijving.</p>
                </div>

                <div class="recepten">
                    <img src="../IMAGES/gezond eten img.jpeg" alt="">
                    <h2>Recept 4</h2>
                    <p>Hier staat de beschrijving.</p>
                </div>
            </div>
        </section>


        <section class="gezond">

            <div class="gezond_box">
                <div class="gezond_titel">
                    <span class="gezond_fav">MEEST GEZONDEN GERECHTEN</span>
                    <h2>Gezonde recepten</h2>
                    <p>Ontdek wat gezonde en smaakvolle gerechten die jekunt maken.</p>
                </div>
            </div>
            <div class="recepten_box">

                <div class="recepten">
                    <img src="../IMAGES/gezond eten img.jpeg" alt="">
                    <h2>Recept 1</h2>
                    <p>Hier staat de beschrijving.</p>
                </div>

                <div class="recepten">
                    <img src="../IMAGES/gezond eten img.jpeg" alt="">
                    <h2>Recept 2</h2>
                    <p>Hier staat de beschrijving.</p>
                </div>

                <div class="recepten">
                    <img src="../IMAGES/gezond eten img.jpeg" alt="">
                    <h2>Recept 3</h2>
                    <p>Hier staat de beschrijving.</p>
                </div>

                <div class="recepten">
                    <img src="../IMAGES/gezond eten img.jpeg" alt="">
                    <h2>Recept 4</h2>
                    <p>Hier staat de beschrijving.</p>
                </div>
            </div>
        </section>

    </div>
</main>

<footer>
    <div class="foot">
        <p>copyright © 2026. All rights reserved.</p>
    </div>
</footer>

</body>
</html>