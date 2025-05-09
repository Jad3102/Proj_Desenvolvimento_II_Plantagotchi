<?php
session_start();
require_once __DIR__ . '/../db/connection_db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Recebe os dados do formulário do usuário
    $nome = $_POST['nome'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $data_nascimento = $_POST['data_nascimento'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $cep = $_POST['cep'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $rua = $_POST['rua'] ?? '';
    $numero = $_POST['numero'] ?? '';
    $complemento = $_POST['complemento'] ?? '';

    // Remove caracteres não numéricos do CPF
$cpf_limpo = preg_replace('/\D/', '', $cpf);

// Verifica se CPF tem exatamente 11 dígitos
if (strlen($cpf_limpo) !== 11) {
    $_SESSION['erro_cadastro'] = "O CPF deve conter exatamente 11 dígitos numéricos.";
    header("Location: ../pages/register.php");
    exit;
}

// Verifica se a data de nascimento é válida e não é futura
$data_nascimento_formatada = DateTime::createFromFormat('Y-m-d', $data_nascimento);
$data_hoje = new DateTime();

if (!$data_nascimento_formatada || $data_nascimento_formatada > $data_hoje) {
    $_SESSION['erro_cadastro'] = "A data de nascimento não pode ser futura.";
    header("Location: ../pages/register.php");
    exit;
}

// Verifica se campos obrigatórios estão vazios
if (empty($nome) || empty($cpf) || empty($data_nascimento) || empty($email) || empty($senha) || empty($cep) || empty($numero)) {
        $_SESSION['erro_cadastro'] = "Por favor, preencha todos os campos obrigatórios.";
        header("Location: ../pages/register.php");
        exit;
}

    try {
        $conn->beginTransaction();

        // Criptografa a senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere usuário
        $stmt_usuario = $conn->prepare("INSERT INTO usuarios (nome, cpf, data_nascimento, email, senha) VALUES (?, ?, ?, ?, ?)");
        $stmt_usuario->execute([$nome, $cpf, $data_nascimento, $email, $senha_hash]);

        $usuario_id = $conn->lastInsertId();

        // Insere endereço
        $stmt_endereco = $conn->prepare("INSERT INTO enderecos (usuario_id, cep, estado, cidade, bairro, rua, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt_endereco->execute([$usuario_id, $cep, $estado, $cidade, $bairro, $rua, $numero, $complemento]);

        $conn->commit();

        $_SESSION['sucesso_cadastro'] = "Cadastro realizado com sucesso!";
        header("Location: ../pages/register.php");
        exit;

    } catch (PDOException $e) {
        $conn->rollBack();
        $_SESSION['erro_cadastro'] = "Erro ao cadastrar. Tente novamente.";
        header("Location: ../pages/register.php");
        exit;
    }
} else {
    $_SESSION['erro_cadastro'] = "Método não permitido.";
    header("Location: ../pages/register.php");
    exit;
}