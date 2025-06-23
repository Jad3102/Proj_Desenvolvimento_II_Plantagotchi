<?php
//para lidar com retornos de pagamentos com sucesso ou sem sucesso
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel = "stylesheet" type="text/css" href="../assets/style.css">
</head>
<body class="payment_status">

    <div class="container container-payment_status py-5 ">
        <div class="alert <?= $alertClass ?> alert-card justify-content-center align-items-center shadow-sm" role="alert">
            <?= $message ?>
        </div>
        <a href="../pages/my_orders.php" class="btn alert-btn">Acessar meu pedido</a>
    </div>
    <div class="imagem-inferior-fixa">
            <img src="../assets/images/flores_lateral_direita.png" alt="Flores coloridas">
    </div>
    
</body>
</html>