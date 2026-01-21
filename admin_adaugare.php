<?php
require 'db.php';


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("ACCES INTERZIS! Nu ești vânzător.");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = htmlspecialchars($_POST['nume']);
    $descriere = htmlspecialchars($_POST['descriere']);
    $pret = $_POST['pret'];
    $categorie = $_POST['categorie'];


    $imagine = "no-image.jpg";
    if (isset($_FILES['imagine']) && $_FILES['imagine']['error'] == 0) {
        $target_dir = "imagini/";
        $imagine_nume = time() . "_" . basename($_FILES["imagine"]["name"]);
        move_uploaded_file($_FILES["imagine"]["tmp_name"], $target_dir . $imagine_nume);
        $imagine = $imagine_nume;
    }

    $sql = "INSERT INTO produse (nume, descriere, pret, categorie_id, imagine) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nume, $descriere, $pret, $categorie, $imagine]);

    echo "<p style='color:green; text-align:center;'>Produs adăugat cu succes!</p>";
}
?>

<!DOCTYPE html>
<html>
<head><title>Admin - Adaugă Produs</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container">
    <header>
        <h1>Panou Vânzător</h1>
        <a href="index.php" class="btn">🏠 Înapoi la Magazin</a>
    </header>

    <div style="background: white; padding: 20px; border-radius: 8px;">
        <form method="POST" enctype="multipart/form-data">
            <label>Nume Produs:</label>
            <input type="text" name="nume" required style="width:100%; padding:8px; margin-bottom:10px;">

            <label>Categorie:</label>
            <select name="categorie" style="width:100%; padding:8px; margin-bottom:10px;">
                <?php
                $cats = $pdo->query("SELECT * FROM categorii");
                while($c = $cats->fetch()) echo "<option value='{$c['id']}'>{$c['nume']}</option>";
                ?>
            </select>

            <label>Preț (RON):</label>
            <input type="number" step="0.01" name="pret" required style="width:100%; padding:8px; margin-bottom:10px;">

            <label>Descriere:</label>
            <textarea name="descriere" required style="width:100%; height:100px; padding:8px; margin-bottom:10px;"></textarea>

            <label>Imagine:</label>
            <input type="file" name="imagine" style="margin-bottom:20px;">

            <button type="submit" class="btn" style="background: #e67e22;">💾 Salvează Produsul</button>
        </form>
    </div>
</div>
</body>
</html>
