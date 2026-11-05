<?php
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorieten</title>
    <link rel="stylesheet" href="../CSS/form.css">
</head>
<body>

<header>
    <div class="navbar">

        <a href="Homepagina.php" class="home-logo">
            <img class="home-link" src="../IMAGES/Duck & Dish Chef Logo.png" alt="Duck & Dish">
        </a>

        <input type="search" placeholder="🔍 Zoeken..." class="zoeken">

        <nav>
            <ul>
                <li>
                    <a href="../HTML/toevoegpagina.html" class="invoegen">Invoegen</a>
                    <a href="#" class="invoegen">-</a>
                    <?php if (isset($_SESSION['gebruikersnaam'])): ?>
                        <details class="account">
                            <summary><?= htmlspecialchars($_SESSION['gebruikersnaam']) ?></summary>
                            <div class="account-menu">
                                <a href="favorieten.php">Favorieten</a>
                                <a href="Homepagina.php?uitloggen=1">Uitloggen</a>
                            </div>
                        </details>
                    <?php else: ?>
                        <a href="inlog.php" class="inloggen">Inloggen</a>
                    <?php endif; ?>
                </li>
            </ul>

            <div class="duck-walker"></div>
        </nav>

    </div>
</header>

<div class="backgroundimg"></div>


<main>
    <div class="form-container">
        <h2>Mijn favorieten</h2>

        <?php if (!isset($_SESSION['gebruiker_id'])): ?>
            <p class="form-footer">Je moet <a href="inlog.php">inloggen</a> om je favorieten te zien.</p>
        <?php else: ?>
            <p class="form-footer">Hier komen straks de recepten die je hebt opgeslagen.</p>
        <?php endif; ?>
    </div>
</main>

<footer>
    <div class="foot">
        <p>copyright © 2026. All rights reserved.</p>
    </div>
</footer>

</body>
</html>