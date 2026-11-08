
<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);


session_start();
require __DIR__ . '/include/config.php';


$filters = $_GET['filters'] ?? [];

$toegestaneFilters = [
        'weinig_calorieen',
        'veel_calorieen',
        'weinig_vezels',
        'veel_vezels',
        'vegan',
        'veel_proteine',
        'weinig_proteine'
];

if (!is_array($filters)) {
    $filters = [];
}

$filters = array_values(array_intersect($filters, $toegestaneFilters));


$sql = "SELECT id, titel, afbeelding FROM ontkoking";

$voorwaarden = [];
$params = [];

if (in_array('weinig_calorieen', $filters)) {
    $voorwaarden[] = "calorieen <= :weinig_calorieen";
    $params['weinig_calorieen'] = 400;
}

if (in_array('veel_calorieen', $filters)) {
    $voorwaarden[] = "calorieen >= :veel_calorieen";
    $params['veel_calorieen'] = 700;
}

if (in_array('weinig_vezels', $filters)) {
    $voorwaarden[] = "vezels <= :weinig_vezels";
    $params['weinig_vezels'] = 5;
}

if (in_array('veel_vezels', $filters)) {
    $voorwaarden[] = "vezels >= :veel_vezels";
    $params['veel_vezels'] = 10;
}

if (in_array('vegan', $filters)) {
    $voorwaarden[] = "vegan = :vegan";
    $params['vegan'] = 1;
}

if (in_array('veel_proteine', $filters)) {
    $voorwaarden[] = "eiwitten >= :veel_proteine";
    $params['veel_proteine'] = 25;
}

if (in_array('weinig_proteine', $filters)) {
    $voorwaarden[] = "eiwitten <= :weinig_proteine";
    $params['weinig_proteine'] = 10;
}


if (!empty($voorwaarden)) {
    $sql .= " WHERE " . implode(" AND ", $voorwaarden);
}

$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$recepten = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alle recepten</title>
    <link rel="stylesheet" href="../CSS/receptenpagina.css?v=3">
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
                        Invoegen
                    </a>

                    <a href="" class="invoegen">
                        -
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

            <form method="GET" action="">
                <div class="filter">

                    <label>Weinig calorieën
                        <input type="checkbox" name="filters[]" value="weinig_calorieen"
                                <?= in_array('weinig_calorieen', $filters) ? 'checked' : '' ?>>
                    </label>

                    <label>Veel calorieën
                        <input type="checkbox" name="filters[]" value="veel_calorieen"
                                <?= in_array('veel_calorieen', $filters) ? 'checked' : '' ?>>
                    </label>

                    <label>Weinig vezels
                        <input type="checkbox" name="filters[]" value="weinig_vezels"
                                <?= in_array('weinig_vezels', $filters) ? 'checked' : '' ?>>
                    </label>

                    <label>Veel vezels
                        <input type="checkbox" name="filters[]" value="veel_vezels"
                                <?= in_array('veel_vezels', $filters) ? 'checked' : '' ?>>
                    </label>

                    <label>Vegan
                        <input type="checkbox" name="filters[]" value="vegan"
                                <?= in_array('vegan', $filters) ? 'checked' : '' ?>>
                    </label>

                    <label>Veel proteine
                        <input type="checkbox" name="filters[]" value="veel_proteine"
                                <?= in_array('veel_proteine', $filters) ? 'checked' : '' ?>>
                    </label>

                    <label>Weinig proteine
                        <input type="checkbox" name="filters[]" value="weinig_proteine"
                                <?= in_array('weinig_proteine', $filters) ? 'checked' : '' ?>>
                    </label>

                </div>

                <button type="submit">Filters toepassen</button>
                <a href="Receptenpagina.php">Filters wissen</a>

            </form>
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
