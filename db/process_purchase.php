<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_id = $_SESSION["usuario_id"];
    $produto_id = "1";
    $cor = $_POST["cor"] ?? "rosa";
    $quantidade = intval($_POST["quantidade"]);
    $preco_unitario = 250.00;
    $desconto = 0.9;
    $frete_valor = floatval($_POST["frete_valor"] ?? 0);

    $preco_total = ($preco_unitario * $quantidade * $desconto) + $frete_valor;

    try {
        $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, produto_id, cor, quantidade, preco_total, status) VALUES (?, ?, ?, ?, ?, 'Aguardando pagamento')");
        $stmt->execute([$usuario_id, $produto_id, $cor, $quantidade, $preco_total]);

        $pedido_id = $conn->lastInsertId();
        header("Location: ../db/payment.php?pedido_id=" . $pedido_id);
        exit;
    } catch (PDOException $e) {
        echo "Erro ao registrar pedido: " . $e->getMessage();
    }
} else {
    header("Location: ../pages/purchase.php");
    exit;
}
