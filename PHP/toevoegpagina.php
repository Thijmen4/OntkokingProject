
<?php
$conn = mysqli_connect("localhost", "root", "", "ontkoking");

if (!$conn) {
    die("Verbinding met database mislukt");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Gegevens ophalen
    $titel = $_POST["titel"];
    $categorie = $_POST["categorie"];
    $voorbereiding = $_POST["voorbereiding"];
    $bereiding = $_POST["bereiding"];
    $porties = $_POST["porties"];
    $moeilijkheid = $_POST["moeilijkheid"];
    $beschrijving = $_POST["beschrijving"];

    $foto = "";

    if (!empty($_FILES["foto"]["name"])) {

        $map = "../uploads/";

        if (!is_dir($map)) {
            mkdir($map, 0777, true);
        }

        $foto = time() . "_" . basename($_FILES["foto"]["name"]);

        if (!move_uploaded_file($_FILES["foto"]["tmp_name"], $map . $foto)) {
            die("Foto uploaden mislukt");
        }
    }

    $sql = "INSERT INTO recepten
    (titel, categorie, voorbereiding, bereiding, porties, moeilijkheid, beschrijving, foto)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssss",
        $titel,
        $categorie,
        $voorbereiding,
        $bereiding,
        $porties,
        $moeilijkheid,
        $beschrijving,
        $foto
    );

    if (mysqli_stmt_execute($stmt)) {

        $recept_id = mysqli_insert_id($conn);

        if (isset($_POST["ingredient"])) {

            foreach ($_POST["ingredient"] as $i => $ingredient) {

                $hoeveelheid = $_POST["hoeveelheid"][$i];

                if ($ingredient != "") {

                    $sql = "INSERT INTO ingredienten
                    (recept_id, ingredient, hoeveelheid)
                    VALUES (?, ?, ?)";

                    $stmt2 = mysqli_prepare($conn, $sql);

                    mysqli_stmt_bind_param(
                        $stmt2,
                        "iss",
                        $recept_id,
                        $ingredient,
                        $hoeveelheid
                    );

                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_close($stmt2);
                }
            }
        }

        if (isset($_POST["stap"])) {

            foreach ($_POST["stap"] as $i => $stap) {

                if ($stap != "") {

                    $nummer = $i + 1;

                    $sql = "INSERT INTO stappen
                    (recept_id, nummer, beschrijving)
                    VALUES (?, ?, ?)";

                    $stmt3 = mysqli_prepare($conn, $sql);

                    mysqli_stmt_bind_param(
                        $stmt3,
                        "iis",
                        $recept_id,
                        $nummer,
                        $stap
                    );

                    mysqli_stmt_execute($stmt3);
                    mysqli_stmt_close($stmt3);
                }
            }
        }

        mysqli_stmt_close($stmt);

        header("Location: Homepagina.php");
        exit();

    } else {
        echo "Recept opslaan mislukt: " . mysqli_error($conn);
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

                <input type="file"
                       class="photo-input"
                       id="fileInput"
                       name="foto"
                       accept="image/*">

            </div>

            <div class="right-top-side">

                <div class="input-group">
                    <label>Titel</label>
                    <input type="text"
                           name="titel"
                           placeholder="Naam van het recept"
                           required>
                </div>

                <div class="categories-container">

                    <label>Categorie</label>

                    <input type="hidden"
                           name="categorie"
                           id="categorie"
                           value="hoofdgerecht">

                    <div class="category-chips">

                        <div class="chip selected" data-cat="hoofdgerecht">
                            Hoofdgerecht
                        </div>

                        <div class="chip" data-cat="lunch">
                            Lunch
                        </div>

                        <div class="chip" data-cat="ontbijt">
                            Ontbijt
                        </div>

                        <div class="chip" data-cat="voorgerecht">
                            Voorgerecht
                        </div>

                        <div class="chip" data-cat="nagerecht">
                            Nagerecht
                        </div>

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

            <textarea name="beschrijving"
                      placeholder="Waarom is dit recept lekker?"></textarea>

        </div>

        <div class="sections-grid">

            <div>

                <h2>Ingrediënten</h2>

                <div class="card-container" id="ingredientList">

                    <div class="ingredient-row">

                        <input type="text"
                               name="ingredient[]"
                               placeholder="Ingrediënt">

                        <input type="text"
                               name="hoeveelheid[]"
                               placeholder="Hoeveelheid">

                    </div>

                    <button type="button"
                            class="add-row-btn"
                            id="addIngredientBtn">

                        + ingrediënt toevoegen

                    </button>

                </div>

            </div>

            <div>

                <h2>Bereidingsstappen</h2>

                <div class="card-container" id="stepsList">

                    <div class="step-row">

                        <div class="step-number">01</div>

                        <textarea name="stap[]"
                                  placeholder="Beschrijf deze stap..."></textarea>

                    </div>

                    <button type="button"
                            class="add-row-btn"
                            id="addStepBtn">

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

11
