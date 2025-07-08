<?php
class Agendamento
{
    private $conn;

    public function __construct($conexao)
    {
        $this->conn = $conexao;
    }

    public function listarTodos()
    {
        $sql = "SELECT * FROM agendamentos ORDER BY data_consulta ASC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function salvar($nome, $email, $telefone, $data, $hora)
    {
        $stmt = $this->conn->prepare("INSERT INTO agendamentos (nome_cliente, email_cliente, telefone_cliente, data_consulta, hora_consulta) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nome, $email, $telefone, $data, $hora);
        return $stmt->execute();
    }

    public function buscarPorId($id)
    {
        $id = intval($id);
        $stmt = $this->conn->prepare("SELECT * FROM agendamentos WHERE id = ? LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function atualizar($id, $nome, $email, $telefone, $data, $hora, $status)
    {
        $stmt = $this->conn->prepare("UPDATE agendamentos SET nome_cliente = ?, email_cliente = ?, telefone_cliente = ?, data_consulta = ?, hora_consulta = ?, status = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $nome, $email, $telefone, $data, $hora, $status, $id);
        return $stmt->execute();
    }

    public function excluir($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM agendamentos WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
