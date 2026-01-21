<?php
require 'db.php';


$produse_in_cos = [];
$total_general = 0;

if (isset($_SESSION['cos']) && count($_SESSION['cos']) > 0) {

    $ids = array_keys($_SESSION['cos']);


    $locuri_intrebare = str_repeat('?,', count($ids) - 1) . '?';


    $sql = "SELECT * FROM produse WHERE id IN ($locuri_intrebare)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($ids);
    $produse_db = $stmt->fetchAll();


    foreach ($produse_db as $prod) {
        $prod['cantitate'] = $_SESSION['cos'][$prod['id']];
        $prod['total_linie'] = $prod['pret'] * $prod['cantitate'];
        $produse_in_cos[] = $prod;
        $total_general += $prod['total_linie'];
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Coșul meu de cumpărături</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f8f9fa; }
        .total-box { text-align: right; font-size: 1.5em; margin-top: 20px; color: #27ae60; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <header>
        <h1>🛒 Coșul Tău</h1>
        <a href="index.php" class="btn">⬅ Continuă cumpărăturile</a>
    </header>

    <?php if (empty($produse_in_cos)): ?>
        <p>Coșul tău este gol. Mergi la produse!</p>
    <?php else: ?>

        <div style="background: white; padding: 20px; border-radius: 8px;">
            <table>
                <thead>
                <tr>
                    <th>Produs</th>
                    <th>Preț Unitar</th>
                    <th>Cantitate</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($produse_in_cos as $item): ?>
                    <tr>
                        <td>
                            <strong><?= htmlspecialchars($item['nume']) ?></strong><br>
                            <small><?= substr($item['descriere'], 0, 50) ?>...</small>
                        </td>
                        <td><?= $item['pret'] ?> RON</td>
                        <td><?= $item['cantitate'] ?> buc.</td>
                        <td><?= $item['total_linie'] ?> RON</td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <div class="total-box">
                Total de plată: <?= $total_general ?> RON
            </div>

            <hr>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">

                <a href="adauga_cos.php?actiune=golire" style="color: red; text-decoration: none;">
                    🗑️ Golește coșul
                </a>

                <div style="display: flex; gap: 10px;">

                    <form action="succes.php" method="POST">
                        <button type="submit" class="btn" style="background: #27ae60;">
                            🚀 Plată Rapidă (Test)
                        </button>
                    </form>

                    <form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="sb-43v7m334623@business.example.com">
                        <input type="hidden" name="item_name" value="Comanda Magazin">
                        <input type="hidden" name="amount" value="<?= $total_general / 5 ?>">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="return" value="http://localhost/magazin_online/succes.php">
                        <input type="hidden" name="cancel_return" value="http://localhost/magazin_online/cos.php">

                        <button type="submit" class="btn" style="background: #0070ba;">
                            💳 PayPal
                        </button>
                    </form>

                </div>
            </div>

    <?php endif; ?>
</div>

</body>
</html>