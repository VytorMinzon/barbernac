<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>BarberNac</title>
    <meta name="keywords" content="barbeiros profissionais, equipe barbearia, especialistas em corte, barba designer" />
    <meta name="description" content="Conheça nossa equipe de barbeiros profissionais na Barbearia Corte & Estilo. Especialistas em cortes modernos e cuidados masculinos." />
    <meta name="Vytor Minzon" content="Barbearia Corte & Estilo" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/responsive.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <style>
        /* --- Reset e melhorias gerais --- */
        body {
            background-color: #fdfdfd;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #444;
            line-height: 1.6;
        }

        h2,
        h3,
        h4 {
            font-weight: 700;
            color: #222;
        }

        /* --- Títulos principais --- */
        .yellow_bg {
            background: #ffc107;
            color: #212529;
            padding: 2rem 0;
            text-align: center;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            box-shadow: 0 2px 8px rgb(255 193 7 / 0.5);
        }

        /* --- Seção dos barbeiros --- */
        .ourheading {
            text-align: center;
            margin-bottom: 3rem;
        }

        .ourheading h2 {
            font-size: 2.8rem;
        }

        .ourheading strong.white {
            color: #ffc107;
        }

        .ourheading span {
            font-size: 1.1rem;
            color: #6c757d;
            display: block;
            margin-top: 0.5rem;
        }

        /* --- Card do barbeiro --- */
        .owl-carousel .item {
            background: #111;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            padding-bottom: 1rem;
            margin: 0 10px;
        }

       
        /* Ajuste container da imagem para proporção fixa */
        .product_blog_img {
            position: relative;
            width: 180px;
            /* largura fixa */
            height: 180px;
            /* altura fixa igual à largura para ser círculo */
            overflow: hidden;
            border-radius: 50%;
            /* torna o container circular */
            margin: 0 auto 1rem;
            /* centraliza o círculo horizontalmente e dá espaço abaixo */
        }

        /* Imagem que preenche o container sem distorcer */
        .product_blog_img img {
            position: absolute;
            top: 50%;
            left: 50%;
            width: auto;
            height: 100%;
            transform: translate(-50%, -50%);
            object-fit: cover;
            object-position: center;
            display: block;
            transition: none;
            /* tira o efeito de transição também */
            max-width: none;
        }



        .product_blog_cont {
            padding: 1rem 1.2rem;
            text-align: center;
        }

        .product_blog_cont h3 {
            font-size: 1.5rem;
            margin-bottom: 0.25rem;
        }

        .product_blog_cont h4 {
            font-weight: 600;
            font-size: 1.1rem;
            color: #ff8c00;
            margin-bottom: 0.5rem;
        }

        .product_blog_cont p {
            font-size: 0.95rem;
            font-style: italic;
            color: #fff;
            min-height: 50px;
        }

        /* --- Descrição da equipe --- */
        .team_description {
            background: #fff;
            padding: 2.5rem 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgb(0 0 0 / 0.07);
            margin-top: 4rem;
            max-width: 900px;
            margin-left: auto;
            margin-right: auto;
        }

        .team_description h3 {
            margin-bottom: 1rem;
            font-size: 2rem;
            color: #212529;
            text-align: center;
        }

        .team_description p {
            font-size: 1.1rem;
            color: #444;
            text-align: justify;
            line-height: 1.6;
            margin-bottom: 1.8rem;
        }

        .team_description a.btn-primary {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
            font-weight: 600;
            padding: 0.75rem 1.5rem;
            font-size: 1.1rem;
            display: block;
            max-width: 280px;
            margin: 0 auto;
            border-radius: 50px;
            transition: background-color 0.3s ease, color 0.3s ease;
            text-align: center;
        }

        .team_description a.btn-primary:hover {
            background-color: #ffca2c;
            color: #212529;
            text-decoration: none;
        }

        /* --- Owl Carousel nav customização --- */
        .owl-nav button.owl-prev,
        .owl-nav button.owl-next {
            background: #ffc107;
            color: #212529;
            border-radius: 50%;
            font-size: 1.5rem;
            padding: 0.3rem 0.6rem;
            position: absolute;
            top: 40%;
            transition: background-color 0.3s ease;
        }

        .owl-nav button.owl-prev:hover,
        .owl-nav button.owl-next:hover {
            background-color: #ffca2c;
            color: #212529;
        }

        .owl-nav button.owl-prev {
            left: -25px;
        }

        .owl-nav button.owl-next {
            right: -25px;
        }

        .owl-dots {
            margin-top: 1.2rem;
            text-align: center;
        }

        .owl-dot {
            display: inline-block;
            width: 14px;
            height: 14px;
            background: #ddd;
            border-radius: 50%;
            margin: 0 5px;
            transition: background-color 0.3s ease;
            cursor: pointer;
        }

        .owl-dot.active,
        .owl-dot:hover {
            background: #ffc107;
        }

        /* --- Responsividade customizada --- */
        @media (max-width: 767.98px) {
            .product_blog_img {
                aspect-ratio: 3 / 2;
            }

            .ourheading h2 {
                font-size: 2rem;
            }

            .team_description p {
                font-size: 1rem;
            }
        }

        @media (max-width: 479.98px) {
            .product_blog_img {
                aspect-ratio: 1 / 1;
            }

            .team_description {
                padding: 1.5rem 1rem;
            }

            .team_description h3 {
                font-size: 1.6rem;
            }
        }
    </style>
