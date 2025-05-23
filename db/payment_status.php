<?php
//para lidar com retornos de pagamentos com sucesso ou sem
$status = $_GET["status"] ?? "error";

switch ($status) {
    case "success":
        $message = "Pagamento realizado com sucesso!";
        $alertClass = "alert-success";
        break;
    case "cancelled":
        $message = "Pedido cancelado com sucesso.";
        $alertClass = "alert-warning";
        break;
    default:
        $message = "Erro ao processar pagamento.";
        $alertClass = "alert-danger";
}
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
    <a href="../pages/my_orders.php" class="btn btn-primary">Acessar meu pedido</a>
</body>
</html>