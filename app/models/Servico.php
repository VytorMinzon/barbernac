<?php

class Servico extends Model
{
    public function getServicoAleatorio($limite = 3)
    {
        $sql = "SELECT * FROM tbl_servico WHERE status_servico = 'Ativo' ORDER BY RAND() LIMIT :limite";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTodosServicos()
    {
        $sql = "SELECT * FROM tbl_servico WHERE status_servico = 'Ativo' ORDER BY nome_servico ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTodosAgendamentosServico()
    {
        $sql = "SELECT id_servico, nome_servico, descricao_servico, preco_base_servico, status_servico FROM tbl_servico ORDER BY nome_servico ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListarServicos()
    {
        $sql = "SELECT * FROM tbl_servico WHERE status_servico = 'Ativo' ORDER BY nome_servico ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addServico($dados)
    {
        $sql = "INSERT INTO tbl_servico (
                    nome_servico,
                    descricao_servico,
                    preco_base_servico,
                    tempo_estimado_servico,
                    foto_servico,
                    status_servico
                ) VALUES (
                    :nome_servico,
                    :descricao_servico,
                    :preco_base_servico,
                    :tempo_estimado_servico,
                    :foto_servico,
                    :status_servico
                )";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_servico', $dados['nome_servico']);
        $stmt->bindValue(':descricao_servico', $dados['descricao_servico']);
        $stmt->bindValue(':preco_base_servico', $dados['preco_base_servico']);
        $stmt->bindValue(':tempo_estimado_servico', $dados['tempo_estimado_servico']);
        $stmt->bindValue(':foto_servico', $dados['foto_servico']);
        $stmt->bindValue(':status_servico', $dados['status_servico']);

        $stmt->execute();

        return $this->db->lastInsertId();
    }

    public function atualizarServico($id, $dados)
    {
        $sql = "UPDATE tbl_servico SET
                    nome_servico = :nome_servico,
                    descricao_servico = :descricao_servico,
                    preco_base_servico = :preco_base_servico,
                    tempo_estimado_servico = :tempo_estimado_servico,
                    foto_servico = :foto_servico,
                    status_servico = :status_servico
                WHERE id_servico = :id_servico";

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(':nome_servico', $dados['nome_servico']);
        $stmt->bindValue(':descricao_servico', $dados['descricao_servico']);
        $stmt->bindValue(':preco_base_servico', $dados['preco_base_servico']);
        $stmt->bindValue(':tempo_estimado_servico', $dados['tempo_estimado_servico']);
        $stmt->bindValue(':foto_servico', $dados['foto_servico']);
        $stmt->bindValue(':status_servico', $dados['status_servico']);
        $stmt->bindValue(':id_servico', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getServicoById($id)
    {
        $sql = "SELECT * FROM tbl_servico WHERE id_servico = :id_servico LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_servico', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function desativarServico($id)
    {
        $sql = "UPDATE tbl_servico SET status_servico = 'Inativo' WHERE id_servico = :id_servico";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_servico', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
