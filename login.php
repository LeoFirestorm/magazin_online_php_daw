<?php
global $pdo;
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $parola = $_POST['parola'];

    $stmt = $pdo->prepare("SELECT * FROM utilizatori WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();


if ($user && $parola == $user['parola'])  {
        // Login reușit! Salvăm datele esențiale în sesiune
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nume'] = $user['nume'];
        $_SESSION['rol'] = $user['rol']; // Aici știm dacă e admin sau client

        header('Location: index.php');
        exit;
    } else {
        $eroare = "Email sau parolă incorectă!";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Autentificare</title><link rel="stylesheet" href="css/style.css"></head>
<body>
<div class="container" style="max-width: 400px; margin-top: 50px;">
    <h2>Login</h2>
    <?php if(isset($eroare)) echo "<p style='color:red'>$eroare</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required style="width:100%; margin-bottom:10px; padding:10px;">
        <input type="password" name="parola" placeholder="Parola" required style="width:100%; margin-bottom:10px; padding:10px;">
        <button type="submit" class="btn">Intră în cont</button>
    </form>
    <p>Nu ai cont? <a href="register.php">Înregistrează-te</a></p>
</div>
</body>
</html>
