CREATE TABLE agendamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(100) NOT NULL,
    email_cliente VARCHAR(100) NOT NULL,
    telefone_cliente VARCHAR(30),
    data_consulta DATE NOT NULL,
    hora_consulta TIME NOT NULL,
    status VARCHAR(20) DEFAULT 'pendente' CHECK (status IN ('pendente', 'confirmado', 'cancelado'))
);

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(225) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);