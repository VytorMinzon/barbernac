<?php

class ContatoController extends Controller
{
    private $contatos_emails;

    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->contatos_emails = new Contato();
    }

    public function index()
    {
        $dados = array();

        $dados['nome'] = 'cheguei aqui';

        $this->carregarViews('contato', $dados);
    }

    public function enviarEmail()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_SPECIAL_CHARS);
            $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_SPECIAL_CHARS);

            $assunto = "Nova mensagem de contato - BarberNac";

            if ($nome && $email && $telefone && $mensagem) {
                $contatoModel = new Contato();
                $salvo = $contatoModel->salvarContato([
                    'assunto_contato' => $assunto,
                    'nome_contato' => $nome,
                    'email_contato' => $email,
                    'telefone_contato' => $telefone,
                    'mensagem_contato' => $mensagem
                ]);

                if ($salvo) {
                    require_once("vendors/phpmailer/PHPMailer.php");
                    require_once("vendors/phpmailer/SMTP.php");
                    require_once("vendors/phpmailer/Exception.php");

                    try {
                        $phpmail = new PHPMailer\PHPMailer\PHPMailer();
                        $phpmail->isSMTP();
                        $phpmail->SMTPDebug = 0;
                        $phpmail->Host = HOTS_EMAIL;
                        $phpmail->Port = PORT_EMAIL;
                        $phpmail->SMTPSecure = 'ssl';
                        $phpmail->SMTPAuth = true;
                        $phpmail->Username = USER_EMAIL;
                        $phpmail->Password = PASS_EMAIL;
                        $phpmail->setFrom(USER_EMAIL, 'BarberNac - Contato');
                        $phpmail->addAddress(USER_EMAIL, 'Atendimento');
                        $phpmail->isHTML(true);
                        $phpmail->CharSet = 'UTF-8';

                        // E-mail para a barbearia
                        $phpmail->Subject = '📩 Nova Mensagem de Contato - BarberNac';
                        $phpmail->Body = "
                        <h2 style='color:#f0c674;'>Nova mensagem de contato recebida</h2>
                        <ul>
                            <li><strong>Nome:</strong> $nome</li>
                            <li><strong>Email:</strong> $email</li>
                            <li><strong>Telefone:</strong> $telefone</li>
                            <li><strong>Mensagem:</strong> $mensagem</li>
                        </ul>
                    ";
                        $phpmail->AltBody = "Nome: $nome\nEmail: $email\nTelefone: $telefone\nMensagem: $mensagem";
                        $phpmail->send();

                        // Confirmação para o cliente
                        $phpmail->clearAddresses();
                        $phpmail->addAddress($email, $nome);
                        $phpmail->Subject = '✅ Recebemos sua mensagem - BarberNac';
                        $phpmail->Body = "
                        <h2 style='color:#f0c674;'>Olá, $nome!</h2>
                        <p>Recebemos sua mensagem e em breve nossa equipe entrará em contato com você.</p>
                        <p><strong>Sua mensagem:</strong> $mensagem</p>
                        <p>Obrigado por falar conosco!<br><strong>Equipe BarberNac</strong></p>
                    ";
                        $phpmail->AltBody = "Olá $nome!\nRecebemos sua mensagem:\n$mensagem\nEm breve entraremos em contato.\nEquipe BarberNac";
                        $phpmail->send();

                        header('Location: ' . BASE_URL . 'contato?sucesso=1');
                        exit;
                    } catch (Exception $e) {
                        error_log("Erro ao enviar e-mail: " . $phpmail->ErrorInfo);
                    }
                }
            }
        }

        header('Location: ' . BASE_URL . 'contato?sucesso=0');
        exit;
    }

    public function contato()
    {
        if (!isset($_SESSION['userTipo']) || $_SESSION['userTipo'] !== 'Funcionario') {
            header('Location:' . BASE_URL);
            exit;
        }

        $dados = array();
        $dados['listarEmails'] = $this->contatos_emails->emails_contatos();
        $dados['conteudo'] = 'dash/contato/contato';

        $this->carregarViews('dash/dashboard', $dados);
    }
}
