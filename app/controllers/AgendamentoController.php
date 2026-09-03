<?php

class AgendamentoController extends Controller
{
    private $agendamentoModel;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->agendamentoModel = new Agendamento();
    }


    // ###############################################
    // BACK-END - DASHBOARD
    #################################################//

    // 1- Método para listar todos os serviços

    public function listar()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }


        $dados = array();
        $func = new Funcionario();
        $dadosFunc = $func->buscarFunc($_SESSION['userEmail']);

        $dados['agendamentos'] = $this->agendamentoModel->getTodosAgendamentosDashboard();
        $dados['conteudo'] = 'dash/agendamento/listar';
        $dados['func'] = $dadosFunc;

        $this->carregarViews('dash/dashboard', $dados);
    }


    public function editar($id = null)
    {
        $dados = [];

        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        if ($id === null) {
            header('Location:' . BASE_URL . 'agendamento/listar');
            exit;
        }

        $funcionarioModel = new Funcionario();
        $servicoModel = new Servico();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_funcionario = filter_input(INPUT_POST, 'id_funcionario', FILTER_SANITIZE_NUMBER_INT);
            $id_servico = filter_input(INPUT_POST, 'id_servico', FILTER_SANITIZE_NUMBER_INT);
            $data_agendamento = filter_input(INPUT_POST, 'data_agendamento', FILTER_SANITIZE_STRING);
            $status_agendamento = filter_input(INPUT_POST, 'status_agendamento', FILTER_SANITIZE_STRING);

            if ($id_funcionario && $id_servico && $data_agendamento && $status_agendamento) {
                // Ajusta o formato da data para o formato MySQL 'YYYY-MM-DD HH:MM:SS'
                $data_agendamento = str_replace('T', ' ', $data_agendamento) . ':00';

                $dadosAgendamento = [
                    'id_funcionario'    => $id_funcionario,
                    'id_servico'        => $id_servico,
                    'data_agendamento'  => $data_agendamento,
                    'status_agendamento' => $status_agendamento
                ];

                $resultado = $this->agendamentoModel->atualizarAgendamento($id, $dadosAgendamento);

                if ($resultado) {
                    $_SESSION['mensagem'] = "Agendamento atualizado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location:' . BASE_URL . 'agendamento/listar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao atualizar o agendamento.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }

        $agendamento = $this->agendamentoModel->getAgendamentoById($id);

        if (!$agendamento) {
            $_SESSION['mensagem'] = "Agendamento não encontrado.";
            $_SESSION['tipo-msg'] = "erro";
            header('Location:' . BASE_URL . 'agendamento/listar');
            exit;
        }

        $dados['funcionarios'] = $funcionarioModel->getListarFuncionarios();
        $dados['servicos'] = $servicoModel->getTodosServicos();
        $dados['agendamento'] = $agendamento;
        $dados['conteudo'] = 'dash/agendamento/editar';

        $this->carregarViews('dash/dashboard', $dados);
    }


    public function adicionar()
    {
        $this->verificaAcesso('cliente');

        $dados = ['conteudo' => 'dash/agendamento/adicionar'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente_id     = $_SESSION['userId'];
            $funcionario_id = filter_input(INPUT_POST, 'funcionario_id', FILTER_SANITIZE_NUMBER_INT);
            $servico_id     = filter_input(INPUT_POST, 'servico_id', FILTER_SANITIZE_NUMBER_INT);
            $horario_id     = filter_input(INPUT_POST, 'horario_id', FILTER_SANITIZE_NUMBER_INT);
            $status         = 'Agendado'; // padrão

            if ($cliente_id && $funcionario_id && $servico_id && $horario_id) {
                $dadosAgendamento = [
                    'cliente_id'     => $cliente_id,
                    'funcionario_id' => $funcionario_id,
                    'servico_id'     => $servico_id,
                    'horario_id'     => $horario_id,
                    'status'         => $status,
                ];

                $idAgendamento = $this->agendamentoModel->addAgendamento($dadosAgendamento);

                if ($idAgendamento) {
                    $_SESSION['mensagem'] = "Agendamento realizado com sucesso!";
                    $_SESSION['tipo-msg'] = "sucesso";
                    header('Location:' . BASE_URL . 'agendamento/adicionar');
                    exit;
                } else {
                    $dados['mensagem'] = "Erro ao realizar o agendamento.";
                    $dados['tipo-msg'] = "erro";
                }
            } else {
                $dados['mensagem'] = "Preencha todos os campos obrigatórios.";
                $dados['tipo-msg'] = "erro";
            }
        }

        $dados['servicos'] = (new Servico())->getTodosServicos();
        //$dados['horarios'] = (new Horario())->getTodosHorarios(); // Certifique-se de ter esse método
        $dados['funcionarios'] = (new Funcionario())->getListarFuncionarios();

        $cliente = new Cliente();
        $dados['cliente'] = $cliente->buscarCliente($_SESSION['userEmail']);

        $this->carregarViews('dash/dashboard-cliente', $dados);
    }

    public function desativar($id = null)
    {
        $this->verificaAcesso('funcionario');

        if (!$id) {
            $this->respostaJson(false, "ID inválido.");
        }

        $resultado = $this->agendamentoModel->desativarAgendamento($id);

        if ($resultado) {
            $_SESSION['mensagem'] = "Agendamento cancelado com sucesso.";
            $_SESSION['tipo-msg'] = "sucesso";
            $this->respostaJson(true);
        } else {
            $_SESSION['mensagem'] = "Erro ao cancelar o agendamento.";
            $_SESSION['tipo-msg'] = "erro";
            $this->respostaJson(false, "Falha ao cancelar o agendamento.");
        }
    }

    public function filtrarAgendamentoPorServico($id = null)
    {
        $this->verificaAcesso('funcionario');

        $agendamentos = ($id == null || $id == 'todos')
            ? $this->agendamentoModel->getTodosAgendamentos()
            : $this->agendamentoModel->getAgendamentosPorServico($id);

        if (!empty($agendamentos)) {
            $this->respostaJson(true, null, ['agendamentos' => $agendamentos]);
        } else {
            $this->respostaJson(false, "Nenhum agendamento encontrado.");
        }
    }

    private function verificaAcesso($tipo)
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== $tipo) {
            header('Location:' . BASE_URL);
            exit;
        }
    }

    private function respostaJson($sucesso, $mensagem = null, $dadosExtras = [])
    {
        header('Content-Type: application/json');
        $resposta = ['sucesso' => $sucesso];
        if ($mensagem !== null) {
            $resposta['mensagem'] = $mensagem;
        }
        echo json_encode(array_merge($resposta, $dadosExtras));
        exit;
    }
}
