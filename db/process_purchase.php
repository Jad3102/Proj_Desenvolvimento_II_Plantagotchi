<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../pages/login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_id = $_SESSION["usuario_id"];
    $produto_id = 1; // ID do PlantaGotchi
    $cor = $_POST["cor"] ?? "rosa";
    $quantidade = intval($_POST["quantidade"]);

    $preco_unitario = 250.00;
    $preco_com_desconto = $preco_unitario * 0.9;
    $valor_produtos = $preco_com_desconto * $quantidade;

    // Buscando estado do usuário
    $stmtEndereco = $conn->prepare("SELECT estado FROM enderecos WHERE usuario_id = ?");
    $stmtEndereco->execute([$usuario_id]);
    $endereco = $stmtEndereco->fetch(PDO::FETCH_ASSOC);

    if (!$endereco) {
        echo "Endereço não encontrado.";
        exit;
    }

    $estado = strtoupper($endereco['estado']);

    // Definindo o frete conforme estado
    $fretes = [
        "AC"=>35.00, "AL"=>25.00, "AP"=>38.00, "AM"=>42.00, "BA"=>22.00,
        "CE"=>24.00, "DF"=>20.00, "ES"=>18.00, "GO"=>20.00, "MA"=>30.00,
        "MT"=>28.00, "MS"=>25.00, "MG"=>18.00, "PA"=>36.00, "PB"=>24.00,
        "PR"=>16.00, "PE"=>24.00, "PI"=>26.00, "RJ"=>15.00, "RN"=>23.00,
        "RS"=>17.00, "RO"=>33.00, "RR"=>40.00, "SC"=>18.00, "SP"=>12.00,
        "SE"=>22.00, "TO"=>30.00
    ];

    $frete = $fretes[$estado] ?? 30.00;
    $preco_total = $valor_produtos + $frete;

    try {
        $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, produto_id, cor, quantidade, preco_total, frete, status) VALUES (?, ?, ?, ?, ?, ?, 'Aguardando pagamento')");
        $stmt->execute([$usuario_id, $produto_id, $cor, $quantidade, $preco_total, $frete]);

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
