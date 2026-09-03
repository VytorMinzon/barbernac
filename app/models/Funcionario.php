<?php

class Funcionario extends Model
{
    // Buscar funcionário pelo e-mail
    public function buscarFunc($email)
    {
        $sql = "SELECT * FROM funcionarios WHERE email = :email";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Listar todos os funcionários
    public function getListarFuncionarios()
    {
        $sql = "SELECT * FROM funcionarios WHERE status_funcionario = 'Ativo'";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    //Adicionar um novo Funcionário
    public function addFuncionario($dados)
    {
        $sql = "INSERT INTO funcionarios (
                nome_funcionario,
                telefone,
                email,
                senha,
                cargo,
                salario_funcionario,
                foto_funcionario,
                tipo_funcionario,
                cpf_cnpj_funcionario,
                id_uf,
                status_funcionario
            ) VALUES (
                :nome_funcionario,
                :telefone,
                :email,
                :senha,
                :cargo,
                :salario_funcionario,
                :foto_funcionario,
                :tipo_funcionario,
                :cpf_cnpj_funcionario,
                :id_uf,
                :status_funcionario
            )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nome_funcionario', $dados['nome_funcionario']);
        $stmt->bindValue(':telefone', $dados['telefone']);
        $stmt->bindValue(':email', $dados['email']);
        $stmt->bindValue(':senha', password_hash($dados['senha'], PASSWORD_DEFAULT));
        $stmt->bindValue(':cargo', $dados['cargo']);
        $stmt->bindValue(':salario_funcionario', $dados['salario_funcionario']);
        $stmt->bindValue(':foto_funcionario', $dados['foto_funcionario']);
        $stmt->bindValue(':tipo_funcionario', $dados['tipo_funcionario']);
        $stmt->bindValue(':cpf_cnpj_funcionario', $dados['cpf_cnpj_funcionario']);
        $stmt->bindValue(':id_uf', $dados['id_uf'], PDO::PARAM_INT);
        $stmt->bindValue(':status_funcionario', $dados['status_funcionario']);

        $stmt->execute();
        return $this->db->lastInsertId();
    }

    // Atualizar funcionário
    public function atualizarFuncionario($id, $dados)
    {
        $sql = "UPDATE funcionarios SET 
                nome_funcionario = :nome_funcionario,
                telefone = :telefone,
                cargo = :cargo,
                salario_funcionario = :salario_funcionario,
                id_uf = :id_uf,
                email = :email,
                senha = :senha,
                tipo_funcionario = :tipo_funcionario,
                cpf_cnpj_funcionario = :cpf_cnpj_funcionario,
                status_funcionario = :status_funcionario";

        // Verifica se a foto foi enviada
        if (!empty($dados['foto_funcionario'])) {
            $sql .= ", foto_funcionario = :foto_funcionario";
        }

        $sql .= " WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_funcionario', $dados['nome_funcionario']);
        $stmt->bindValue(':telefone', $dados['telefone']);
        $stmt->bindValue(':cargo', $dados['cargo']);
        $stmt->bindValue(':salario_funcionario', $dados['salario_funcionario']);
        $stmt->bindValue(':id_uf', $dados['id_uf'], PDO::PARAM_INT);
        $stmt->bindValue(':email', $dados['email']);
        $stmt->bindValue(':senha', $dados['senha']);
        $stmt->bindValue(':tipo_funcionario', $dados['tipo_funcionario']);
        $stmt->bindValue(':cpf_cnpj_funcionario', $dados['cpf_cnpj_funcionario']);
        $stmt->bindValue(':status_funcionario', $dados['status_funcionario']);

        if (!empty($dados['foto_funcionario'])) {
            $stmt->bindValue(':foto_funcionario', $dados['foto_funcionario']);
        }

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }



    // Método para buscar os dados de Funcionário de acordo com o ID
    public function getFuncionarioById($id)
    {
        $sql = "SELECT f.*, e.nome_uf, e.sigla_uf 
        FROM funcionarios f
        LEFT JOIN estado e ON f.id_uf = e.id_uf
        WHERE f.id = :id
        LIMIT 1;";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function desativarFuncionario($id)
    {
        $sql = "UPDATE funcionarios SET status_funcionario = 'Inativo' WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
