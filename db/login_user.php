<?php
session_start(); 
require_once "connection_db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? '';
    $senha = $_POST["senha"] ?? '';

    if (empty($email) || empty($senha)) {
        $_SESSION['erro_login'] = "Por favor, preencha todos os campos.";
        header("Location: ../pages/login.php");
        exit;
    }

    try {
        $stmt = $conn->prepare("SELECT usuario_id, nome, senha FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION["usuario_id"] = $usuario["usuario_id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];
            header("Location: ../pages/purchase.php");
            exit;
        } else {
            $_SESSION["erro_login"] = "E-mail ou senha incorretos.";
            header("Location: ../pages/login.php");
            exit;
        }

    } catch (PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        $_SESSION["erro_login"] = "Erro ao tentar realizar login. Tente novamente.";
        header("Location: ../pages/login.php");
        exit;
    }
}