<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

if (!isset($_SESSION["usuario_id"]) || !isset($_GET["pedido_id"])) {
    header("Location: ../pages/login.php");
    exit;
}

$pedido_id = $_GET["pedido_id"];

$stmt = $conn->prepare("SELECT * FROM pedidos WHERE pedido_id = :pedido_id AND usuario_id = :usuario_id");
$stmt->bindValue(':pedido_id', $pedido_id, PDO::PARAM_INT);
$stmt->bindValue(':usuario_id', $_SESSION["usuario_id"], PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$result) {
    echo "Pedido não encontrado.";
    exit;
}

$pedido = $result;
$valor = number_format($pedido['preco_total'], 2, ',', '.');
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pagamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1 class="mb-4">Pagamento por Pix</h1>
    <p>Pedido: <strong>#<?= $pedido_id ?></strong></p>
    <p>Valor: <strong>R$ <?= $valor ?></strong></p>
    
    <div class="mb-4">
        <img src="imagens/qrcode.png" alt="QR Code Pix" class="img-fluid" style="max-width: 200px;">
    </div>

    <p>Escaneie o QR Code com seu aplicativo bancário para efetuar o pagamento.</p>

    <form method="POST" action="../db/confirm_payment.php">
        <input type="hidden" name="pedido_id" value="<?= $pedido_id ?>">
        <button type="submit" class="btn btn-success">Já paguei</button>
        <a href="../pages/purchase.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>