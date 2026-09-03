<?php

class Contato extends Model
{

    //Salvar o email na base de dados
    public function salvarContato($dados)
    {
        $sql = "INSERT INTO tbl_contato(assunto_contato, nome_contato, email_contato, telefone_contato, mensagem_contato)
            VALUES (:assuntoContato, :nomeContato, :emailContato, :telContato, :mensContato)";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':assuntoContato', $dados['assunto_contato']);
        $stmt->bindValue(':nomeContato', $dados['nome_contato']);
        $stmt->bindValue(':emailContato', $dados['email_contato']);
        $stmt->bindValue(':telContato', $dados['telefone_contato']);
        $stmt->bindValue(':mensContato', $dados['mensagem_contato']);

        return $stmt->execute();
    }


    public function emails_contatos()
    {

        $sql = "SELECT * FROM tbl_contato";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
