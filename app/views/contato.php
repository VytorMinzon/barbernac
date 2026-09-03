<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BarberNac - Contato</title>
    <meta name="keywords" content="contato barbearia, agendamento, localização, horário barbearia">
    <meta name="description" content="Entre em contato com a Barbearia Corte & Estilo para agendamentos e informações.">
    <meta name="Vytor Minzon" content="Barbearia Corte & Estilo">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            background-color: #1c1c1c;
            color: #f0c674;
        }

        .form-control,
        .form-select,
        textarea {
            background-color: #2c2c2c;
            color: #fff;
            border: 1px solid #f0c674;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .form-label {
            color: #f0c674;
        }

        .contact_info {
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 8px;
        }

        .info_item {
            margin-bottom: 20px;
        }

        .info_item i {
            color: #ffc107;
            margin-right: 10px;
        }

        .social_icons a {
            font-size: 24px;
            margin-right: 15px;
            color: #f0c674;
        }
    </style>
</head>

<body>

    <?php require_once('template/topo.php'); ?>

    <main>
        <!-- Banner -->
        <div class="yellow_bg py-4 text-center">
            <h2>Fale Conosco</h2>
        </div>

        <section class="contact py-5">
            <div class="container">
                <div class="row mb-4 text-center">
                    <div class="col-12">
                        <h2 class="fw-bold">Fale conosco</h2>
                        <p style="color: #ccc;">Preencha o formulário abaixo para tirar suas dúvidas ou entrar em contato conosco.</p>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Formulário -->
                    <div class="col-lg-6">
                        <form id="formContato" action="<?= BASE_URL ?>contato/enviarEmail" method="post" class="p-4 rounded-3" style="background-color: #2c2c2c;">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" name="nome" id="nome" class="form-control" required placeholder="Seu nome">
                            </div>
                            <div class="mb-3">
                                <label for="telefone" class="form-label">Telefone</label>
                                <input type="tel" name="telefone" id="telefone" class="form-control" required placeholder="(11) 91234-5678" />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control" required placeholder="seuemail@exemplo.com">
                            </div>
                            <div class="mb-3">
                                <label for="mensagem" class="form-label">Mensagem</label>
                                <textarea name="mensagem" id="mensagem" rows="4" class="form-control" placeholder="Sua mensagem"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning fw-bold text-dark w-100">
                                    Enviar Mensagem
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Informações de Contato -->
                    <div class="col-lg-6">
                        <div class="contact_info">
                            <h3>Informações de Contato</h3>
                            <div class="info_item">
                                <i class="fa fa-map-marker"></i> Rua dos Barbeiros, 123 - Centro, São Paulo - SP
                            </div>
                            <div class="info_item">
                                <i class="fa fa-phone"></i> (11) 98765-4321 | (11) 2345-6789
                            </div>
                            <div class="info_item">
                                <i class="fa fa-envelope"></i> contato@barbernac.com
                            </div>
                            <div class="info_item">
                                <i class="fa fa-clock-o"></i> Seg-Sex: 9h às 19h | Sáb: 9h às 18h | Dom: Fechado
                            </div>
                            <div class="social_icons">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                                <a href="#"><i class="fa fa-whatsapp"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal de sucesso -->
    <div class="modal fade" id="exampleModalFormContato" tabindex="-1" aria-labelledby="exampleModalLabelFormContato" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Status do Envio</h1>
                    <button type="button" class="btn-close bg-light" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body" id="modalMessageFormContato">
                    O formulário foi enviado com sucesso!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning text-dark" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <?php require_once('template/rodape.php'); ?>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Inputmask para formatação do telefone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8/jquery.inputmask.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#telefone').inputmask({
                mask: '(99) 99999-9999',
                placeholder: '_',
                showMaskOnHover: false,
                clearIncomplete: true
            });
        });

        // Mostrar modal de sucesso se "sucesso=1" estiver na URL
        document.addEventListener('DOMContentLoaded', () => {
            const modal = new bootstrap.Modal(document.getElementById('exampleModalFormContato'));
            const urlParams = new URLSearchParams(window.location.search);
            const sucesso = urlParams.get('sucesso');

            if (sucesso == '1') {
                modal.show();
            }
        });
    </script>
</body>

</html>
