<?php
session_start();
require __DIR__ . '/include/config.php';

// Alle recepten ophalen, nieuwste eerst
$stmt = $conn->prepare("SELECT id, titel, afbeelding FROM ontkoking ORDER BY id DESC");
$stmt->execute();
$recepten = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle recepten</title>
    <link rel="stylesheet" href="../CSS/receptenpagina.css">
    <script defer src="../JS/receptenpagina.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/SplitText.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/TextPlugin.min.js"></script>

</head>
<body>


<header>
    <div class="navbar">

        <a href="Homepagina.php" class="home-logo">
            <img class="home-link" src="../IMAGES/Duck & Dish Chef Logo.png" alt="">
        </a>

        <input type="search" placeholder="🔍 Zoeken..." class="zoeken">

        <nav>
            <ul>
                <li>
                    <a href="../HTML/toevoegpagina.html" class="invoegen">
                        Invoegen -
                    </a>
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
    <div class="pagina">
        <div class="sidemenu">
            <h3>Filters</h3>

            <div class="filter">
                <label>Weinig calorieën<input type="checkbox"></label>
                <label>Veel calorieën<input type="checkbox"></label>
                <label>Weinig vezels<input type="checkbox"></label>
                <label>Veel vezels<input type="checkbox"></label>
                <label>Vegan<input type="checkbox"></label>
                <label>Veel proteine<input type="checkbox"></label>
                <label>Weinig proteine<input type="checkbox"></label>
            </div>
        </div>


        <div class="recepten_box">
            <?php if (!$recepten): ?>
                <p>Er zijn nog geen recepten.</p>
            <?php endif; ?>

            <?php foreach ($recepten as $recept): ?>
                <a class="recepten" href="details.php?id=<?= (int)$recept['id'] ?>">
                    <img src="../IMAGES/<?= htmlspecialchars($recept['afbeelding']) ?>" alt="">
                    <h2><?= htmlspecialchars($recept['titel']) ?></h2>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</main>


<footer>
    <div class="foot">
        <p>copyright © 2026. All rights reserved.</p>
    </div>
</footer>

</body>
</html>