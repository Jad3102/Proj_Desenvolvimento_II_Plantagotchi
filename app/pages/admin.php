<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';
require_once __DIR__ . '/../db/admin_logic.php';

if (!isset($_SESSION["admin_id"])) {
    header("Location: admin_login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pedido_id"], $_POST["novo_status"])) {
    $stmt = $conn->prepare("UPDATE pedidos SET status = ? WHERE pedido_id = ?");
    $stmt->execute([$_POST["novo_status"], $_POST["pedido_id"]]);
    header("Location: admin.php");
    exit;
}

$filtros = [];
if (!empty($_GET)) {
    $filtros = [
        'nome'       => $_GET['nome'] ?? null,
        'cor'        => $_GET['cor'] ?? null,
        'quantidade' => $_GET['quantidade'] ?? null,
        'valor_min'  => $_GET['valor_min'] ?? null,
        'valor_max'  => $_GET['valor_max'] ?? null,
        'status'     => $_GET['status'] ?? null,
        'data_ini'   => $_GET['data_ini'] ?? null,
        'data_fim'   => $_GET['data_fim'] ?? null,
    ];
}

$pedidos = buscarPedidos($conn, $filtros);
$metricas = calcularMetricas($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        #filtro-container {
            display: none;
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="body-admin">
<?php require "../components/header_admin.php"; ?>

<div class="container-fluid min-vh-100 pt-4">
    <!-- Métricas -->
    <div class="row w-100 justify-content-center mb-3">
        <div class="col-md-2 boxes">Total a Receber<br><strong>R$<?= number_format($metricas['total_a_receber'], 2, ',', '.') ?></strong></div>
        <div class="col-md-2 boxes">Pedidos Pagos<br><strong><?= $metricas['pedidos_pagos'] ?></strong></div>
        <div class="col-md-2 boxes">Pedidos em Andamento<br><strong><?= $metricas['pedidos_em_preparacao'] ?></strong></div>
        <div class="col-md-2 boxes">Pedidos Completos<br><strong><?= $metricas['pedidos_enviados'] ?></strong></div>
        <div class="col-md-2 boxes">Total Recebido<br><strong>R$<?= number_format($metricas['total_recebido'], 2, ',', '.') ?></strong></div>
        <div class="col-md-2 boxes">Pedidos Pendentes<br><strong><?= $metricas['pedidos_aguardando_pagamento'] ?></strong></div>
    </div>

    
    

    <!-- Tabela -->
    <div class="col-12 text-center">
        <?php if (count($pedidos) === 0): ?>
            <div class="alert alert-warning" role="alert">Nenhum pedido encontrado.</div>
        <?php else: ?>
            <div class="caderno-container">
                <div class="row-title d-flex justify-content-between align-items-center">
                    <div class="titulo-tabela">Pedidos</div>
                    <div class="text-end mb-2 me-2">
                        <button class="btn btn-filter" onclick="toggleFiltro()">
                            <i class="fas fa-filter"></i> Filtros
                        </button>
                    </div>
                </div>

        <div id="filtro-container" class="border rounded p-3 mb-4">
            <form method="GET" class="row g-2">
                <div class="col-md-3"><input type="text" name="nome" class="form-control" placeholder="Nome do cliente" value="<?= htmlspecialchars($_GET['nome'] ?? '') ?>"></div>
                <div class="col-md-2">
                    <select name="cor" class="form-select">
                        <option value="">Todas as cores</option>
                        <?php
                        $cores = ['Rosa', 'Verde', 'Amarelo'];
                        foreach ($cores as $cor) {
                            $selected = ($_GET['cor'] ?? '') === $cor ? 'selected' : '';
                            echo "<option value=\"$cor\" $selected>$cor</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-1"><input type="number" name="quantidade" class="form-control" placeholder="Qtd" value="<?= htmlspecialchars($_GET['quantidade'] ?? '') ?>"></div>
                <div class="col-md-2"><input type="number" name="valor_min" step="0.01" class="form-control" placeholder="Valor mín." value="<?= htmlspecialchars($_GET['valor_min'] ?? '') ?>"></div>
                <div class="col-md-2"><input type="number" name="valor_max" step="0.01" class="form-control" placeholder="Valor máx." value="<?= htmlspecialchars($_GET['valor_max'] ?? '') ?>"></div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Todos os status</option>
                        <?php
                        $statuses = ['Aguardando pagamento', 'Pago', 'Pendente', 'Em preparação', 'Enviado', 'Cancelado'];
                        foreach ($statuses as $status) {
                            $selected = ($_GET['status'] ?? '') === $status ? 'selected' : '';
                            echo "<option value=\"$status\" $selected>$status</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2"><input type="date" name="data_ini" class="form-control" value="<?= htmlspecialchars($_GET['data_ini'] ?? '') ?>"></div>
                <div class="col-md-2"><input type="date" name="data_fim" class="form-control" value="<?= htmlspecialchars($_GET['data_fim'] ?? '') ?>"></div>
                <div class="col-md-2 d-grid"><button type="submit" class="btn btn-filter">Filtrar</button></div>
                <div class="col-md-2 d-grid">
                    <a href="admin.php" class="btn btn-outline-danger">Limpar Filtro</a>
                </div>
            </form>
        </div>
        <hr>
        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Produto</th>
                    <th>Cor</th>
                    <th>Qtd</th>
                    <th>Frete</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>SLA</th>
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
                        <td>R$ <?= number_format($pedido["frete"], 2, ',', '.') ?></td>
                        <td>R$ <?= number_format($pedido["preco_total"], 2, ',', '.') ?></td>
                        <td>
                            <?php
                            $badgeClass = match ($pedido["status"]) {
                                'Aguardando pagamento' => 'warning',
                                'Pago' => 'success',
                                'Pendente' => 'info',
                                'Em preparação' => 'primary',
                                'Enviado' => 'secondary',
                                'Cancelado' => 'danger',
                                default => 'light',
                            };
                            ?>
                            <span class="badge bg-<?= $badgeClass ?>"><?= htmlspecialchars($pedido["status"]) ?></span>
                        </td>
                        <td><?= calcularSLA($pedido["status"], $pedido["criado_em"]) ?></td>
                        <td><?= date("d/m/Y H:i", strtotime($pedido["criado_em"])) ?></td>
                        <td>
                            <form method="POST" class="d-flex flex-column gap-1">
                                <input type="hidden" name="pedido_id" value="<?= $pedido["pedido_id"] ?>">
                                <select name="novo_status" class="form-select form-select-sm">
                                    <?php
                                    foreach ($statuses as $status) {
                                        $selected = $pedido["status"] === $status ? "selected" : "";
                                        echo "<option $selected>$status</option>";
                                    }
                                    ?>
                                </select>
                                <button type="submit" class="btn btn-sm btn-update">Atualizar</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
        <?php endif; ?>
    </div>
</div>

<script>
function toggleFiltro() {
    const filtro = document.getElementById('filtro-container');
    filtro.style.display = (filtro.style.display === 'none' || filtro.style.display === '') ? 'block' : 'none';
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
