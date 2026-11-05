<?php
require __DIR__ . '/include/config.php';

// Het id komt uit de link: details.php?id=3
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$recept = false;
if ($id) {
    $stmt = $conn->prepare("SELECT id, titel, afbeelding, ingredienten, stappen FROM ontkoking WHERE id = ?");
    $stmt->execute([$id]);
    $recept = $stmt->fetch();
}

// Geen of onbekend recept: terug naar de homepagina met een 404
if (!$recept) {
    http_response_code(404);
    exit('Recept niet gevonden. <a href="Homepagina.php">Terug naar de homepagina</a>');
}

// Ingrediënten: één per regel
$ingredienten = preg_split('/\R/', trim($recept['ingredienten']));
$ingredienten = array_filter(array_map('trim', $ingredienten), 'strlen');

// Stappen: blokken gescheiden door een lege regel.
// Eerste regel van een blok = titel, de rest = beschrijving.
$stappen = [];
foreach (preg_split('/\R\s*\R/', trim($recept['stappen'])) as $blok) {
    $regels = preg_split('/\R/', trim($blok), 2);
    if ($regels[0] === '') continue;
    $stappen[] = [
        'titel'        => trim($regels[0]),
        'beschrijving' => trim($regels[1] ?? ''),
    ];
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($recept['titel']) ?></title>
    <link rel="stylesheet" href="../CSS/details.css">
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
                        Invoegen
                    </a>

                    <a href="" class="invoegen">
                        -
                    </a>

                    <a href="inlog.php" class="inloggen">
                        Inloggen
                    </a>
                </li>
            </ul>
        </nav>

    </div>
</header>

<section class="hero-kaan">
    <div class="hero-kaan-img">
        <img src="../IMAGES/<?= htmlspecialchars($recept['afbeelding']) ?>" alt="<?= htmlspecialchars($recept['titel']) ?>">
    </div>

    <div class="hero-kaan-info">
        <h1><?= htmlspecialchars($recept['titel']) ?></h1>
    </div>
</section>

<section class="kaandebanaan">

    <div class="kaan-wrapper">
        <h2>Ingrediënten</h2>
        <div class="column">
            <ul>
                <?php foreach ($ingredienten as $ingredient): ?>
                    <li><?= htmlspecialchars($ingredient) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="kaan-wrapper">
        <h2>bereidingsstappen</h2>

        <?php foreach ($stappen as $nummer => $stap): ?>
            <div class="column step">
                <span class="step-number"><?= sprintf('%02d', $nummer + 1) ?></span>
                <div>
                    <h3><?= htmlspecialchars($stap['titel']) ?></h3>
                    <p><?= nl2br(htmlspecialchars($stap['beschrijving'])) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

</section>

<footer>
    <div class="foot">
        <p>copyright © 2026. All rights reserved.</p>
    </div>
</footer>

</body>
</html>