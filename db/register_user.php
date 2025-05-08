<?php
require_once __DIR__ . '/../db/connection_db.php';
require_once __DIR__ . '/../pages/register.php';

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
        $stmt_endereco = $conn->prepare("INSERT INTO enderecos (usuario_id, cep, estado, cidade, bairro, rua, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_endereco->execute([$usuario_id, $cep, $estado, $cidade, $bairro, $rua, $numero, $complemento]);

        $conn->commit();
// Exibe mensagem de sucesso
        echo "<div style='padding: 10px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px;'>
                Cadastro realizado com sucesso!
              </div>";
    } catch (PDOException $e) {
        // Desfaz a transação em caso de erro
        $conn->rollBack();

        // Exibe mensagem de erro
        echo "<div style='padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px;'>
                Erro ao cadastrar: " . htmlspecialchars($e->getMessage()) . "
              </div>";
    }
} else {
    echo "<div style='padding: 10px; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 5px;'>
            Método não permitido.
          </div>";
}
?>