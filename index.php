<?php
require 'db.php';


$categorie_id = isset($_GET['categorie']) ? $_GET['categorie'] : null;
$sortare = isset($_GET['sort']) ? $_GET['sort'] : 'default';


switch ($sortare) {
    case 'pret_asc':
        $sql_order = "ORDER BY pret ASC"; // Ieftin -> Scump
        break;
    case 'pret_desc':
        $sql_order = "ORDER BY pret DESC"; // Scump -> Ieftin
        break;
    case 'nume_asc':
        $sql_order = "ORDER BY nume ASC"; // A -> Z
        break;
    default:
        $sql_order = "ORDER BY id DESC"; // Cele mai noi primele (Default)
        break;
}


if ($categorie_id && $categorie_id != "") {
    // Cazul: Avem Categorie + Sortare
    $sql = "SELECT * FROM produse WHERE categorie_id = :cat_id $sql_order";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['cat_id' => $categorie_id]);
} else {
    $sql = "SELECT * FROM produse $sql_order";
    $stmt = $pdo->query($sql);
}

$produse = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Magazin Online</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <header>
        <div>
            <h1>🛍️ Magazinul Meu</h1>
            <?php if(isset($_SESSION['nume'])): ?>
                <small>Salut, <strong><?= htmlspecialchars($_SESSION['nume']) ?></strong>!</small>
            <?php endif; ?>
        </div>

        <div>
            <a href="index.php" class="btn">Acasă</a>
            <a href="cos.php" class="btn">🛒 Coș</a>

            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['rol'] == 'admin'): ?>
                    <a href="admin_adaugare.php" class="btn" style="background: purple;">➕ Produs Nou</a>
                    <a href="admin_comenzi.php" class="btn" style="background: #2980b9;">📋 Comenzi</a>
                <?php endif; ?>
                <a href="logout.php" class="btn" style="background: #c0392b;">Ieșire</a>
            <?php else: ?>
                <a href="login.php" class="btn" style="background: #2ecc71;">Autentificare</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="filtre">
        <form action="index.php" method="GET" style="display: flex; gap: 15px; align-items: center;">

            <div>
                <label>Categorie:</label>
                <select name="categorie" onchange="this.form.submit()">
                    <option value="">Toate categoriile</option>
                    <?php
                    $cats = $pdo->query("SELECT * FROM categorii");
                    while($cat = $cats->fetch()) {
                        $selected = ($cat['id'] == $categorie_id) ? 'selected' : '';
                        echo "<option value='{$cat['id']}' $selected>{$cat['nume']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label>Sortează după:</label>
                <select name="sort" onchange="this.form.submit()">
                    <option value="default" <?= $sortare == 'default' ? 'selected' : '' ?>>Cele mai noi</option>
                    <option value="pret_asc" <?= $sortare == 'pret_asc' ? 'selected' : '' ?>>Preț: Mic la Mare</option>
                    <option value="pret_desc" <?= $sortare == 'pret_desc' ? 'selected' : '' ?>>Preț: Mare la Mic</option>
                    <option value="nume_asc" <?= $sortare == 'nume_asc' ? 'selected' : '' ?>>Nume (A-Z)</option>
                </select>
            </div>

            <noscript><button type="submit">Aplică Filtre</button></noscript>
        </form>
    </div>

    <div class="produse-grid">
        <?php foreach ($produse as $produs): ?>
            <div class="produs">
                <img
                        src="imagini/<?= htmlspecialchars($produs['imagine']) ?>"
                        alt="Produs"
                        onerror="this.onerror=null; this.src='imagini/img.png';"
                >
                <h3><?= htmlspecialchars($produs['nume']) ?></h3>
                <p class="pret"><?= $produs['pret'] ?> RON</p>

                <a href="produs.php?id=<?= $produs['id'] ?>" class="btn">Vezi Detalii</a>

                <form action="adauga_cos.php" method="POST" style="margin-top: 10px;">
                    <input type="hidden" name="produs_id" value="<?= $produs['id'] ?>">
                    <button type="submit" class="btn btn-cos">➕ Adaugă în coș</button>
                </form>
            </div>
        <?php endforeach; ?>

        <?php if(count($produse) == 0): ?>
            <p style="grid-column: 1/-1; text-align: center;">Nu am găsit produse conform filtrelor.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>