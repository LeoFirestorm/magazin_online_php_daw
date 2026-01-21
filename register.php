<?php
global $pdo;
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nume = htmlspecialchars($_POST['nume']);
    $email = htmlspecialchars($_POST['email']);
    $parola = $_POST['parola'];

    try {
        $stmt = $pdo->prepare("INSERT INTO utilizatori (nume, email, parola) VALUES (?, ?, ?)");
        $stmt->execute([$nume, $email, $parola]);
        header('Location: login.php');
        exit;
    } catch (PDOException $e) {
        $eroare = "Acest email există deja!";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Înregistrare</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container" style="max-width: 400px; margin-top: 50px;">
    <h2>Creează cont</h2>
    <?php if(isset($eroare)) echo "<p style='color:red'>$eroare</p>"; ?>
    <form method="POST">
        <input type="text" name="nume" placeholder="Nume complet" required style="width:100%; margin-bottom:10px; padding:10px;">
        <input type="email" name="email" placeholder="Email" required style="width:100%; margin-bottom:10px; padding:10px;">
        <input type="password" name="parola" placeholder="Parola" required style="width:100%; margin-bottom:10px; padding:10px;">
        <button type="submit" class="btn">Înregistrează-te</button>
    </form>
    <p>Ai deja cont? <a href="login.php">Loghează-te</a></p>
</div>
</body>
</html>