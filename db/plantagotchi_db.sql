USE plantagotchi_db;

CREATE TABLE usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE enderecos (
    endereco_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    cep VARCHAR(10) NOT NULL,
    estado VARCHAR(2) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    bairro VARCHAR(100) NOT NULL,
    rua VARCHAR(255) NOT NULL,
    numero VARCHAR(10),
    complemento VARCHAR(255),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id) ON DELETE CASCADE /*ON DELETE CASCADE é usado para deletar os dados da tabela filha se na tabela pai for removido*/
);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

CREATE TABLE produtos (
    produto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco_unitario DECIMAL(10, 2) NOT NULL,
    ativo BOOLEAN DEFAULT TRUE
);

CREATE TABLE pedidos (
    pedido_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    produto_id INT NOT NULL,
    cor VARCHAR(50),
    quantidade INT NOT NULL,
    preco_total DECIMAL(10, 2) NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Aguardando pagamento',
    criado_em DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(produto_id)
);
