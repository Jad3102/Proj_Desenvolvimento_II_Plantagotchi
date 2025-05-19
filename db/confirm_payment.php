<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $pedido_id = $_POST["pedido_id"];
    $usuario_id = $_SESSION["usuario_id"];

    $stmt = $conn->prepare("UPDATE pedidos SET status = 'Pendente' WHERE pedido_id = ? AND usuario_id = ?");
    $stmt->bind_param("ii", $pedido_id, $usuario_id);
    
    if ($stmt->execute()) {
        header("Location: ../pages/purchase.php?sucesso=1");
    } else {
        echo "Erro ao confirmar pagamento.";
    }
}
?>