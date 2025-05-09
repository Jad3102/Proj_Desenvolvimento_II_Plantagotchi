<?php
session_start();
$erro_login = $_SESSION['erro_login'] ?? null;
unset($_SESSION['erro_login']);
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | PlantaGotchi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
</head>
<body>
    <?php require "../components/header.php"; ?>
    <div class="container">

    <!-- estilização de pop-up de alerta/erro que vem das condições em login_user.php -->
<?php if ($erro_login): ?>
    <div class="mt-3">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($erro_login) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>
    </div>
<?php endif; ?>

        <div class="forms-container">
            <h2 class="text-center">Login</h2>
            <form action="../db/login_user.php" method="post">
                <div class="mb-3">
                    <label for="campo_email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="campo_email" aria-describedby="emailHelp" name="email">
                </div>
                <div class="mb-3">
                    <label for="campo_senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="campo_senha" name="senha">
                </div>
                <button type="submit" class="btn_entrar btn  w-100">Entrar</button>
            </form>
            <div class="text-center mt-4">
                <p>Não possui conta? Cadastre-se abaixo</p>
                <a href="register.php" class="btn_cadastro btn w-50">Cadastrar</a>
            </div>
        </div>
    </div>
    <div class="imagem-inferior-fixa">
        <img src="../assets/images/flores_lateral_direita.png" alt="Flores coloridas no canto inferior direito">
    </div>

    <?php require "../components/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>