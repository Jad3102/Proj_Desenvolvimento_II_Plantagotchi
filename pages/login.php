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
    <?php require "../components/cabecalho.php"; ?>
    <div class="container">
        <div class="forms-container">
            <h2 class="text-center">Login</h2>
            <form>
                <div class="mb-3">
                    <label for="campo_email" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="campo_email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="campo_senha" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="campo_senha">
                </div>
                <button type="submit" class="btn_entrar btn  w-100">Entrar</button>
            </form>
            <div class="text-center mt-4">
                <p>Não possui conta? Cadastre-se abaixo</p>
                <a href="cadastro.php" class="btn_cadastro btn w-50">Cadastrar</a>
            </div>
        </div>
    </div>

    <div class="imagem-inferior-fixa">
        <img src="../assets/images/flores_lateral_direita.png" alt="Flores coloridas no canto inferior direito">
    </div>
    
    <?php require "../components/rodape.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>