CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tarefas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  titulo VARCHAR(255) NOT NULL,
  descricao TEXT,
  status ENUM('pendente','concluida') NOT NULL DEFAULT 'pendente',
  data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nome, email, senha) VALUES 
('Teste', 'teste@email.com', '$2y$10$abcdefghijkExemploSenhaHash');

INSERT INTO tarefas (usuario_id, titulo, descricao, status) VALUES
(1, 'Teste', 'Texto de Teste', 'pendente'),
(1, 'Testando', 'Testando servidor', 'concluida');