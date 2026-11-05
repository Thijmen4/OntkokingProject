<?php
require __DIR__ . '/include/config.php';

$fouten = [];
$naam  = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $naam       = trim($_POST['naam'] ?? '');
    $email      = trim($_POST['email'] ?? '');
    $wachtwoord = $_POST['wachtwoord'] ?? '';

    if ($naam === '' || strlen($naam) > 50)         $fouten[] = 'Kies een gebruikersnaam van maximaal 50 tekens.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $fouten[] = 'Vul een geldig e-mailadres in.';
    if (strlen($wachtwoord) < 8)                    $fouten[] = 'Je wachtwoord moet minimaal 8 tekens hebben.';

    if (!$fouten) {
        // Bestaat de gebruikersnaam of het e-mailadres al?
        $stmt = $conn->prepare("SELECT id FROM gebruikers WHERE gebruikersnaam = ? OR email = ?");
        $stmt->execute([$naam, $email]);

        if ($stmt->fetch()) {
            $fouten[] = 'Deze gebruikersnaam of dit e-mailadres is al in gebruik.';
        } else {
            // Alleen de versleutelde versie van het wachtwoord opslaan
            $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO gebruikers (gebruikersnaam, email, wachtwoord) VALUES (?, ?, ?)");
            $stmt->execute([$naam, $email, $hash]);

            header('Location: inlog.php?geregistreerd=1');
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreren</title>
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
        <h2>Account aanmaken</h2>

        <?php foreach ($fouten as $fout): ?>
            <p class="form-fout"><?= htmlspecialchars($fout) ?></p>
        <?php endforeach; ?>

        <form action="registreer.php" method="POST">
            <div class="form-group">
                <label for="naam">Gebruikersnaam</label>
                <input type="text" id="naam" name="naam" placeholder="Kies een gebruikersnaam"
                       value="<?= htmlspecialchars($naam) ?>" required>
            </div>

            <div class="form-group">
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" placeholder="Vul je e-mailadres in"
                       value="<?= htmlspecialchars($email) ?>" required>
            </div>

            <div class="form-group">
                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" id="wachtwoord" name="wachtwoord"
                       placeholder="Minimaal 8 tekens" minlength="8" required>
            </div>

            <button type="submit" class="btn-submit">Registreer</button>
        </form>

        <p class="form-footer">
            Al een account? <a href="inlog.php">Log hier in</a>
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