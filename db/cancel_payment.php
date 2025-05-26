<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pedido_id'])) {
    $pedidoId = intval($_POST['pedido_id']);
    //Se o cliente clica em "Cancelar" na tela de pagamento, atualizamos no banco que o status para a ser "Cancelado"
    try {
        $stmt = $conn->prepare("UPDATE pedidos SET status = 'Cancelado' WHERE pedido_id = :pedido_id");
        $stmt->bindValue(':pedido_id', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../db/payment_status.php?status=cancelled&pedido_id=" . $pedidoId);
        exit;
    } catch (PDOException $e) {
        echo "Erro ao cancelar pagamento: " . $e->getMessage();
    }
} else {
    echo "Requisição inválida.";
}