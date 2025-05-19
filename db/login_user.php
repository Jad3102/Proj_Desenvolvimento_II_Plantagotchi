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
        // verifica se o usuário é admin, se sim, direcionamos para página de gerenciamento de pedidos
        $stmtAdmin = $conn->prepare("SELECT id, nome, senha FROM admins WHERE email = ?");
        $stmtAdmin->execute([$email]);
        $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($senha, $admin['senha'])) {
            $_SESSION["admin_id"] = $admin["id"];
            $_SESSION["admin_nome"] = $admin["nome"];
            header("Location: ../pages/admin.php"); // Página de administração
            exit;
        }

        // verifica se o usuário comum/cliente, então direciona para página de compra
        $stmtUser = $conn->prepare("SELECT usuario_id, nome, senha FROM usuarios WHERE email = ?");
        $stmtUser->execute([$email]);
        $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            $_SESSION["usuario_id"] = $usuario["usuario_id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];
            header("Location: ../pages/purchase.php"); // Página de compra
            exit;
        }

        // 3. Nenhuma conta encontrada
        $_SESSION["erro_login"] = "E-mail ou senha incorretos.";
        header("Location: ../pages/login.php");
        exit;

    } catch (PDOException $e) {
        error_log("Erro no login: " . $e->getMessage());
        $_SESSION["erro_login"] = "Erro ao tentar realizar login. Tente novamente.";
        header("Location: ../pages/login.php");
        exit;
    }
}