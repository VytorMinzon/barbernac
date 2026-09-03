<?php

class ServicoController extends Controller
{
    private $servicoModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->servicoModel = new Servico();
    }

    // FRONT-END: lista de serviços
    public function index()
    {
        $dados = [];
        $dados['titulo'] = 'Serviços - BarberNac';
        $dados['servico'] = $this->servicoModel->getTodosServicos();
        $this->carregarViews('servico', $dados);
    }

    // FRONT-END: detalhe do serviço pelo ID
    public function detalhe($id)
    {
        $dados = [];

        $detalheServico = $this->servicoModel->getServicoById($id);

        if ($detalheServico) {
            $dados['titulo'] = $detalheServico['nome_servico'];
            $dados['detalhe'] = $detalheServico;
            $this->carregarViews('detalhe-servicos', $dados);
        } else {
            $dados['titulo'] = 'Serviços BarberNac';
            $this->carregarViews('servico', $dados);
        }
    }

    // BACK-END - DASHBOARD

    // Listar serviços
    public function listar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        $dados = [];
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados['listaServico'] = $this->servicoModel->getListarServicos();
        $dados['conteudo'] = 'dash/servico/listar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // Adicionar serviço
    public function adicionar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        $dados = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_servico = filter_input(INPUT_POST, 'nome_servico', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao_servico = filter_input(INPUT_POST, 'descricao_servico', FILTER_SANITIZE_SPECIAL_CHARS);
            $preco_base_servico = filter_input(INPUT_POST, 'preco_base_servico', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $tempo_estimado_servico = filter_input(INPUT_POST, 'tempo_estimado_servico');
            $status_servico = filter_input(INPUT_POST, 'status_servico', FILTER_SANITIZE_SPECIAL_CHARS);

            $foto_servico = null;
            if (isset($_FILES['foto_servico']) && $_FILES['foto_servico']['error'] === 0) {
                $upload = $this->uploadFoto($_FILES['foto_servico']);
                if ($upload !== null) {
                    $foto_servico = $upload;
                } else {
                    $_SESSION['mensagem'] = "Erro ao enviar a imagem.";
                    $_SESSION['tipo-msg'] = "erro";
                    header('Location:' . BASE_URL . 'servico/adicionar');
                    exit;
                }
            }

            if ($nome_servico && $descricao_servico && $preco_base_servico !== false && $status_servico) {
                $dadosServico = [
                    'nome_servico' => $nome_servico,
                    'descricao_servico' => $descricao_servico,
                    'preco_base_servico' => $preco_base_servico,
                    'tempo_estimado_servico' => $tempo_estimado_servico,
                    'foto_servico' => $foto_servico,
                    'status_servico' => $status_servico
                ];

                $id_servico = $this->servicoModel->addServico($dadosServico);

                if ($id_servico) {
                    $_SESSION['mensagem'] = "Serviço adicionado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location: ' . BASE_URL . 'servico/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao adicionar o serviço.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios corretamente.";
                $dados['tipo-msg'] = "erro";
            }
        }

        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados['conteudo'] = 'dash/servico/adicionar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }

    // Editar serviço
    public function editar($id = null)
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        if ($id === null) {
            header('Location:' . BASE_URL . 'servico/listar');
            exit;
        }

        $servicoExistente = $this->servicoModel->getServicoById($id);
        if (!$servicoExistente) {
            $_SESSION['mensagem'] = "Serviço não encontrado.";
            $_SESSION['tipo-msg'] = "erro";
            header('Location:' . BASE_URL . 'servico/listar');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome_servico = filter_input(INPUT_POST, 'nome_servico', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao_servico = filter_input(INPUT_POST, 'descricao_servico', FILTER_SANITIZE_SPECIAL_CHARS);
            $preco_base_servico = filter_input(INPUT_POST, 'preco_base_servico', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $tempo_estimado_servico = filter_input(INPUT_POST, 'tempo_estimado_servico');
            $status_servico = filter_input(INPUT_POST, 'status_servico', FILTER_SANITIZE_SPECIAL_CHARS);

            $foto_servico = $servicoExistente['foto_servico']; // manter foto atual caso não envie outra
            if (isset($_FILES['foto_servico']) && $_FILES['foto_servico']['error'] === 0) {
                $uploadFoto = $this->uploadFoto($_FILES['foto_servico']);
                if ($uploadFoto) {
                    $foto_servico = $uploadFoto;
                } else {
                    $_SESSION['mensagem'] = "Erro ao enviar a imagem.";
                    $_SESSION['tipo-msg'] = "erro";
                    header('Location:' . BASE_URL . 'servico/editar/' . $id);
                    exit;
                }
            }

            if ($nome_servico && $descricao_servico && $preco_base_servico !== false && $status_servico) {
                $dadosServico = [
                    'nome_servico' => $nome_servico,
                    'descricao_servico' => $descricao_servico,
                    'preco_base_servico' => $preco_base_servico,
                    'tempo_estimado_servico' => $tempo_estimado_servico,
                    'foto_servico' => $foto_servico,
                    'status_servico' => $status_servico
                ];

                $sucesso = $this->servicoModel->atualizarServico($id, $dadosServico);

                if ($sucesso) {
                    $_SESSION['mensagem'] = "Serviço atualizado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location:' . BASE_URL . 'servico/listar');
                    exit;
                } else {
                    $_SESSION['mensagem'] = "Nenhuma alteração foi feita ou ocorreu um erro.";
                    $_SESSION['tipo-msg'] = "aviso";
                }
            } else {
                $_SESSION['mensagem'] = "Preencha todos os campos obrigatórios corretamente.";
                $_SESSION['tipo-msg'] = "erro";
            }
        }

        $dados = [];
        $dados['servico'] = $servicoExistente;

        $func = new Funcionario();
        $dados['func'] = $func->buscarFunc($_SESSION['userEmail']);

        $dados['conteudo'] = 'dash/servico/editar';

        $this->carregarViews('dash/dashboard', $dados);
    }

    // Desativar serviço
    public function desativar($id)
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        if ($id) {
            $resultado = $this->servicoModel->desativarServico($id);

            if ($resultado) {
                $_SESSION['mensagem'] = "Serviço desativado com sucesso!";
                $_SESSION['tipo-msg'] = "sucesso";
            } else {
                $_SESSION['mensagem'] = "Erro ao desativar serviço.";
                $_SESSION['tipo-msg'] = "erro";
            }
        }

        header('Location:' . BASE_URL . 'servico/listar');
        exit;
    }

    // Upload da foto do serviço
    private function uploadFoto($file)
    {
        $dir = '../public/uploads/servico/';

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Permitir somente extensões comuns de imagem
        $extPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        if (!in_array($ext, $extPermitidas)) {
            return false;
        }

        $nomeArquivo = uniqid() . '.' . $ext;
        $caminhoCompleto = $dir . $nomeArquivo;

        if (move_uploaded_file($file['tmp_name'], $caminhoCompleto)) {
            // Retorna caminho relativo com pasta, igual ao funcionário
            return 'servico/' . $nomeArquivo;
        }

        return false;
    }
}
