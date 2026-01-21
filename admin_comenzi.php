<?php
require 'db.php';


if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    die("ACCES INTERZIS! Această pagină este doar pentru administratori.");
}


$sql = "SELECT * FROM comenzi ORDER BY data_comenzii DESC";
$stmt = $pdo->query($sql);
$comenzi = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Panou Comenzi - Admin</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .comanda-card {
            background: white;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
        }
        .comanda-header {
            background: #f8f9fa;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #eee;
        }
        .comanda-body {
            padding: 15px;
        }
        .tabel-produse {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.9em;
        }
        .tabel-produse td {
            padding: 5px 0;
            border-bottom: 1px dashed #eee;
        }
        .badge {
            background: #27ae60;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.8em;
        }
        .info-client { font-weight: bold; color: #2c3e50; }
        .info-data { color: #7f8c8d; font-size: 0.9em; }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>📋 Gestionare Comenzi</h1>
        <div>
            <a href="index.php" class="btn">🏠 Înapoi la Magazin</a>
            <a href="admin_adaugare.php" class="btn" style="background: purple;">➕ Adaugă Produs</a>
        </div>
    </header>

    <?php if (count($comenzi) == 0): ?>
        <div style="text-align:center; padding: 40px;">
            <h3>Nu există nicio comandă înregistrată momentan.</h3>
        </div>
    <?php else: ?>

        <p>Aveți <strong><?= count($comenzi) ?></strong> comenzi în istoric.</p>

        <?php foreach ($comenzi as $comanda): ?>
            <div class="comanda-card">
                <div class="comanda-header">
                    <div>
                        <span class="badge">Comanda #<?= $comanda['id'] ?></span>
                        <span class="info-client">👤 <?= htmlspecialchars($comanda['nume_client']) ?></span>
                        <br>
                        <span class="info-data">📅 <?= $comanda['data_comenzii'] ?></span>
                    </div>
                    <div style="text-align: right;">
                        <span style="font-size: 1.2em; font-weight: bold; color: #27ae60;">
                            Total: <?= $comanda['total'] ?> RON
                        </span>
                    </div>
                </div>

                <div class="comanda-body">
                    <strong>Produse comandate:</strong>
                    <table class="tabel-produse">
                        <?php

                        $sql_detalii = "SELECT * FROM detalii_comanda WHERE comanda_id = ?";
                        $stmt_detalii = $pdo->prepare($sql_detalii);
                        $stmt_detalii->execute([$comanda['id']]);
                        $produse = $stmt_detalii->fetchAll();

                        foreach ($produse as $prod):
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($prod['nume_produs']) ?></td>
                                <td><?= $prod['cantitate'] ?> buc. x <?= $prod['pret'] ?> RON</td>
                                <td style="text-align: right; font-weight: bold;">
                                    <?= $prod['cantitate'] * $prod['pret'] ?> RON
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>

    <?php endif; ?>
</div>

</body>
</html>
