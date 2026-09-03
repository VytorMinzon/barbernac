<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php require_once('template/head.php'); ?>
    <style>
        /* Estilos para a seção de serviços */
        #service {
            background-color: #1c1c1c;
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .ourheading h2 {
            color: #f0c674;
            font-weight: 700;
        }

        .ourheading p {
            color: #ccc;
            font-size: 1.1rem;
        }

        .service_box {
            padding: 20px;
            border-radius: 12px;
            transition: all 0.3s ease;
            height: 100%;
            background: #111;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            color: #f0c674;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .service_box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(240, 198, 116, 0.7);
        }

        .service_box h3 {
            color: #f0c674;
            margin-top: 0;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .service_box p {
            color: #ccc;
            font-size: 1rem;
            font-style: italic;
            min-height: 70px;
            flex-grow: 1;
        }

        .service_box figure {
            margin: 0 0 15px 0;
            overflow: hidden;
            border-radius: 12px;
            height: 200px;
            background-color: #222;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .service_box figure img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 12px;
            transition: transform 0.3s ease;
        }

        .service_box figure img:hover {
            transform: scale(1.05);
        }

        .btn-primary {
            background-color: #f0c674;
            border-color: #f0c674;
            color: #1c1c1c;
            padding: 12px 30px;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-top: 2rem;
        }

        .btn-primary:hover {
            background-color: #e6b94f;
            border-color: #e6b94f;
            color: #000;
            text-decoration: none;
        }

        /* Owl Carousel ajustes (se precisar) */
        .owl-carousel .item {
            padding: 0 10px;
        }
    </style>
</head>

<body class="main-layout" id="conteudo">

    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="wrapper">
        <?php require_once('template/topo.php'); ?>

        <!-- Cabeçalho -->
        <div class="yellow_bg">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="title">
                            <h2>Nossos Serviços Exclusivos</h2>
                            <p>Qualidade e tradição em cada detalhe</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Serviços -->
        <section id="service" class="service">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <div class="ourheading">
                            <h2>Conheça Nossos<strong class="white"> Serviços</strong></h2>
                            <p>Todos os serviços realizados com produtos premium e técnicas especializadas</p>
                        </div>
                    </div>
                </div>

                <div class="owl-carousel owl-theme mt-4">
                    <?php foreach ($servicos as $servico): ?>
                        <div class="item">
                            <div class="service_box text-center h-100">
                                <figure>
                                    <?php
                                    $img = BASE_URL . "uploads/servico/sem-foto-servico.png"; // imagem padrão

                                    if (!empty($servico['foto_servico'])) {
                                        $caminhoArquivo = BASE_URL . "uploads/" . $servico['foto_servico'];
                                        $headers = @get_headers($caminhoArquivo);
                                        if ($headers && strpos($headers[0], '200') !== false) {
                                            $img = $caminhoArquivo;
                                        }
                                    }
                                    ?>
                                    <img src="<?= htmlspecialchars($img) ?>" alt="<?= htmlspecialchars($servico['nome_servico'], ENT_QUOTES, 'UTF-8') ?>">
                                </figure>
                                <h3><?= htmlspecialchars($servico['nome_servico'], ENT_QUOTES, 'UTF-8') ?></h3>
                                <p><?= htmlspecialchars($servico['descricao_servico'], ENT_QUOTES, 'UTF-8') ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="row mt-5">
                    <div class="col-md-12 text-center">
                        <a href="<?= rtrim(BASE_URL, '/') ?>/precos" class="btn btn-primary btn-lg">Ver Tabela de Preços</a>
                    </div>
                </div>
            </div>
        </section>

        <?php require_once('template/rodape.php'); ?>
    </div>

    <!-- Scripts JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/popper.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
    <script src="<?= BASE_URL ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });

            $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 30,
                nav: false,
                dots: false,
                autoplay: true,
                autoplayTimeout: 4000,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    992: { items: 3 }
                }
            });
        });
    </script>

</body>

</html>
