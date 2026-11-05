<?php
$fouten = [];
$gebruikersnaam = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam = trim($_POST['gebruikersnaam'] ?? '');
    $wachtwoord     = $_POST['wachtwoord'] ?? '';

    if ($gebruikersnaam === '') $fouten[] = 'Vul je gebruikersnaam in.';
    if ($wachtwoord === '')     $fouten[] = 'Vul je wachtwoord in.';

    if (!$fouten) {
        // TODO: als de tabel met gebruikers klaar is:
        //   require __DIR__ . '/include/config.php';
        //   gebruiker ophalen met een prepared statement (WHERE gebruikersnaam = ?)
        //   wachtwoord controleren met password_verify($wachtwoord, $gebruiker['wachtwoord'])
        //   session_start(); $_SESSION['gebruiker_id'] = ...; header('Location: Homepagina.php'); exit;
        $fouten[] = 'Inloggen is nog niet gekoppeld aan de database.';
    }
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
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
                    <a href="inlog.php" class="inloggen">Inloggen</a>
                </li>
            </ul>

            <div class="duck-walker"></div>
        </nav>

    </div>
</header>

<div class="backgroundimg"></div>


<main>
    <div class="form-container">
        <h2>Inloggen</h2>

        <?php foreach ($fouten as $fout): ?>
            <p class="form-fout"><?= htmlspecialchars($fout) ?></p>
        <?php endforeach; ?>

        <form action="inlog.php" method="POST">
            <div class="form-group">
                <label for="gebruikersnaam">Gebruikersnaam</label>
                <input type="text" id="gebruikersnaam" name="gebruikersnaam"
                       placeholder="Vul je gebruikersnaam in"
                       value="<?= htmlspecialchars($gebruikersnaam) ?>" required>
            </div>

            <div class="form-group">
                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" id="wachtwoord" name="wachtwoord"
                       placeholder="Vul je wachtwoord in" required>
            </div>

            <button type="submit" class="btn-submit">Inloggen</button>
        </form>

        <p class="form-footer">
            Nog geen account? <a href="registreer.php">Registreer hier</a>
        </p>
    </div>
</main>

<footer>
    <div class="foot">
        <p>copyright © 2026. All rights reserved.</p>
    </div>
</footer>

</body>
</html>