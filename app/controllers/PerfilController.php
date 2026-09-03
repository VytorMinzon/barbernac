<?php

class PerfilController extends Controller
{
    private $perfilModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->perfilModel = new Perfil();
    }

    // Método para listar o perfil do cliente logado
    public function listar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'cliente') {
            header('Location:' . BASE_URL);
            exit;
        }

        $clienteId = $_SESSION['userId'] ?? null;
        if (!$clienteId) {
            header('Location:' . BASE_URL);
            exit;
        }

        $cliente = $this->perfilModel->getClienteById($clienteId);

        $dados = [
            'cliente' => $cliente,
            'conteudo' => 'dash/perfil/listar'
        ];

        $this->carregarViews('dash/dashboard-cliente', $dados);
    }

    // Método para editar o perfil do cliente logado
    public function editar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'cliente') {
            header('Location:' . BASE_URL);
            exit;
        }

        $clienteId = $_SESSION['userId'] ?? null;
        if ($clienteId === null) {
            $_SESSION['mensagem'] = "ID do cliente não informado!";
            $_SESSION['tipo-msg'] = "erro";
            header('Location: ' . BASE_URL);
            exit;
        }

        $cliente = $this->perfilModel->getClienteById($clienteId);
        if (!$cliente) {
            $_SESSION['mensagem'] = "Cliente não encontrado!";
            $_SESSION['tipo-msg'] = "erro";
            header('Location: ' . BASE_URL);
            exit;
        }

        $dados = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome             = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email            = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $telefone         = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
            $data_nasc        = filter_input(INPUT_POST, 'data_nasc_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_cliente     = filter_input(INPUT_POST, 'tipo_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $cpf_cnpj         = filter_input(INPUT_POST, 'cpf_cnpj_cliente', FILTER_SANITIZE_SPECIAL_CHARS);
            $id_uf            = filter_input(INPUT_POST, 'id_uf', FILTER_SANITIZE_NUMBER_INT);
            $senha_post       = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);

            // Upload da foto, se houver
            if (isset($_FILES['foto_cliente']) && $_FILES['foto_cliente']['error'] === 0) {
                $foto_cliente = $this->uploadFoto($_FILES['foto_cliente']);
            } else {
                $foto_cliente = $cliente['foto_cliente']; // mantém a foto atual
            }

            // Mantém senha atual caso não tenha enviado nova senha
            $senha = $cliente['senha'];
            if (!empty($senha_post)) {
                // Aqui pode fazer hash da senha, se for o caso
                $senha = password_hash($senha_post, PASSWORD_DEFAULT);
            }

            if ($nome && $email) {
                $dadosCliente = [
                    'nome'             => $nome,
                    'email'            => $email,
                    'senha'            => $senha,
                    'telefone'         => $telefone,
                    'data_nasc_cliente' => $data_nasc,
                    'tipo_cliente'     => $tipo_cliente,
                    'cpf_cnpj_cliente' => $cpf_cnpj,
                    'foto_cliente'     => $foto_cliente,
                    'id_uf'            => $id_uf
                ];

                $atualizado = $this->perfilModel->atualizarCliente($clienteId, $dadosCliente);

                if ($atualizado) {
                    $_SESSION['mensagem'] = "Perfil atualizado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: ' . BASE_URL . 'perfil/editar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao atualizar o perfil.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha os campos obrigatórios!";
                $dados['tipo-msg'] = "erro";
            }
        }

        $dados['cliente'] = $cliente;

        // Carregar estados (UF) para select, se precisar
        $estadoModel = new Estado();
        $dados['estados'] = $estadoModel->getListarEstados();

        $dados['conteudo'] = 'dash/perfil/editar';
        $this->carregarViews('dash/dashboard-cliente', $dados);
    }

    // Método para upload da foto
    private function uploadFoto($file)
    {
        $dir = $_SERVER['DOCUMENT_ROOT'] . '/barbernac/public/uploads/clientes/';

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $nome_arquivo = uniqid('cliente_') . '.' . $ext;

        $caminhoCompleto = $dir . $nome_arquivo;

        if (move_uploaded_file($file['tmp_name'], $caminhoCompleto)) {
            return $nome_arquivo; // só retorna o nome do arquivo, para salvar no DB
        }

        return false;
    }
}
