<?php
session_start();

// Se usuário já estiver logado, exibe aviso e evita formulário
if (isset($_SESSION['usuario_id'])) {
    $usuario_nome = $_SESSION['usuario_nome'];
    $ja_logado = true;
} else {
    $ja_logado = false;
}

// Mensagem de erro (caso exista)
$erro_login = $_SESSION['erro_login'] ?? null;
unset($_SESSION['erro_login']);
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login | PlantaGotchi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php require "../components/header.php"; ?>

    <div class="container">
        <!-- Alertas estilizados -->
        <?php if ($erro_login): ?>
            <div class="mt-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($erro_login) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php elseif ($ja_logado): ?>
            <div class="mt-3">
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    Você já está logado como <strong><?= htmlspecialchars($usuario_nome) ?></strong>.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        <?php endif; ?>

        <!-- Formulário de login -->
        <?php if (!$ja_logado): ?>
        <div class="forms-container">
            <h2 class="text-center">Login</h2>
            <form action="../db/login_user.php<?= isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : '' ?>" method="post">
                <div class="mb-3">
                    <label for="campo_email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="campo_email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="campo_senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="campo_senha" name="senha" required>
                </div>
                <button type="submit" class="btn_entrar btn w-100">Entrar</button>
            </form>
            <div class="text-center mt-4">
                <p>Não possui conta? Cadastre-se abaixo</p>
                <a href="register.php" class="btn_cadastro btn w-50">Cadastrar</a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="imagem-inferior-fixa">
        <img src="../assets/images/flores_lateral_direita.png" alt="Flores coloridas">
    </div>

    <?php require "../components/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>