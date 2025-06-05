<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// Buscar dados do usuário e endereço
$stmt = $conn->prepare("SELECT u.nome, u.email, u.cpf, u.data_nascimento, e.cep, e.estado, e.cidade, e.bairro, e.rua, e.numero, e.complemento FROM usuarios u LEFT JOIN enderecos e ON u.usuario_id = e.usuario_id WHERE u.usuario_id = ?");
$stmt->execute([$usuario_id]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Minha Conta | PlantaGotchi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel = "stylesheet" type="text/css" href="../assets/style.css">
    <script src="../js/postal_code_search.js"></script>
</head>

<?php require "../components/header.php"; ?>

<body>
    <div class="container mt-5 my_account">
        <h2 class="mb-4">Minha Conta</h2>

                <!-- Pop-up se der algum erro ou se ocorrer com sucesso, exibindo de forma amigável pro usuário. -->
        <?php if (isset($_GET['erro'])): ?>
            <div class="alert alert-danger">Erro ao atualizar dados, tente novamente mais tarde.</div>
        <?php elseif (isset($_GET['sucesso'])): ?>
            <div class="alert alert-success">Dados atualizados com sucesso!</div>
        <?php endif; ?>

        <div id="cepAlertContainer"></div>

        <form action="../db/account_user.php" method="POST" class="card p-4 shadow form-my_account">
            <div class="mb-3">
                <label class="form-label">Nome completo</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">CPF</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($usuario['cpf']) ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input type="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" disabled>
            </div>
            <div class="mb-3">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" name="data_nascimento" class="form-control" value="<?= htmlspecialchars($usuario['data_nascimento']) ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">CEP</label>
                <input type="text" name="cep" id="cep" class="form-control" value="<?= htmlspecialchars($usuario['cep']) ?>" onblur="buscarCEP()" >
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Estado</label>
                    <input type="text" name="estado" id="estado" class="form-control" value="<?= htmlspecialchars($usuario['estado']) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Cidade</label>
                    <input type="text" name="cidade" id="cidade" class="form-control" value="<?= htmlspecialchars($usuario['cidade']) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Bairro</label>
                    <input type="text" name="bairro" id="bairro" class="form-control" value="<?= htmlspecialchars($usuario['bairro']) ?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label">Rua</label>
                    <input type="text" name="rua" id="rua" class="form-control" value="<?= htmlspecialchars($usuario['rua']) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control" value="<?= htmlspecialchars($usuario['numero']) ?>" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Complemento</label>
                <input type="text" name="complemento" class="form-control" value="<?= htmlspecialchars($usuario['complemento']) ?>">
            </div>
            <button type="submit" class="btn button-save">Salvar Alterações</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
