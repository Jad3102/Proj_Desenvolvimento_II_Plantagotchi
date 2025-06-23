<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'])) {
    $pedidoId = intval($_POST['pedido_id']); 

    try {
        $stmt = $conn->prepare("UPDATE pedidos SET status = 'Pago' WHERE pedido_id = :pedido_id");
        $stmt->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();
        // Redireciona após atualização
        header("Location: ../db/payment_status.php?status=success&pedido_id=" . $pedidoId);
        exit;
    } catch (PDOException $e) {
        echo "Erro ao confirmar pagamento: " . $e->getMessage();
    }
} else {
    echo "Requisição inválida.";
}