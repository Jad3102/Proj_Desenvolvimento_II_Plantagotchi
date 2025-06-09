<?php
require_once __DIR__ . '/../db/connection_db.php';

if (!isset($_GET['pedido_id'])) {
    echo "Pedido inválido.";
    exit;
}

$pedido_id = intval($_GET['pedido_id']); // pega o id da URL
try {
    $stmt = $conn->prepare("SELECT * FROM pedidos WHERE pedido_id = :pedido_id");
    $stmt->bindValue(':pedido_id', $pedido_id, PDO::PARAM_INT);
    $stmt->execute();

    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$pedido) {
        echo "Pedido não encontrado.";
        exit;
    }

    $valor = $pedido['preco_total'];
    $frete = $pedido['frete'];
    $valor_produto = $valor - $frete;
} catch (PDOException $e) {
    echo "Erro ao buscar pedido: " . $e->getMessage();
    exit;
}
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
    
    <p>Produto: <strong>R$ <?= number_format($valor_produto, 2, ',', '.') ?></strong></p>
    <p>Frete: <strong>R$ <?= number_format($frete, 2, ',', '.') ?></strong></p>
    <p>Total: <strong>R$ <?= number_format($valor, 2, ',', '.') ?></strong></p>

    <div class="mb-4">
        <img src="../images/qrcode.png" alt="QR Code Pix" class="img-fluid" style="max-width: 200px;">
    </div>

    <p>Escaneie o QR Code com seu aplicativo bancário para efetuar o pagamento.</p>

    <form method="POST" action="../db/confirm_payment.php">
        <input type="hidden" name="pedido_id" value="<?= $pedido_id ?>">
        <button type="submit" class="btn btn-success">Já paguei</button>
    </form>

    <form method="POST" action="../db/cancel_payment.php" class="d-inline">
    <input type="hidden" name="pedido_id" value="<?= $pedido_id ?>">
    <button type="submit" class="btn btn-secondary">Cancelar</button>
    </form>

</body>
</html>