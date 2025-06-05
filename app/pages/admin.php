<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

// Simples verificação de autenticação de admin
if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

// Atualizar status, se solicitado
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pedido_id"], $_POST["novo_status"])) {
    $stmt = $conn->prepare("UPDATE pedidos SET status = ? WHERE pedido_id = ?");
    $stmt->execute([$_POST["novo_status"], $_POST["pedido_id"]]);
    header("Location: admin.php"); // Recarrega a página
    exit;
}

// Buscar todos os pedidos
$stmt = $conn->query("SELECT p.*, u.nome AS nome_usuario, pr.nome AS nome_produto 
FROM pedidos p JOIN usuarios u ON p.usuario_id = u.usuario_id 
JOIN produtos pr ON p.produto_id = pr.produto_id 
ORDER BY p.criado_em DESC");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel = "stylesheet" type="text/css" href="../assets/style.css">
</head>
<body class="body-admin">

<?php require "../components/header_admin.php"; ?>

<div class="container-fluid min-vh-100 d-flex flex-column align-items-center justify-content-start pt-4">
     <!-- Cards de total -->
    <div class="row w-100 justify-content-center mb-3">
      <div class="col-md-2 boxes">Total a Receber<br><strong>R$0000</strong></div>
      <div class="col-md-2 boxes">Pedidos Pagos<br><strong>R$0000</strong></div>
      <div class="col-md-2 boxes">Pedidos em Trânsito<br><strong>0</strong></div>
      <div class="col-md-2 boxes">Pedidos Completos<br><strong>0</strong></div>
      <div class="col-md-2 boxes">Total Recebido<br><strong>R$0000</strong></div>
    </div> 
        
     <!-- Tabela estilo caderno -->
    <div class="col-12">
        <?php if (count($pedidos) === 0): ?>
            <div class="alert alert-custom" role="alert">Nenhum pedido encontrado.</div>
        <?php else: ?>
             <div class="caderno-container">
                <div class="titulo-tabela">Pedidos</div>
                <hr>
                <table class="caderno-tabela">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Produto</th>
                            <th>Cor</th>
                            <th>Quantidade</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido): ?>
                            <tr>
                                <td><?= htmlspecialchars($pedido["pedido_id"]) ?></td>
                                <td><?= htmlspecialchars($pedido["nome_usuario"]) ?></td>
                                <td><?= htmlspecialchars($pedido["nome_produto"]) ?></td>
                                <td><?= htmlspecialchars($pedido["cor"]) ?></td>
                                <td><?= htmlspecialchars($pedido["quantidade"]) ?></td>
                                <td>R$ <?= number_format($pedido["preco_total"], 2, ',', '.') ?></td>
                                <td>
                                    <?php
                                        $badgeClass = match ($pedido["status"]) {
                                            'Aguardando pagamento' => 'warning',
                                            'Pendente' => 'info',
                                            'Pago' => 'success',
                                            'Cancelado' => 'danger',
                                            default => 'secondary',
                                        };
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>">
                                        <?= htmlspecialchars($pedido["status"]) ?>
                                    </span>
                                </td>
                                <td><?= date("d/m/Y H:i", strtotime($pedido["criado_em"])) ?></td>
                                <td>
                                    <form method="POST" class="d-flex flex-column gap-1">
                                        <input type="hidden" name="pedido_id" value="<?= $pedido["pedido_id"] ?>">
                                        <select name="novo_status" class="form-select form-select-sm">
                                            <option <?= $pedido["status"] === "Aguardando pagamento" ? "selected" : "" ?>>Aguardando pagamento</option>
                                            <option <?= $pedido["status"] === "Pago" ? "selected" : "" ?>>Pago</option>
                                            <option <?= $pedido["status"] === "Em preparação" ? "selected" : "" ?>>Em preparação</option>
                                            <option <?= $pedido["status"] === "Enviado" ? "selected" : "" ?>>Enviado</option>
                                            <option <?= $pedido["status"] === "Cancelado" ? "selected" : "" ?>>Cancelado</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm button">Atualizar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>