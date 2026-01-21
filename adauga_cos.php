<?php
require 'db.php';


if (isset($_POST['produs_id'])) {
    $id = (int)$_POST['produs_id'];
    $cantitate = 1;


    if (!isset($_SESSION['cos'])) {
        $_SESSION['cos'] = [];
    }


    if (isset($_SESSION['cos'][$id])) {

        $_SESSION['cos'][$id] += $cantitate;
    } else {

        $_SESSION['cos'][$id] = $cantitate;
    }

    $_SESSION['mesaj'] = "Produsul a fost adăugat!";
}

if (isset($_GET['actiune']) && $_GET['actiune'] == 'golire') {
    unset($_SESSION['cos']);
}

header('Location: cos.php');
exit;
?>