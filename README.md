# 📅 Sistema de Agendamento de Consultas

Este é um sistema simples de agendamento de consultas desenvolvido com PHP, MySQL, Bootstrap e FullCalendar. Ele permite que os usuários agendem consultas através de um formulário modal e visualizem as consultas marcadas em um calendário interativo.

---

## 🚀 Tecnologias Utilizadas

- **PHP**: Linguagem principal para processamento no backend.
- **MySQL**: Banco de dados para armazenar informações de consultas.
- **Bootstrap**: Framework CSS para estilização responsiva.
- **FullCalendar**: Biblioteca JavaScript para exibir o calendário interativo.
- **HTML/CSS**: Estruturação e design da interface.

---

## 📌 Funcionalidades

- 📋 **Cadastro de consultas**: Insira novas consultas com nome, e-mail, telefone, data e hora.
- 📅 **Visualização no calendário**: Consultas marcadas são exibidas em um calendário interativo.
- ✉️ **Envio de e-mail**: Um e-mail de confirmação é enviado ao usuário após o agendamento.

---

## 📂 Estrutura do Projeto

        agendador-consultas/
        |
        ├── css/
        │   ├── styles.css                # Arquivo de estilos CSS
        │
        ├── includes/                      # Arquivos auxiliares
        │   ├── db.php                     # Conexão com o banco de dados
        │   ├── functions.php               # Funções auxiliares do sistema
        │   ├── send_email.php              # Envio de e-mails (PHPMailer)
        │
        ├── js/
        │   ├── scripts.js                  # Arquivo JavaScript para interatividade
        │
        ├── save/                           # Páginas de retorno para ações
        │   ├── error.php                   # Página de erro
        │   ├── success.php                 # Página de sucesso
        │
        ├── sql/
        │   ├── create_tables.sql           # Script de criação de tabelas no banco de dados
        │
        ├── vendor/                         # Diretório gerenciado pelo Composer
        │   ├── composer/                   # Dependências do Composer
        │   ├── phpmailer/                   # Biblioteca para envio de e-mails
        │   ├── autoload.php                 # Carregamento automático de classes
        │
        ├── add.php                          # Cadastro de dados
        ├── composer.json                    # Configuração do Composer
        ├── composer.lock                    # Registro das dependências
        ├── dashboard.php                    # Painel administrativo
        ├── index.php                        # Página inicial
        ├── login.php                        # Página de login
        ├── logout.php                       # Logout do usuário
        ├── processa_agendamento.php         # Processamento de agendamentos
        ├── README.md                        # Documentação do projeto

---

## ⚙️ Configuração do Ambiente

### 1️⃣ Clonar o Repositório

        git clone https://github.com/seu-usuario/seu-repositorio.git
        cd seu-repositorio
          
### 2️⃣ Configurar o Banco de Dados

1. Criar um banco de dados no MySQL:

        CREATE DATABASE agendamento_consultas;

2. Usar o banco de dados criado:

        USE agendamento_consultas;

3. Criar a tabela para armazenar os agendamentos:

        CREATE TABLE agendamentos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome_cliente VARCHAR(255) NOT NULL,
            email_cliente VARCHAR(255) NOT NULL,
            telefone_cliente VARCHAR(20),
            data_consulta DATE NOT NULL,
            hora_consulta TIME NOT NULL
        );

4. Configurar a conexão no arquivo ``includes/db.php:``

          <?php
          $servername = "localhost"; // Altere para o seu servidor
          $username = "seu_usuario"; // Altere para o seu usuário do MySQL
          $password = "sua_senha";   // Altere para a sua senha do MySQL
          $dbname = "agendamento_consultas"; // Altere para o nome do seu banco de dados
          
          // Cria a conexão
          $conn = new mysqli($servername, $username, $password, $dbname);
          
          // Verifica a conexão
          if ($conn->connect_error) {
              die("Conexão falhou: " . $conn->connect_error);
          }
          ?>

### 3️⃣ Rodar o Projeto

1. Iniciar um servidor local com o XAMPP, WAMP ou um servidor embutido do PHP:

       php -S localhost:8000
   
3. Acessar `http://localhost:8000/add.php` no navegador.

---

## 🛠️ Melhorias Futuras

  - Implementação de autenticação de usuários.
  - Adição de validações mais robustas no frontend e backend.
  - Refatoração do código para uso de PDO ao invés de MySQLi.
  - Integração com APIs de envio de SMS para notificações.
    
---

## 📬 Contato

Se você tiver alguma dúvida ou sugestão, não hesite em me contatar por e-mail: alexsantos.djesus@gmail.com

---

## 🤝 Contribuições

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e enviar pull requests.

---

## 📜 Licença
Este projeto está sob a `licença MIT`. Sinta-se livre para contribuir! 😃

---

## 🎥 Quer ver o sistema em ação? Confira o vídeo abaixo!
[Projeto Sistema de Agendamento de Consultas](https://www.youtube.com/watch?v=AN7uYIhydts&list=PLZQNqVIG-XcI2w0USqe18Me7MPLaME3TA)


---

**Feito com ❤️ por Alex santos.**
