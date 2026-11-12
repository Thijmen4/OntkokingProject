
<?php
require __DIR__ . '/include/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titel = $_POST["titel"];
    $categorie = $_POST["categorie"];
    $ingredienten = [];
    $stappen = [];

    if (isset($_POST["ingredient"])) {
        foreach ($_POST["ingredient"] as $i => $ingredient) {
            $hoeveelheid = $_POST["hoeveelheid"][$i] ?? "";

            if (trim($ingredient) != "") {
                $ingredienten[] = trim($hoeveelheid . " " . $ingredient);
            }
        }
    }

    if (isset($_POST["stap"])) {
        foreach ($_POST["stap"] as $i => $stap) {
            if (trim($stap) != "") {
                $nummer = count($stappen) + 1;
                $stappen[] = $nummer . ". " . trim($stap);
            }
        }
    }

    $ingredienten = implode("\n", $ingredienten);
    $stappen = implode("\n", $stappen);

    $foto = "";

    if (!empty($_FILES["foto"]["name"])) {
        $map = __DIR__ . "/../uploads/";

        if (!is_dir($map)) {
            mkdir($map, 0777, true);
        }

        $extensie = pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION);
        $foto = uniqid() . "." . $extensie;

        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $map . $foto)) {
            die("Foto uploaden mislukt");
        }
    }

    $sql = "INSERT INTO ontkoking
    (titel, afbeelding, ingredienten, stappen, categorie)
    VALUES (:titel, :afbeelding, :ingredienten, :stappen, :categorie)";

    $stmt = $conn->prepare($sql);

    if ($stmt->execute([
            'titel' => $titel,
            'afbeelding' => $foto,
            'ingredienten' => $ingredienten,
            'stappen' => $stappen,
            'categorie' => $categorie
    ])) {
        header("Location: Homepagina.php");
        exit();
    } else {
        echo "Recept opslaan mislukt.";
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duck & Dish - Recept toevoegen</title>
    <link rel="stylesheet" href="../CSS/toevoegpagina.css">
</head>
<body>
<div class="top-search-container">
    <div class="search-wrapper">
        <input type="text" placeholder="Zoek recepten...">
    </div>
</div>
<div class="container">
    <a href="Homepagina.php" class="back-link">
        &lsaquo; Terug naar recepten
    </a>
    <h1>Recept toevoegen</h1>
    <form id="recipeForm" method="POST" enctype="multipart/form-data">
        <div class="form-grid-top">
            <div class="photo-upload" id="photoUploadBox">
                <span>Voeg foto toe</span>
                <img id="imagePreview" alt="">
                <input type="file" class="photo-input" id="fileInput" name="foto" accept="image/*">
            </div>
            <div class="right-top-side">
                <div class="input-group">
                    <label>Titel</label>
                    <input type="text" name="titel" placeholder="Naam van het recept" required>
                </div>
                <div class="categories-container">
                    <label>Categorie</label>
                    <input type="hidden" name="categorie" id="categorie" value="Avondeten">
                    <div class="category-chips">
                        <div class="chip selected" data-cat="Avondeten">Avondeten</div>
                        <div class="chip" data-cat="Lunch">Lunch</div>
                        <div class="chip" data-cat="Ontbijt">Ontbijt</div>
                    </div>
                </div>
                <div class="meta-grid">
                    <div class="input-group">
                        <label>Voorbereiding</label>
                        <input type="text" name="voorbereiding" placeholder="10 min">
                    </div>
                    <div class="input-group">
                        <label>Bereiding</label>
                        <input type="text" name="bereiding" placeholder="15 min">
                    </div>
                    <div class="input-group">
                        <label>Porties</label>
                        <input type="text" name="porties" placeholder="2 porties">
                    </div>
                    <div class="input-group">
                        <label>Moeilijkheid</label>
                        <input type="text" name="moeilijkheid" placeholder="Makkelijk">
                    </div>
                </div>
            </div>
        </div>
        <div class="input-group description-box">
            <label>Korte beschrijving</label>
            <textarea name="beschrijving" placeholder="Waarom is dit recept lekker?"></textarea>
        </div>
        <div class="sections-grid">
            <div>
                <h2>Ingrediënten</h2>
                <div class="card-container" id="ingredientList">
                    <div class="ingredient-row">
                        <input type="text" name="ingredient[]" placeholder="Ingrediënt">
                        <input type="text" name="hoeveelheid[]" placeholder="Hoeveelheid">
                    </div>
                    <button type="button" class="add-row-btn" id="addIngredientBtn">
                        + ingrediënt toevoegen
                    </button>
                </div>
            </div>
            <div>
                <h2>Bereidingsstappen</h2>
                <div class="card-container" id="stepsList">
                    <div class="step-row">
                        <div class="step-number">01</div>
                        <textarea name="stap[]" placeholder="Beschrijf deze stap..."></textarea>
                    </div>
                    <button type="button" class="add-row-btn" id="addStepBtn">
                        + stap toevoegen
                    </button>
                </div>
            </div>
        </div>
        <div class="submit-container">
            <button type="submit" class="save-btn">
                Recept opslaan
            </button>
        </div>
    </form>
</div>
<script src="../JS/toevoegpagina.js"></script>
</body>
</html>
