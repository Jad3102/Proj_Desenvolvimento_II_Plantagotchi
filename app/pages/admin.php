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
$stmt = $conn->query("SELECT p.*, u.nome AS nome_usuario FROM pedidos p JOIN usuarios u ON p.usuario_id = u.usuario_id ORDER BY p.criado_em DESC");
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php require "../components/header_admin.php"; ?>

<div class="container py-5 mt-4">
    <h1 class="mb-4">Painel do Administrador - Pedidos</h1>

    <?php if (count($pedidos) === 0): ?>
        <div class="alert alert-info">Nenhum pedido encontrado.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Produto</th>
                        <th>Cor</th>
                        <th>Quantidade</th>
                        <th>Total</th>
                        <th>Status</th>:
                        <th>Data</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?= htmlspecialchars($pedido["pedido_id"]) ?></td>
                            <td><?= htmlspecialchars($pedido["nome_usuario"]) ?></td>
                            <td><?= htmlspecialchars($pedido["produto_nome"]) ?></td>
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
                                    <button type="submit" class="btn btn-sm btn-primary">Atualizar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>