</head>

<body class="main-layout" id="conteudo">

    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="wrapper">
        <?php require_once('template/topo.php'); ?>

        <div class="yellow_bg">
            <div class="container">
                <h2>Nossa Equipe de Especialistas</h2>
            </div>
        </div>

        <!-- nossos barbeiros -->
        <section class="resip_section py-5">
            <div class="container">
                <div class="ourheading">
                    <h2>Conheça <strong class="white">Nossos Barbeiros</strong></h2>
                    <span>Profissionais qualificados prontos para oferecer o melhor serviço</span>
                </div>

                <div class="owl-carousel owl-theme">
                    <?php foreach ($funcionarios as $funcionario): ?>
                        <?php if ($funcionario['cargo'] == 'Barbeiro'): ?>
                            <div class="item">
                                <div class="product_blog_img">
                                    <?php
                                    $img = BASE_URL . "uploads/sem-foto.jpg";
                                    $fotoFuncionario = trim((string) ($funcionario['foto_funcionario'] ?? ''));
                                    $caminhoFisico = __DIR__ . '/../../public/uploads/' . ltrim($fotoFuncionario, '/\\');

                                    if ($fotoFuncionario !== '' && file_exists($caminhoFisico)) {
                                        $img = BASE_URL . 'uploads/' . ltrim($fotoFuncionario, '/\\');
                                    }
                                    ?>
                                    <img src="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>" alt="Foto de <?= htmlspecialchars($funcionario['nome_funcionario'], ENT_QUOTES, 'UTF-8') ?>" loading="lazy" />
                                </div>
                                <div class="product_blog_cont">
                                    <h3><?= htmlspecialchars($funcionario['nome_funcionario'], ENT_QUOTES, 'UTF-8') ?></h3>
                                    <h4><?= htmlspecialchars($funcionario['cargo'], ENT_QUOTES, 'UTF-8') ?></h4>
                                    <p><?= !empty($funcionario['especialidade']) ? htmlspecialchars($funcionario['especialidade']) : 'Especialista em cortes modernos' ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="team_description">
                    <h3>Nossa Filosofia de Trabalho</h3>
                    <p>Na Barbearia Corte & Estilo, cada barbeiro passa por um rigoroso processo seletivo e treinamento contínuo. Nossos profissionais participam anualmente de workshops e eventos internacionais para trazer as últimas tendências e técnicas para você. Acreditamos que um bom barbeiro não apenas corta cabelo, mas entende de anatomia facial, tendências de moda e, principalmente, sabe ouvir o cliente.</p>
                </div>
            </div>
        </section>
        <!-- end nossos barbeiros -->

        <?php require_once('template/rodape.php'); ?>
    </div>

    <div class="overlay"></div>

    <!-- Scripts -->
    <script src="<?= BASE_URL ?>assets/js/jquery.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/popper.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/owl.carousel.min.js"></script>
    <script src="<?= BASE_URL ?>assets/js/custom.js"></script>
    <script src="<?= BASE_URL ?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function() {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });

            $('.owl-carousel').owlCarousel({
                margin: 20,
                nav: true,
                loop: true,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    576: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });
        });
    </script>

</body>

</html>