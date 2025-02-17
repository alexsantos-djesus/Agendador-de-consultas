<?php
$host = 'localhost';
$dbname = 'agendador_consultas';
$username = 'root'; // Usuário padrão do XAMPP
$password = '';     // Senha padrão do XAMPP

// Criando a conexão com o banco de dados usando MySQLi
$conn = new mysqli($host, $username, $password, $dbname);

// Verificando se houve erro na conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Configurando o charset para UTF-8 (opcional, mas recomendado)
$conn->set_charset("utf8");