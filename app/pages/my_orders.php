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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel = "stylesheet" type="text/css" href="../assets/style.css">
    
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
<body>

<?php require "../components/header.php"; ?>

<div class="container-fluid min-vh-100 d-flex flex-column align-items-center pt-4 my_orders">
    <div class="row col-10 caderno">
        <h2 class="mb-4 titulo-tabela">Meus Pedidos</h2>
        <div class="card shadow">
            <div class="card-body table-responsive">
                <table class="table table-hover caderno-tabela">
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
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
