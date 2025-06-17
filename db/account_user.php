<?php
session_start();
require_once __DIR__ . '/connection_db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../pages/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
//pegamos do banco as informações inseridas pelo usuário em Minha Conta
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cep = $_POST['cep'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $rua = $_POST['rua'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $complemento = $_POST['complemento'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? null;

    try {
        // Buscamos endereço do usuário no banco
        $stmtCheck = $conn->prepare("SELECT usuario_id FROM enderecos WHERE usuario_id = ?");
        $stmtCheck->execute([$usuario_id]);
        //Atualizamos com as novas informações
        if ($stmtCheck->rowCount() > 0) {
            $stmtEndereco = $conn->prepare("
                UPDATE enderecos 
                SET cep = ?, estado = ?, cidade = ?, bairro = ?, rua = ?, numero = ?, complemento = ?
                WHERE usuario_id = ?
            ");
            $stmtEndereco->execute([$cep, $estado, $cidade, $bairro, $rua, $numero, $complemento, $usuario_id]);

            //Se por algum motivo estiver vazio, é inserido as informações do endereço
        } else {
            $stmtEndereco = $conn->prepare("
                INSERT INTO enderecos (usuario_id, cep, estado, cidade, bairro, rua, numero, complemento)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmtEndereco->execute([$usuario_id, $cep, $estado, $cidade, $bairro, $rua, $numero, $complemento]);
        }

        // Atualizar data de nascimento se foi colocada nova
        $stmtUser = $conn->prepare("UPDATE usuarios SET data_nascimento = ? WHERE usuario_id = ?");
        $stmtUser->execute([$data_nascimento, $usuario_id]);

        // Mensagem de sucesso na alteração
        header("Location: ../pages/my_account.php?sucesso=1");
        exit;
    } catch (PDOException $e) {
        // Caso não, redirecionar com erro
        header("Location: ../pages/my_account.php?erro=1");
        exit;
    }
}
?>