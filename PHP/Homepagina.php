<?php

session_start();

if (isset($_GET['uitloggen'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: Homepagina.php');
    exit;
}

require __DIR__ . '/include/config.php';

$categorie = $_GET['categorie'] ?? '';

$categorien = ['Ontbijt', 'Lunch', 'Avondeten'];

if (!in_array($categorie, $categorien, true)) {
    $categorie = '';
}

$sql = "SELECT id, titel, afbeelding FROM ontkoking";
$params = [];

if ($categorie !== '') {
    $sql .= " WHERE categorie = :categorie";
    $params['categorie'] = $categorie;
}

$sql .= " ORDER BY id DESC LIMIT 4";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$recepten = $stmt->fetchAll();

$sqlGezond = "SELECT id, titel, afbeelding, calorieen FROM ontkoking
              WHERE calorieen IS NOT NULL";

$paramsGezond = [];

if ($categorie !== '') {
    $sqlGezond .= " AND categorie = :categorie";
    $paramsGezond['categorie'] = $categorie;
}

$sqlGezond .= " ORDER BY calorieen ASC LIMIT 4";

$stmtGezond = $conn->prepare($sqlGezond);
$stmtGezond->execute($paramsGezond);
$gezondeRecepten = $stmtGezond->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>De homepagina</title>
    <link rel="stylesheet" href="../CSS/Homepagina.css?v=3">
    <script defer src="../JS/Homepagina.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/ScrollTrigger.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/SplitText.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.15/dist/TextPlugin.min.js"></script>

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
                    <a href="../PHP/toevoegpagina.php" class="invoegen">Invoegen</a>
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

<div class="categorien">
    <button class="ontbijt" onclick="window.location.href='Homepagina.php?categorie=Ontbijt'">Ontbijt</button>
    <button class="lunch" onclick="window.location.href='Homepagina.php?categorie=Lunch'">Lunch</button>
    <button class="avondeten" onclick="window.location.href='Homepagina.php?categorie=Avondeten'">Avondeten</button>
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

                <?php if (!$recepten): ?>
                    <p>Er zijn nog geen recepten.</p>
                <?php endif; ?>

                <?php foreach ($recepten as $recept): ?>
                    <a class="recepten" href="details.php?id=<?= (int)$recept['id'] ?>">
                        <img src="../uploads/<?= htmlspecialchars($recept['afbeelding']) ?>" alt="">
                        <h2><?= htmlspecialchars($recept['titel']) ?></h2>
                    </a>
                <?php endforeach; ?>

            </div>
        </section>


        <section class="gezond">

            <div class="gezond_box">
                <div class="gezond_titel">
                    <span class="gezond_fav">MEEST GEZONDEN GERECHTEN</span>
                    <h2>Gezonde recepten</h2>
                    <p>Ontdek wat gezonde en smaakvolle gerechten die je kunt maken.</p>
                </div>
            </div>
            <div class="recepten_box">


                <?php if (!$gezondeRecepten): ?>
                    <p>Er zijn nog geen gezonde recepten beschikbaar.</p>
                <?php endif; ?>

                <?php foreach ($gezondeRecepten as $recept): ?>
                    <a class="recepten" href="details.php?id=<?= (int)$recept['id'] ?>">
                        <img src="../uploads/<?= htmlspecialchars($recept['afbeelding']) ?>" alt="">
                        <h2><?= htmlspecialchars($recept['titel']) ?></h2>
                        <p><?= (int)$recept['calorieen'] ?> kcal</p>
                    </a>
                <?php endforeach; ?>

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