<!-- Vamos usar password_hash para criptrografar as senhas, o exemplo que tenho que é com sha1 serve apenas para codificar e é fácil de reverter -->

<?php
require_once "../db/connection_db.php"; // Arquivo com sua conexão ao banco de dados
require "../pages/register.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recebe os dados do formulário do usuário
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $data_nascimento = $_POST['data_nascimento'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Criptografa a senha

    // Endereço do usuário
    $cep = $_POST['cep'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $numero = $_POST['numero'];
    $complemento = $_POST['complemento'];

// Usar o PDO possibilita usar os métodos prepare e execute para interagir com o banco de modo mais fácil e moderno

    try {
        // Conexão ao banco
        $conn->beginTransaction();

        // Insere na tabela usuarios
        $stmt_usuario = $conn->prepare("INSERT INTO usuarios (nome, cpf, data_nascimento, email, senha) VALUES (?, ?, ?, ?, ?)");
        $stmt_usuario ->execute([$nome, $cpf, $data_nascimento, $email, $senha]);

        // Pega o ID do usuário recém-criado
        $usuario_id = $conn->lastInsertId();

        // Insere na tabela enderecos
        $stmt_endereco = $conn->prepare("INSERT INTO enderecos (usuario_id, cep, estado, cidade, bairro, rua, numero, complemento)
                                 VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_endereco->execute([$usuario_id, $cep, $estado, $cidade, $bairro, $rua, $numero, $complemento]);

        $conn->commit();
        exit;
        // DEVE EXIBIR AQUI UMA MENSAGEM DE SUCESSO OU DIRECIONAR O USUÁRIO AO LOGIN

    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
} else {
    echo "Método não permitido.";
}