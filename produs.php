<?php
require 'db.php';



if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Eroare: Nu ai specificat un produs!");
}
$id_produs = (int)$_GET['id'];


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['adauga_recenzie'])) {
    $nume = htmlspecialchars($_POST['nume']);
    $nota = (int)$_POST['nota'];
    $comentariu = htmlspecialchars($_POST['comentariu']);


    $sql_insert = "INSERT INTO recenzii (produs_id, nume_utilizator, nota, comentariu) VALUES (?, ?, ?, ?)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([$id_produs, $nume, $nota, $comentariu]);


    header("Location: produs.php?id=" . $id_produs);
    exit;
}


$stmt = $pdo->prepare("SELECT * FROM produse WHERE id = ?");
$stmt->execute([$id_produs]);
$produs = $stmt->fetch();


if (!$produs) {
    die("Produsul nu a fost găsit.");
}


$stmt_recenzii = $pdo->prepare("SELECT * FROM recenzii WHERE produs_id = ? ORDER BY data_adaugarii DESC");
$stmt_recenzii->execute([$id_produs]);
$recenzii = $stmt_recenzii->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($produs['nume']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <a href="index.php" class="btn">⬅ Înapoi la produse</a>
    <br><br>

    <div class="produs-detaliu" style="background: white; padding: 20px; border-radius: 8px;">
        <div style="display: flex; gap: 20px;">
            <img src="imagini/<?= htmlspecialchars($produs['imagine']) ?>" style="max-width: 300px;" onerror="this.src='https://via.placeholder.com/300'">
            <div>
                <h1><?= htmlspecialchars($produs['nume']) ?></h1>
                <h2 style="color: #27ae60;"><?= $produs['pret'] ?> RON</h2>
                <p><?= nl2br(htmlspecialchars($produs['descriere'])) ?></p>

                <form action="adauga_cos.php" method="POST">
                    <input type="hidden" name="produs_id" value="<?= $produs['id'] ?>">
                    <button type="submit" class="btn btn-cos">🛒 Adaugă în coș</button>
                </form>
            </div>
        </div>
    </div>

    <hr>

    <h3>Recenzii Clienti</h3>

    <div class="form-recenzie" style="background: #eef; padding: 15px; margin-bottom: 20px;">
        <h4>Spune-ți părerea!</h4>
        <form method="POST">
            <input type="text" name="nume" placeholder="Numele tău" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
            <select name="nota" style="padding: 8px; margin-bottom: 10px;">
                <option value="5">⭐⭐⭐⭐⭐ (5/5)</option>
                <option value="4">⭐⭐⭐⭐ (4/5)</option>
                <option value="3">⭐⭐⭐ (3/5)</option>
                <option value="2">⭐⭐ (2/5)</option>
                <option value="1">⭐ (1/5)</option>
            </select>
            <textarea name="comentariu" placeholder="Comentariul tău..." required style="width: 100%; height: 80px; padding: 8px;"></textarea>
            <button type="submit" name="adauga_recenzie" class="btn">Trimite Recenzia</button>
        </form>
    </div>

    <?php foreach ($recenzii as $recenzie): ?>
        <div class="recenzie" style="border-bottom: 1px solid #ddd; padding: 10px 0;">
            <strong><?= htmlspecialchars($recenzie['nume_utilizator']) ?></strong>
            <span style="color: gold;">
                <?= str_repeat('★', $recenzie['nota']) // Afiseaza stele vizual ?>
            </span>
            <small style="color: gray;">(<?= $recenzie['data_adaugarii'] ?>)</small>
            <p><?= htmlspecialchars($recenzie['comentariu']) ?></p>
        </div>
    <?php endforeach; ?>

    <?php if(count($recenzii) == 0): ?>
        <p>Fii primul care lasă o recenzie!</p>
    <?php endif; ?>

</div>

</body>
</html>