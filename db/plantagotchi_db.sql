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

-- Se quiser fazer consulta comum de usuários e os endereços deles
-- SELECT 
--     u.usuario_id,
--     u.nome,
--     u.email,
--     u.senha,
--     e.cep,
--     e.estado,
--     e.cidade,
--     e.bairro,
--     e.rua,
--     e.numero,
--     e.complemento
-- FROM 
--     usuarios u
-- INNER JOIN 
--     enderecos e ON u.usuario_id = e.usuario_id;