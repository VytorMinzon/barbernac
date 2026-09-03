<?php

class Perfil extends Model

{
    public function buscarCliente($email)
    {

        $sql = "SELECT * FROM clientes WHERE email = :email AND status_cliente = 'Ativo'";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPerfil()
    {

        $sql = "SELECT * FROM clientes";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    /** Atualizar cliente */
    public function atualizarCliente($id, $dados)
    {
        // Constrói a query dinamicamente para atualizar apenas os campos enviados
        $sql = "UPDATE clientes SET ";
        $valores = []; // Guardará os campos a serem atualizados
        $parametros = []; // Guardará os valores a serem inseridos na query preparada.

        foreach ($dados as $campo => $valor) {
            // Garante que apenas colunas válidas sejam atualizadas
            if (!empty($valor) && in_array($campo, [
                'nome',
                'tipo_cliente',
                'cpf_cnpj_cliente',
                'data_nasc_cliente',
                'email',
                'senha',
                'foto_cliente',
                'telefone',
                'id_uf',
                'status_cliente'
            ])) {
                $valores[] = "$campo = :$campo";
                $parametros[":$campo"] = $valor;
            }
        }

        // Se não houver nada para atualizar, retorna falso
        if (empty($valores)) {
            return false;
        }

        $sql .= implode(', ', $valores);
        $sql .= " WHERE id = :id";
        $parametros[":id"] = $id;

        /*
        Exemplo do resultado final da query gerada dinamicament
        UPDATE tbl_cliente SET nome_cliente = :nome_cliente, telefone_cliente = :telefone_cliente WHERE id_cliente = :id_cliente
        */

        $stmt = $this->db->prepare($sql);
        return $stmt->execute($parametros);
    }

    public function atualizarFotoCliente($id, $foto)
    {
        $sql = "UPDATE clientes SET foto_cliente = :foto_cliente WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':foto_cliente', $foto);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }


    public function getClienteById($id)
    {

        $sql = "SELECT * FROM clientes
            where id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
