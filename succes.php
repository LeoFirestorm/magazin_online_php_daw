<?php
require 'db.php';

if (!isset($_SESSION['cos']) || count($_SESSION['cos']) == 0) {
    header("Location: index.php");
    exit;
}


if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $nume_client = $_SESSION['nume'];
} else {
    $user_id = NULL;
    $nume_client = "Anonim";
}

$ids = array_keys($_SESSION['cos']);
$locuri = str_repeat('?,', count($ids) - 1) . '?';
$sql = "SELECT * FROM produse WHERE id IN ($locuri)";
$stmt = $pdo->prepare($sql);
$stmt->execute($ids);
$produse_db = $stmt->fetchAll();

$total_comanda = 0;
$lista_produse_pentru_insert = [];

foreach ($produse_db as $prod) {
    $cantitate = $_SESSION['cos'][$prod['id']];
    $pret = $prod['pret'];
    $total_comanda += $pret * $cantitate;
    $lista_produse_pentru_insert[] = [
            'id' => $prod['id'],
            'nume' => $prod['nume'],
            'pret' => $pret,
            'cantitate' => $cantitate
    ];
}

try {

    $pdo->beginTransaction();

    $sql_comanda = "INSERT INTO comenzi (user_id, nume_client, total) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql_comanda);
    $stmt->execute([$user_id, $nume_client, $total_comanda]);


    $id_comanda = $pdo->lastInsertId();


    $sql_detalii = "INSERT INTO detalii_comanda (comanda_id, produs_id, nume_produs, pret, cantitate) VALUES (?, ?, ?, ?, ?)";
    $stmt_detalii = $pdo->prepare($sql_detalii);

    foreach ($lista_produse_pentru_insert as $item) {
        $stmt_detalii->execute([
                $id_comanda,
                $item['id'],
                $item['nume'],
                $item['pret'],
                $item['cantitate']
        ]);
    }


    $pdo->commit();


    unset($_SESSION['cos']);

} catch (Exception $e) {

    $pdo->rollBack();
    die("Eroare la salvarea comenzii: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Comandă Reușită</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .succes-box { text-align: center; background: white; padding: 40px; border-radius: 10px; margin-top: 50px; }
        .icon { font-size: 60px; color: #27ae60; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="succes-box">
        <div class="icon">✅</div>
        <h1>Comandă Salvată!</h1>
        <p>Mulțumim, <strong><?= htmlspecialchars($nume_client) ?></strong>.</p>
        <p>ID Comandă: #<?= $id_comanda ?></p>
        <p>Total: <?= $total_comanda ?> RON</p>
        <br>
        <a href="index.php" class="btn">Înapoi la magazin</a>
    </div>
</div>
</body>
</html>