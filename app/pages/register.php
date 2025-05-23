<?php
session_start();
$erro_cadastro = $_SESSION['erro_cadastro'] ?? null;
$sucesso_cadastro = $_SESSION['sucesso_cadastro'] ?? null;
unset($_SESSION['erro_cadastro'], $_SESSION['sucesso_cadastro']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Cadastro | PlantaGotchi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../assets/style.css">
    <script src="../js/format_cpf.js" defer></script>
    <script src="../js/postal_code_search.js" defer></script>
</head>

<body>
    <?php require "../components/header.php"; ?>

    <!-- Alerta de erro se não achar o CEP digitado estilizado com bootstrap-->
    <div id="cepAlertContainer"></div>

    <!-- estilização dos alertas dos campos do forms -->
    <?php if ($erro_cadastro): ?>
        <div class="container mt-3">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($erro_cadastro) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        </div>
    <?php elseif ($sucesso_cadastro): ?>
        <div class="container mt-3">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($sucesso_cadastro) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="forms-container">
    <h2 class="text-center mb-4">Cadastro</h2>
        
        <form action="../db/register_user.php" method="post">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="nome" name="nome">
            </div>
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="campo_cpf" name="cpf" maxlength="14" pattern="\d{11}" title="Digite exatamente 11 números">
            </div>
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="campo_data_nascimento" name="data_nascimento" max="<?= date('Y-m-d') ?>">
            </div>
            <div class="mb-3">
                <label for="cep" class="form-label">CEP</label>
                <input type="text" class="form-control" id="cep" name="cep" maxlength="8" oninput="this.value = this.value.replace(/[^0-9]/g, '')"onblur="buscarCEP()">
            </div>
            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <input type="text" class="form-control" id="estado" name="estado">
            </div>
            <div class="mb-3">
                <label for="cidade" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="cidade" name="cidade">
            </div>
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro">
            </div>
            <div class="mb-3">
                <label for="rua" class="form-label">Rua</label>
                <input type="text" class="form-control" id="rua" name="rua">
            </div>
            <div class="mb-3">
                <label for="numero" class="form-label">Número</label>
                <input type="text" class="form-control" id="numero" name="numero">
            </div>
            <div class="mb-3">
                <label for="complemento" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="complemento" name="complemento">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha de Acesso</label>
                <input type="password" class="form-control" id="senha" name="senha">
            </div>
            <button type="submit" class="btn btn_bege w-100">Criar Cadastro</button>
        </form>
    </div>

    <div class="imagem-inferior-fixa">
        <img src="../assets/images/flores_lateral_direita.png" alt="Flores coloridas no canto inferior direito">
    </div>
    <?php require "../components/footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
