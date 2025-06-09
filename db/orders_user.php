<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

try {
    $stmt = $conn->prepare("SELECT p.pedido_id, pr.nome AS produto_nome, p.cor, p.quantidade, p.frete, p.preco_total, p.status, p.criado_em
    FROM pedidos p JOIN produtos pr ON p.produto_id = pr.produto_id WHERE p.usuario_id = ? ORDER BY p.criado_em DESC");
    $stmt->execute([$usuario_id]);
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Se não houver pedidos, retorna uma mensagem específica
    if (count($pedidos) === 0) {
        echo json_encode(['mensagem' => 'Você não possui pedidos em andamento.']);
    } else {
        echo json_encode($pedidos);
    }
} catch (PDOException $e) {
    echo json_encode(['erro' => 'Erro ao buscar pedidos']);
}
?>