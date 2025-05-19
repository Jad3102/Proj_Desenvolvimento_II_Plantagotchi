<?php
$status = $_GET["status"] ?? "error";
$message = $status === "success" ? "Pagamento realizado com sucesso!" : "Erro ao processar pagamento.";
$alertClass = $status === "success" ? "alert-success" : "alert-danger";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Status do Pagamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <div class="alert <?= $alertClass ?>" role="alert">
        <?= $message ?>
    </div>
    <a href="../pages/purchase.php" class="btn btn-primary">Voltar à página de compras</a>
</body>
</html>