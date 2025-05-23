<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Pedidos | PlantaGotchi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
function carregarPedidos() {
    fetch('../db/orders_user.php')
        .then(res => res.json())
        .then(pedidos => {
            const tabela = document.getElementById('tabelaPedidos');
            tabela.innerHTML = '';

            if (pedidos.mensagem) {
                tabela.innerHTML = `<tr><td colspan="7" class="text-center">${pedidos.mensagem}</td></tr>`;
                return;
            }

            pedidos.forEach(pedido => {
                const linha = document.createElement('tr');

                const statusColor = {
                    'Aguardando pagamento': 'text-warning',
                    'Pago': 'text-success',
                    'Em preparação': 'text-info',
                    'Enviado': 'text-primary',
                    'Cancelado': 'text-danger'
                }[pedido.status] || 'text-secondary';

                linha.innerHTML = `
                    <td>#${pedido.pedido_id}</td>
                    <td>${pedido.produto_nome}</td>
                    <td>${pedido.cor}</td>
                    <td>${pedido.quantidade}</td>
                    <td>R$ ${parseFloat(pedido.preco_total).toFixed(2)}</td>
                    <td class="${statusColor} fw-bold">${pedido.status}</td>
                    <td>
                        ${pedido.status === 'Aguardando pagamento'
                            ? `<a href="../db/payment.php?pedido_id=${pedido.pedido_id}" class="btn btn-sm btn-outline-primary">Pagar Agora</a>`
                            : ''
                        }
                    </td>
                `;

                tabela.appendChild(linha);
            });
        })
        .catch(err => {
            console.error('Erro ao carregar pedidos:', err);
            document.getElementById('tabelaPedidos').innerHTML =
                '<tr><td colspan="7" class="text-center text-danger">Erro ao carregar pedidos.</td></tr>';
        });
}

        document.addEventListener('DOMContentLoaded', carregarPedidos);
    </script>
</head>
<body class="bg-light">

<?php require "../components/header.php"; ?>

<div class="container mt-5">
    <h2 class="mb-4">Meus Pedidos</h2>
    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID Pedido</th>
                        <th>Produto</th>
                        <th>Cor</th>
                        <th>Quantidade</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody id="tabelaPedidos">
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
