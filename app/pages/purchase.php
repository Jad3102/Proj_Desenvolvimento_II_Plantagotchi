<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    // Usuário não logado, redireciona
    header("Location: login.php");
    exit;
}

$nome = $_SESSION["usuario_nome"];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Área do Usuário | PlantaGotchi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php require "../components/header.php"; ?>

    <div class="container mt-5">
        <h2>Bem-vindo, <?= htmlspecialchars($nome) ?>!</h2>
        <p>Aqui você pode realizar suas compras.</p>

    </div>

    <?php require "../components/footer.php"; ?>
</body>
</html>