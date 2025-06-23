<?php
require_once __DIR__ . '/../db/connection_db.php';

session_start();

$usuario_id = $_SESSION["usuario_id"];
$endereco = null;

// busca o endereço no banco que o usuário cadastrou
try {
    $stmt = $conn->prepare("SELECT * FROM enderecos WHERE usuario_id = ?");
    $stmt->execute([$usuario_id]);
    $endereco = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar endereço: " . $e->getMessage();
}

if (!isset($_SESSION["usuario_id"])) {
    //Usuário não logado, redireciona para login
    header("Location: login.php");
    exit;
}

$nome = $_SESSION["usuario_nome"];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Compra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel = "stylesheet" type="text/css" href="../assets/style.css">
</head>
<body class="purchase">
    <?php require "../components/header.php"; ?>

    <div class="d-flex product align-items-start">
        <div id="meuCarrossel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">

                <div class="carousel-item active">
                <img src="../assets/images/Image.png" class="d-block w-20" alt="Imagem 1">
                </div>

                <div class="carousel-item">
                <img src="../assets/images/Image.png" class="d-block  w-20" alt="Imagem 2">
                </div>

                <div class="carousel-item">
                <img src="../assets/images/Image.png" class="d-block  w-20" alt="Imagem 3">
            </div>
        </div>

        <!-- Botões de navegação -->
        <button class="carousel-control-prev" type="button" data-bs-target="#meuCarrossel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#meuCarrossel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        </button>

        <!-- Indicadores -->
        <div class="carousel-indicators">
        <button type="button" data-bs-target="#meuCarrossel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#meuCarrossel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#meuCarrossel" data-bs-slide-to="2"></button>
        </div>
        </div>

        <form action="../db/process_purchase.php" method="POST" class="produto-form d-flex">
            
            <h1>Kit Plantagotchi</h1>
            <p class="preco">R$ 250,00</p>
            <p class="desconto">10% desconto no pix</p>

            <!-- Seleção de cor -->
            <label for="cor" >Cor:</label>
            <select name="cor" id="cor" class="cor-select">
            <option value="rosa">Rosa</option>
            <option value="verde">Verde</option>
            <option value="amarelo">Amarelo</option>
            </select>

            <!-- Seletor de quantidade -->
            <label for="quantidade">Quantidade:</label>
            <div class="quantidade">
            <button type="button" onclick="diminuirQuantidade(); calcularValores()">−</button>
            <input type="number" name="quantidade" id="quantidade" value="1" min="1" readonly>
            <button type="button" onclick="aumentarQuantidade(); calcularValores()">+</button>
            </div>
            
            <!-- Endereço -->
            <div id="endereco-usuario" class="mt-3">
            <strong>Endereço de entrega:</strong><br>
            <?= htmlspecialchars($endereco["rua"]) ?>, <?= htmlspecialchars($endereco["bairro"]) ?><br>
            <?= htmlspecialchars($endereco["cidade"]) ?> - <?= htmlspecialchars($endereco["estado"]) ?><br>
            CEP: <?= htmlspecialchars($endereco["cep"]) ?>
            </div>
            <input type="hidden" id="estadoUsuario" value="<?= htmlspecialchars($endereco["estado"]) ?>">

                <!-- Área de valores -->
            <div id="valores">
                <p id="valor-frete">Valor do Frete: </p>
                <p id="valor-total">Valor Total: Calculando: </p>
            </div>

            <!-- Botão de envio -->
            <button type="submit" class="comprar">Comprar</button>
        </form>

        <div class="star-rating">
            <span class="star">&#9734;</span>
            <span class="star">&#9734;</span>
            <span class="star">&#9734;</span>
            <span class="star">&#9734;</span>
            <span class="star">&#9734;</span>
        </div>


    </div>
    <!-- <img id="flor_direita" src="../assets/images/canto-direito-produto.svg" alt="Flores canto esquerdo da tela"> -->

    <?php require "../components/footer.php"; ?>

<script src="../js/purchase.js"></script>
<script src="../js/shipping_states.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        calcularValores(); // calcula o valor inicial com base no estado do usuário

        // recalcular também se a cor for alterada, se necessário
        document.getElementById("quantidade").addEventListener("change", calcularValores);
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>