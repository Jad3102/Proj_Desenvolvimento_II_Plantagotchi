<?php
session_start();
require_once __DIR__ . '/connection_db.php';

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['count' => 0]);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

try {
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM pedidos WHERE usuario_id = ? AND status = 'Aguardando pagamento'");
    $stmt->execute([$usuario_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode(['count' => (int)$result['total']]);
} catch (Exception $e) {
    echo json_encode(['count' => 0]);
}
