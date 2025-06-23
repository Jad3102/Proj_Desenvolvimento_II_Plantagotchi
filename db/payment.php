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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel = "stylesheet" type="text/css" href="../assets/style.css">
</head>
<body class="payment-body">
    
    <div class="container py-5 text-center payment-card">
        <h1 class="mb-4">Pagamento por Pix</h1>
        
        <p>Produto: <strong>R$ <?= number_format($valor_produto, 2, ',', '.') ?></strong></p>
        <p>Frete: <strong>R$ <?= number_format($frete, 2, ',', '.') ?></strong></p>
        <p>Total: <strong>R$ <?= number_format($valor, 2, ',', '.') ?></strong></p>

        <div class="mb-4">
           <?php
                $texto_qrcode = "Pagamento do PlantaGotchi\nPedido: #$pedido_id\nTotal: R$ " . number_format($valor, 2, ',', '.');
                $texto_qrcode_url = urlencode($texto_qrcode);
                $url_qrcode = "../lib/generate_qr.php?text=$texto_qrcode_url";
            ?>
            <img src="<?= $url_qrcode ?>" alt="QR Code Pix" class="img-fluid" style="max-width: 200px;">
        </div>

        <p>Escaneie o QR Code com seu aplicativo bancário para efetuar o pagamento.</p>

        <div class="d-flex justify-content-center gap-2 mt-3">

            <form method="POST" action="../db/confirm_payment.php">
                <input type="hidden" name="pedido_id" value="<?= $pedido_id ?>">
                <button type="submit" class="btn btn-payed">Já paguei</button>
            </form>

            <form method="POST" action="../db/cancel_payment.php" class="d-inline">
            <input type="hidden" name="pedido_id" value="<?= $pedido_id ?>">
            <button type="submit" class="btn btn-cancel">Cancelar</button>
            </form>
        </div>
        <div class="imagem-inferior-fixa">
            <img src="../assets/images/flores_lateral_direita.png" alt="Flores coloridas">
        </div>
    </div>
</body>
</html>